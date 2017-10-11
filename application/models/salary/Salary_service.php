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
            $this->load->model('dao/dia_salary_default_options_dao');
            $this->load->model('dao/dia_user_dao');
            $this->load->model('service/store_data_service');
            $this->load->model('employ/employ_service');
            $this->load->model('service/Mail_service');
            
        }
        
        public function get_checkin_data($year_month, $usr_num, $say_type) {
            if ($say_type ==SAY_TYPE_PART_TIME) {
                return $this->get_part_time_checkin_data($year_month, $usr_num);
            } else if ($say_type == SAY_TYPE_EMPLOYEE) {
                return $this->get_employee_checkin_data($year_month, $usr_num);
            }
        }
        
        /**
         * Query part time employ checkin data by year/month
         * @param String $year_month : format 2017-06
         */
        public function get_part_time_checkin_data($year_month, $usr_num) {
            
            $check_result_list = $this->employ_service->find_part_time_employ_monthly_record($year_month, $usr_num);
            $this->__calculate_salary($year_month, $check_result_list);
            
            return $check_result_list;
        }
        
        /**
         * Query employee checkin data by year/month
         * @param String $year_month : format 2017-06
         */
        public function get_employee_checkin_data($year_month, $usr_num) {
            
            $check_result_list = $this->employ_service->find_employee_monthly_record($year_month, $usr_num);
            $this->__calculate_salary($year_month, $check_result_list);
            
            return $check_result_list;
        }
        
        public function confirm_checkin_data($confirm_hours, $extra_options, $year_month, $usr_num, $say_type) {
            
            $this->db->trans_start();
            $this->__remove_salary_data($year_month, $say_type);
            
            // update checkin data
            foreach ($confirm_hours as $chk_num => $confirm_hour) {
                $this->__update_checkin_hour($chk_num, $confirm_hour, $usr_num);
            }
            
            // Get part time data
            $check_result_list = $this->get_checkin_data($year_month, $usr_num, $say_type);
            
            // insert to part time salary table
            foreach ($check_result_list as $check_user) {
                // Insert data to dia_salary
                $salary = $this->__assemble_salary_object($check_user, $year_month, $say_type);
                $say_num = $this->dia_salary_dao->insert($salary);
                $salary->say_num = $say_num;
                
                // Insert data to dia_salary_stores
                foreach ($check_user->stores as $store) {
                    $salary_store = $this->__assemble_salary_store_object($say_num, $store->store_data->sto_num, $store->summary, $say_type);
                    $this->dia_salary_stores_dao->insert($salary_store);
                }
                
                // Insert data to dia_salary_options
                $option_list = $this->__convert_salary_option_from_rawdata($extra_options, $check_user->usr_num);
                $this->__insert_salary_options($option_list, $say_num);
                
                // Update dia_salary_say_total_salary
                $this->__update_total_salary($salary, $check_user, $option_list);
            }
            $this->db->trans_complete();
        }
        
        public function confirm_part_time_checkin_data($confirm_hours, $extra_options, $year_month, $usr_num) {
            $say_type = 0;
            $this->confirm_checkin_data($confirm_hours, $extra_options, $year_month, $usr_num, $say_type);
        }
        
        public function confirm_employee_checkin_data($confirm_hours, $extra_options, $year_month, $usr_num) {
            $say_type = 1;
            $this->confirm_checkin_data($confirm_hours, $extra_options, $year_month, $usr_num, $say_type);
        }
        
        public function get_summary_data($year_month, $say_type) {
            
            $query_result_list = array();
            
            $condition = array();
            $condition['say_month'] = $year_month;
            $condition['say_type'] = $say_type;
            $salary_list = $this->dia_salary_dao->query_by_condition($condition);
            
            $store_data_list = $this->store_data_service->get_stores();
            foreach ($salary_list as $salary) {
                $salary_stores_list = $this->dia_salary_stores_dao->query_by_say_num($salary->say_num);
                $salary_options_list = $this->dia_salary_options_dao->query_by_say_num($salary->say_num);
                $user = $this->dia_user_dao->query_by_pk($salary->usr_num);
                
                if ($say_type == SAY_TYPE_PART_TIME) {
                    $query_result_list[] = $this->__assemble_part_time_summary_user($salary, $salary_stores_list, $salary_options_list, $store_data_list, $user);
                }
                
                if ($say_type == SAY_TYPE_EMPLOYEE) {
                    $query_result_list[] = $this->__assemble_employee_summary_user($salary, $salary_stores_list, $salary_options_list, $store_data_list, $user, $year_month);
                }
            }
            
            return $query_result_list;
        }
        
        public function get_part_time_summary_data($year_month) {
            $say_type = 0;
            return $this->get_summary_data($year_month, $say_type);
        }
        
        public function get_employee_summary_data($year_month) {
            $say_type = 1;
            return $this->get_summary_data($year_month, $say_type);
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
        
        public function send_employee_mail($year_month, $is_send) {
            
            $user_salary_list = $this->get_employee_summary_data($year_month);
            
            foreach ($user_salary_list as $user_salary) {
                
                $subject = "{$year_month} {$user_salary->usr_name} 薪資單";
                $receiver = $user_salary->usr_mail;
                $data = array();
                $data['user_salary'] = $user_salary;
                $data['year_month'] = $year_month;
                $message = $this->load->view("salary/employee_mail", $data, TRUE);
                if ($is_send) {
                    if(!empty($user_salary->usr_mail)) {
                        $this->Mail_service->send_automail($receiver, $message, $subject);
                    }
                } else {
                    echo $message;
                }
            }
        }
        
        
        
        public function get_salary_default_options() {
            return object_sorter($this->dia_salary_default_options_dao->query_all(), "dsdo_type");
        }
        
        private function __remove_salary_data($year_month, $say_type) {
            $salarys = $this->dia_salary_dao->query_by_say_month($year_month);
            
            foreach ($salarys as $salary) {
                $this->dia_salary_stores_dao->delete_by_say_num($salary->say_num);
                $this->dia_salary_options_dao->delete_by_say_num($salary->say_num);
            }
            
            $this->dia_salary_dao->delete_by_say_month_and_say_type($year_month, $say_type);
        }
        
        private function __update_checkin_hour($chk_num, $confirm_hours, $usr_num) {
            $input = array();
            $input['chk_num'] = $chk_num;
            $input['confirm_hours'] = $confirm_hours;
            
            $this->employ_service->confirm($input, $usr_num);
        }
        
        private function __insert_salary_options($option_list, $say_num) {
            foreach ($option_list as $option) {
                $salary_option = $this->__assemble_salary_option_object($say_num, $option->dso_type, $option->dso_desc, $option->dso_value);
                $this->dia_salary_options_dao->insert($salary_option);
            }
        }
        
        private function __update_total_salary($salary, $check_user, $say_option_list) {
            $option_summary = $this->__assemble_summary_options($say_option_list);
            $option_total_value = $option_summary->positive_total_value - $option_summary->negative_total_value;
            if ($salary->say_type == SAY_TYPE_PART_TIME) {
                $salary->say_total_salary = $check_user->total_salary + $option_total_value;
            }
            
            if ($salary->say_type == SAY_TYPE_EMPLOYEE) {
                $salary->say_total_salary = $check_user->usr_monthly_salary + $option_total_value;
            }
            
            $this->dia_salary_dao->update($salary);
            
        }
        
        private function __convert_salary_option_from_rawdata($extra_options, $usr_num) {
            $salary_options = array();
            if(!empty($extra_options) AND !empty($extra_options['dso_type'][$usr_num])) {
                
                $dso_types = $extra_options['dso_type'][$usr_num];
                $dso_descs = $extra_options['dso_desc'][$usr_num];
                $dso_values = $extra_options['dso_value'][$usr_num];
                for ($i=0 ; $i<count($dso_types) ; $i++) {
                    $option_object = new stdClass();
                    $option_object->dso_type = $dso_types[$i];
                    $option_object->dso_desc= $dso_descs[$i];
                    $option_object->dso_value= $dso_values[$i];
                    
                    $salary_options[] = $option_object;
                }
            }
            
            return $salary_options;
        }
        
        
        
        private function __assemble_salary_object($check_user, $year_month, $say_type) {
            $salary = new stdClass();
            $salary->usr_num = $check_user->usr_num;
            $salary->say_type= $say_type;
            $salary->say_month = $year_month;
//             $salary->say_total_salary = $check_user->total_salary;
            
            if ($say_type == SAY_TYPE_PART_TIME) {
                $salary->say_extra_hours = $check_user->total_extra_hours;
                $salary->say_extra_salary = $check_user->extra_salary;
            }
            
            if ($say_type == SAY_TYPE_EMPLOYEE) {
                $salary->say_leave_balance = $check_user->say_leave_balance;
            }
            
            return $salary;
        }
        
        private function __assemble_salary_store_object($say_num, $sto_num, $summary, $say_type) {
            $salary_store = new stdClass();
            $salary_store->say_num = $say_num;
            $salary_store->sto_num= $sto_num;
            
            // part time
            if ($say_type == 0) {
                $salary_store->dss_salary = $summary->base_salary;
                $salary_store->dss_hours = $summary->base_hour_summary;
            }
            
            // employee
            if ($say_type == 1) {
                $salary_store->dss_hours = $summary->total_hour_summary;
            }
            
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
        
        
        private function __calculate_salary($year_month, $check_result_list) {
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
                        $extra_hour_summary += $chk->extra_hours;
                    }
                    $store->summary->base_hour_summary = $base_hour_summary;
                    $store->summary->extra_hour_summary= $extra_hour_summary;
                    $store->summary->total_hour_summary= $base_hour_summary + $extra_hour_summary;
                    $store->summary->base_salary = round($base_hour_summary*$hourly_salary);
                    
                    $total_hours += $base_hour_summary;
                    $total_extra_hours += $extra_hour_summary;
                }
                
                $check_user->previous_say_leave_balance = $this->__get_previous_leave_balance($year_month, $check_user->usr_num);
                
                $check_user->say_leave_balance = 
                    $total_hours + $total_extra_hours + $check_user->previous_say_leave_balance - $check_user->usr_base_hours;
                    echo $total_hours." ";
                    echo $total_extra_hours." ";
                    echo $check_user->previous_say_leave_balance." ";
                    echo $check_user->usr_base_hours." ";
                $check_user->total_base_hours = $total_hours;
                $check_user->total_extra_hours = $total_extra_hours;
                
                $base_salary = round($total_hours * $hourly_salary);
                $extra_salary = round($total_extra_hours * $hourly_salary * EXTRA_SALARY_RATE);
                $check_user->base_salary = $base_salary;
                $check_user->extra_salary= $extra_salary;
                $check_user->total_salary = $base_salary + $extra_salary;
            }
        }
        
        private function __get_previous_leave_balance ($year_month, $usr_num) {
            $previous_month = date( "Y-m", strtotime( "$year_month -1 month" ) );
            $condition = array();
            $condition['say_month'] = $previous_month;
            $condition['usr_num'] = $usr_num;
            $previous_month_salary = $this->dia_salary_dao->query_by_condition($condition);
            return (count($previous_month_salary) == 1)? $previous_month_salary[0]->say_leave_balance : 0;
        }
        
        private function __assemble_summary_user($salary, $say_store_list, $say_option_list, $store_data_list, $user) {
            $result = $salary;
            $result->usr_name = $user->usr_name;
            $result->usr_mail = $user->usr_mail;
            $result->usr_monthly_salary = $user->usr_monthly_salary;
            
            // For payroll
            $type_a_summary = 0;
            $type_b_summary = 0;
            $type_c_summary = 0;
            
            $options = $this->__assemble_summary_options($say_option_list);
            $result->options = $options;
            $type_b_summary += $options->positive_total_value;
            $type_c_summary += $options->negative_total_value;
            
            $summary_stores = $this->__assemble_summary_stores($say_store_list, $store_data_list);
            
            
            if ($salary->say_type == SAY_TYPE_PART_TIME) {
                $type_a_summary += $summary_stores->store_total_value;
            }
            
            if ($salary->say_type == SAY_TYPE_EMPLOYEE) {
                $type_a_summary += $user->usr_monthly_salary;
            }
            
            $result->summary = $type_a_summary + $type_b_summary - $type_c_summary;
            $result->type_a_summary= $type_a_summary;
            $result->type_b_summary= $type_b_summary;
            $result->type_c_summary= $type_c_summary;
            
            $result->stores = $summary_stores->store_list;
            return $result;
        }
        
        private function __assemble_part_time_summary_user($salary, $say_store_list, $say_option_list, $store_data_list, $user) {
            $result = $this->__assemble_summary_user($salary, $say_store_list, $say_option_list, $store_data_list, $user);
            
            $result->type_b_summary += (int)$salary->say_extra_salary;
            $result->summary += (int)$salary->say_extra_salary;
            
            return $result;
        }
        
        private function __assemble_employee_summary_user($salary, $say_store_list, $say_option_list, $store_data_list, $user, $year_month) {
            $result = $this->__assemble_summary_user($salary, $say_store_list, $say_option_list, $store_data_list, $user);
            $result->previous_say_leave_balance = $this->__get_previous_leave_balance($year_month, $user->usr_num);
            
            $total_confirm_hours= 0;
            foreach ($say_store_list as $say_store) {
                $total_confirm_hours += $say_store->dss_hours;
            }
            
            $result->total_confirm_hours = $total_confirm_hours;
            
            return $result;
        }
        
        private function __assemble_summary_options($say_option_list) {
            $positive = array();
            $negative = array();
            $positive_value = 0;
            $negative_value = 0;
            foreach ($say_option_list as $option) {
                if ($option->dso_type == 0 OR $option->dso_type == 1) {
                    $positive[] = $option;
                    $positive_value+= (int)$option->dso_value;
                }
                
                if ($option->dso_type == 2 OR $option->dso_type == 3) {
                    $negative[] = $option;
                    $negative_value+= (int)$option->dso_value;
                }
            }
            $options = new stdClass();
            $options->positive = $positive;
            $options->negative = $negative;
            $options->positive_total_value = $positive_value;
            $options->negative_total_value = $negative_value;
            
            return $options;
        }
        
        private function __assemble_summary_stores($say_store_list, $store_data_list) {
            $store_list = array();
            $store_total_value = 0;
            foreach ($say_store_list as $say_store) {
                $say_store->sto_name = $store_data_list[$say_store->sto_num]->sto_name;
                $store_list[$say_store->sto_num] = $say_store;
                $store_total_value += (int)$say_store->dss_salary;
            }
            
            $result = new stdClass();
            $result->store_list = $store_list;
            $result->store_total_value = $store_total_value;
            
            return $result;
        }
    }
?>
