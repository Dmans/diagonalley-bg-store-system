<?php
    /**
     *
     */
    class Automail_service extends CI_Model {

        function __construct()
        {
            parent::__construct();
            $this->load->model('dao/dia_checkin_dao');
            $this->load->model('dao/dia_user_dao');
            $this->load->model('dao/dia_user_store_permission_dao');
            $this->load->model('service/store_data_service');
            $this->load->model("constants/form_constants");
            $this->load->library('email');
        }
        
        public function get_automail_data() {
            $data = array();
            $data['chks'] = $this->find_in_progress_checkin();
            $data['uncheckin_store'] = $this->find_uncheckin_store($data['chks']);
            
            return $data;
        }

        public function find_in_progress_checkin() {

            $condition['chkin_start_time']=date('Y-m-d');
            $condition['uncheckout']=TRUE;
            $chks = $this->dia_checkin_dao->query_by_condition($condition);

            $result_set=array();
            if(count($chks)>0){

                $stores = $this->get_stores();
                foreach ($chks as $key => $chk) {
                    $user = $this->dia_user_dao->query_by_usr_num($chk->usr_num);
                    $result_set[]=$this->__assemble_user_checkin($user, $chk, $stores[$chk->sto_num]);
                }
            }

            return $result_set;
        }

        public function find_uncheckin_store($chks) {
            if ($chks == NULL) {
                $chks = $this->find_in_progress_checkin();
            }

            $stores = $this->get_stores();
            foreach ($chks as $key => $chk) {
                unset($stores[$chk->sto_num]);
            }
            print_r($stores,TRUE);
            return $stores;
        }
        
        public function get_stores() {
            return $this->store_data_service->get_real_stores();
        }
        
        public function send_afternoon_mail() {
            
            $data = $this->get_automail_data();
            
            if(count($data['uncheckin_store'])>0) {
                $unchecked_stores = $data['uncheckin_store'];
                $user_nums = array();
                foreach ($unchecked_stores as $unchecked_store) {
                    $user_store_permis = $this->dia_user_store_permission_dao->query_by_sto_num($unchecked_store->sto_num);
                    foreach($user_store_permis as $permit) {
                        $user_nums[] = $permit->usr_num;
                    }
                }
                
                $user_nums = array_unique($user_nums);
                
                $receiver = array();
                foreach ($user_nums as $usr_num) {
                    $user = $this->dia_user_dao->query_by_usr_num($usr_num);
                    
                    if(!empty($user->usr_mail)) {
                        $receiver[] = $user->usr_mail;
                    }
                }
                
                $this->send_automail($receiver, $this->load->view("automail/afternoon", $data, TRUE), '本日店鋪無人打卡警示');
            }
        }
        
        public function send_uncheckout_mail($is_send) {
            $uncheckout_list = $this->find_in_progress_checkin();
            
            foreach($uncheckout_list as $uncheckout) {
                $subject = "今日未打卡下班警示";
                $receiver = $uncheckout->usr_mail;
                $message = $this->load->view("automail/uncheckout", $uncheckout, TRUE);
                if ($is_send) {
                    if(!empty($uncheckout->usr_mail)) {
                        $this->send_automail($receiver, $message, $subject);
                    }
                } else {
                    echo $message;
                }
            }
        }
        
        private function send_automail($receiver, $message, $subject) {
            
            $this->email->from('Auto-Mail@bogamon.com', '古靈閣Auto-mail');
            $this->email->to($receiver);
            $this->email->subject($subject);
            $this->email->message($message);
            
            $this->email->send();
        }

        private function __assemble_user_checkin($user,$chk, $store){

            $result = new stdClass();
            $result->chk_num=$chk->chk_num;
            $result->usr_num=$chk->usr_num;
            $result->usr_name=$user->usr_name;
            $result->usr_mail=$user->usr_mail;
            $result->chk_in_time=$chk->chk_in_time;
            $result->chk_out_time=$chk->chk_out_time;
            $result->sto_name=$store->sto_name;
            $result->sto_num=$store->sto_num;

            return $result;
        }
    }

?>