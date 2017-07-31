<?php
    /**
     *
     */
    class Salary_service extends CI_Model {

        function __construct()
        {
            parent::__construct();
            $this->load->model('dao/dia_salary_dao');
            $this->load->model('dao/dia_salary_stores_dao');
            $this->load->model('dao/dia_salary_options_dao');
            $this->load->model('dao/dia_user_dao');
            $this->load->model('service/store_data_service');
            $this->load->model('employ/employ_service');
            $this->load->model('service/Mail_service');
            
        }
        
        /**
         * Query part time employ checkin data by year/month
         * @param String $year_month : format 2017-06
         */
        public function get_part_time_checkin_data($year_month, $usr_num) {
            
            $check_result_list = $this->employ_service->find_part_time_employ_monthly_record($year_month, $usr_num);
            $this->__calculate_part_time_salary($check_result_list);
            
            return $check_result_list;
        }
        
        public function confirm_part_time_checkin_data($confirm_hours, $extra_options, $year_month, $usr_num) {
            
            $this->db->trans_start();
            $this->__remove_salary_data($year_month);
            
            // update checkin data
            foreach ($confirm_hours as $chk_num => $confirm_hours) {
                $input = array();
                $input['chk_num'] = $chk_num;
                $input['confirm_hours'] = $confirm_hours;
                
                $this->employ_service->confirm($input, $usr_num);
                
            }
            
            // Get part time data
            $check_result_list = $this->get_part_time_checkin_data($year_month, $usr_num);
            
            // insert to part time salary table
            foreach ($check_result_list as $check_user) {
                // Insert data to dia_salary
                $salary = $this->__assemble_salary_object($check_user, $year_month);
                $say_num = $this->dia_salary_dao->insert($salary);
                
                // Insert data to dia_salary_stores
                foreach ($check_user->stores as $store) {
                    $salary_store = $this->__assemble_salary_store_object($say_num, $store->store_data->sto_num, $store->summary);
                    $this->dia_salary_stores_dao->insert($salary_store);
                }
                
                // Insert data to dia_salary_options
                if(!empty($extra_options) AND !empty($extra_options['dso_type'][$check_user->usr_num])) {
                    $dso_types = $extra_options['dso_type'][$check_user->usr_num];
                    $dso_descs = $extra_options['dso_desc'][$check_user->usr_num];
                    $dso_values = $extra_options['dso_value'][$check_user->usr_num];
                    for ($i=0 ; $i<count($dso_types) ; $i++) {
                        $salary_option = $this->__assemble_salary_option_object($say_num, $dso_types[$i], $dso_descs[$i], $dso_values[$i]);
                        $this->dia_salary_options_dao->insert($salary_option);
                    }
                }
            }
            $this->db->trans_complete();
        }
        
        public function get_part_time_summary_data($year_month) {
            
            $query_result_list = array();
            $salary_list = $this->dia_salary_dao->query_by_say_month($year_month);
            
            $store_data_list = $this->store_data_service->get_stores();
            foreach ($salary_list as $salary) {
                $salary_stores_list = $this->dia_salary_stores_dao->query_by_say_num($salary->say_num);
                $salary_options_list = $this->dia_salary_options_dao->query_by_say_num($salary->say_num);
                $user = $this->dia_user_dao->query_by_usr_num($salary->usr_num);
                $query_result_list[] = $this->__assamble_part_time_summary_user($salary, $salary_stores_list, $salary_options_list, $store_data_list, $user);
                
            }
            
            return $query_result_list;
        }
        
        public function send_part_time_mail($year_month, $is_send) {
            
            $user_salary_list = $this->get_part_time_summary_data($year_month);
            
            foreach ($user_salary_list as $user_salary) {
                
                $subject = "{$year_month} {$user_salary->usr_name} 薪資單";
                $receiver = $user_salary->usr_mail;
                $data = array();
                $data['user_salary'] = $user_salary;
                $data['year_month'] = $year_month;
                $message = $this->load->view("salary/part_time_mail", $data, TRUE);
                if ($is_send) {
                    if(!empty($user_salary->usr_mail)) {
                        $this->Mail_service->send_automail($receiver, $message, $subject);
                    }
                } else {
                    echo $message;
                }
            }
        }
        
        private function __remove_salary_data($year_month) {
            $salarys = $this->dia_salary_dao->query_by_say_month($year_month);
            
            foreach ($salarys as $salary) {
                $this->dia_salary_stores_dao->delete_by_say_num($salary->say_num);
                $this->dia_salary_options_dao->delete_by_say_num($salary->say_num);
            }
            
            $this->dia_salary_dao->delete_by_say_month($year_month);
        }
        
        private function __assemble_salary_object($check_user, $year_month) {
            $salary = new stdClass();
            $salary->usr_num = $check_user->usr_num;
            $salary->say_extra_hours = $check_user->total_extra_hours;
            $salary->say_extra_salary = $check_user->extra_salary;
            $salary->say_month = $year_month;
            
            return $salary;
        }
        
        private function __assemble_salary_store_object($say_num, $sto_num, $summary) {
            $salary_store = new stdClass();
            $salary_store->say_num = $say_num;
            $salary_store->sto_num= $sto_num;
            $salary_store->dss_salary = $summary->base_salary;
            $salary_store->dss_hours = $summary->base_hour_summary;
            
            return $salary_store;
        }
        
        private function __assemble_salary_option_object($say_num, $dso_type, $dso_desc, $dso_value) {
            $salary_option = new stdClass();
            $salary_option->say_num = $say_num;
            $salary_option->dso_type= $dso_type;
            $salary_option->dso_desc= $dso_desc;
            $salary_option->dso_value= $dso_value;
            
            return $salary_option;
        }
        
        
        private function __calculate_part_time_salary($check_result_list) {
            //Base working hour a day is 8 hours
            foreach ($check_result_list as $check_user) {
                $total_hours = 0;
                $total_extra_hours = 0;
                $hourly_salary = $check_user->usr_salary;
                foreach ($check_user->stores as $store) {
                    $base_hour_summary = 0;
                    $extra_hour_summary = 0;
                    foreach ($store->chks as $chk) {
                        $chk->base_hours = ($chk->confirm_hours > BASE_HOURS) ? BASE_HOURS: $chk->confirm_hours;
                        $chk->extra_hours = ($chk->confirm_hours > BASE_HOURS) ? $chk->confirm_hours - BASE_HOURS: 0;
                        
                        $base_hour_summary += $chk->base_hours;
                        $extra_hour_summary+= $chk->extra_hours;
                    }
                    $store->summary->base_hour_summary = $base_hour_summary;
                    $store->summary->extra_hour_summary= $extra_hour_summary;
                    $store->summary->base_salary = round($base_hour_summary*$hourly_salary);
                    
                    $total_hours += $base_hour_summary;
                    $total_extra_hours += $extra_hour_summary;
                }
                
                $check_user->total_base_hours = $total_hours;
                $check_user->total_extra_hours = $total_extra_hours;
                
                $base_salary = round($total_hours*$hourly_salary);
                $extra_salary = round($total_extra_hours * $hourly_salary * EXTRA_SALARY_RATE);
                $check_user->base_salary = $base_salary;
                $check_user->extra_salary= $extra_salary;
                $check_user->total_salary = $base_salary + $extra_salary;
            }
        }
        
        private function __assamble_part_time_summary_user($salary, $say_store_list, $say_option_list, $store_data_list, $user) {
            $result = $salary;
            $result->usr_name = $user->usr_name;
            $result->usr_mail = $user->usr_mail;
            $summary = 0;
            
            // For payroll
            $type_a_summary = 0;
            $type_b_summary = 0;
            $type_c_summary = 0;
            
            $positive = array();
            $negative = array();
            foreach ($say_option_list as $option) {
                if ($option->dso_type == 0 OR $option->dso_type == 1) {
                    $positive[] = $option;
                    $summary += (int)$option->dso_value;
                    $type_b_summary += (int)$option->dso_value;
                }
                
                if ($option->dso_type == 2 OR $option->dso_type == 3) {
                    $negative[] = $option;
                    $summary -= (int)$option->dso_value;
                    $type_c_summary += (int)$option->dso_value;
                }
            }
            $options = new stdClass();
            $options->positive = $positive;
            $options->negative= $negative;
            
            
            $result->options = $options;
            $store_list = array();
            foreach ($say_store_list as $say_store) {
                $say_store->sto_name = $store_data_list[$say_store->sto_num]->sto_name;
                $store_list[$say_store->sto_num] = $say_store;
                $summary += (int)$say_store->dss_salary;
                $type_a_summary += (int)$say_store->dss_salary;
            }
            
            $summary += (int)$salary->say_extra_salary;
            $type_b_summary+= (int)$salary->say_extra_salary;
            $result->summary = $summary;
            $result->type_a_summary= $type_a_summary;
            $result->type_b_summary= $type_b_summary;
            $result->type_c_summary= $type_c_summary;
            
            $result->stores = $store_list;
            return $result;
        }
    }
?>
