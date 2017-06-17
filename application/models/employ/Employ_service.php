<?php
    /**
     *
     */
    class Employ_service extends CI_Model {

        function __construct()
        {
            parent::__construct();
            $this->load->model('dao/dia_checkin_dao');
            $this->load->model('dao/dia_user_dao');
            $this->load->model('dao/dia_user_store_permission_dao');
            $this->load->model('service/store_data_service');
            $this->load->model("constants/form_constants");
        }


        public function check_in($usr_num, $sto_num){
            $chk_num = $this->dia_checkin_dao->insert($this->__assemble_save_checkin($usr_num, $sto_num));

            return $this->dia_checkin_dao->query_by_chk_num($chk_num);
        }

        public function check_unfinished_checkin($usr_num){
            $chks=$this->find_user_check_list($usr_num);

            foreach($chks as $row){
                if(!isset($row->chk_out_time)){
                    return TRUE;
                }
            }

            return FALSE;
        }

        public function check_out($chk_num,$usr_num, $chk_note){
            $chk = $this->dia_checkin_dao->query_by_chk_num($chk_num);

            if(isset($chk)){
                if($chk->usr_num == $usr_num){
                    $this->dia_checkin_dao->update($this->__assemble_update_checkin($chk_num, $chk_note));
                    return TRUE;
                }
            }

            return FALSE;

        }

        public function confirm($input,$usr_num){

            $chk = $this->dia_checkin_dao->query_by_chk_num($input['chk_num']);

            if(isset($chk)){
                if($chk->confirm_date==NULL){
                    $this->dia_checkin_dao->update($this->__assemble_update_confirm($input,$usr_num));
                    return TRUE;
                }
            }

            return FALSE;

        }

        public function find_unconfirmed_list($usr_num){
            $chks = array();

            if($usr_num != null) {
                $usp_array = $this->dia_user_store_permission_dao->query_by_usr_num($usr_num);

                $condition['unconfirmed']=TRUE;
                foreach ($usp_array as $key => $usp) {
                    $condition['sto_num']=$usp->sto_num;

                    $chk = $this->dia_checkin_dao->query_by_condition($condition);
                    if (!empty($chk)) {
                        $chks = array_merge($chks, $chk);
                    }
                }
            }

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


        public function find_user_check_list($usr_num){
            return $this->dia_checkin_dao->query_by_usr_num($usr_num);
        }

        public function find_user_check_interval($chkin_start_time, $chkin_end_time, $usr_num=NULL, $sto_num=NULL){

            $condition=array();
            if($usr_num != NULL){
                $condition['usr_num']=$usr_num;
            }
            if($sto_num != NULL){
                $condition['sto_num']=$sto_num;
            }
            $condition['chkin_start_time']=$chkin_start_time;
            $condition['chkin_end_time']=$chkin_end_time;

            return $this->dia_checkin_dao->query_by_condition($condition);
        }

        public function find_user_check_list_by_month($usr_num, $month){

            $condition=array();
            if($usr_num != NULL){
                $condition['usr_num']=$usr_num;
            }
            $condition['chkin_start_time']=$chk_start_time;
            $condition['chkin_end_time']=$chk_end_time;

            return $this->dia_checkin_dao->query_by_condition($condition);
        }

        public function find_employ_monthly_record($year_month, $usr_num){

            // step1. 取得所選區間打卡紀錄
            // Find search user store permission
            $usp_array = $this->dia_user_store_permission_dao->query_by_usr_num($usr_num);
            
            $chk_start_date = date('Y-m-d', strtotime($year_month.'-01'));
            $chk_end_date = date('Y-m-t', strtotime($year_month.'-01'));

            $source_chks = array();
            foreach ($usp_array as $key => $usp) {
                $chk = $this->find_user_check_interval($chk_start_date, $chk_end_date, null, $usp->sto_num);
                if (!empty($chk)) {
                    $source_chks = array_merge($source_chks, $chk);
                }

            }

            $chks = array();

            // step2. 計算打卡時數
            if(!empty($source_chks)){
                foreach ($source_chks as $chk) {
                    if($chk->chk_out_time != NULL){
                        $start_time=strtotime($chk->chk_in_time);
                        $end_time=strtotime($chk->chk_out_time);
                        $chk->interval=$this->__calculate_time_interval($chk->chk_in_time,$chk->chk_out_time);
                        $chks[]=$chk;
                    }
                }
            }

            // step3. 找出打卡使用者，綁定打卡資料
            $stores = $this->get_stores();
            $checked_users=array();
            if(!empty($chks)){
                foreach ($chks as $chk) {
                    if(!array_key_exists($chk->usr_num, $checked_users)){
                        $checked_users[$chk->usr_num]=$this->dia_user_dao->query_by_usr_num($chk->usr_num);
                    }

                    $checked_users[$chk->usr_num]->stores[$chk->sto_num]->chks[]=$chk;
                    $checked_users[$chk->usr_num]->stores[$chk->sto_num]->store_data=$stores[$chk->sto_num];
                }
            }

            // step4. 計算總時數
            foreach($checked_users as $chk_user){
                $total_hours=0;
                $total_confirm_hours=0;
                foreach ($chk_user->stores as $store) {

                    //計算各店舖小計
                    $store->summary = $this->__calculate_summary($store->chks);

                    $total_hours += $store->summary->total_hours;
                    $total_confirm_hours += $store->summary->total_confirm_hours;
                }

                $chk_user->total_hours=$total_hours;
                $chk_user->total_confirm_hours=$total_confirm_hours;
            }

            return $checked_users;
        }

        public function get_stores() {
            return $this->store_data_service->get_stores();
        }

        private function __assemble_save_checkin($usr_num, $sto_num){
            $chk = new stdClass();
            $chk->usr_num=$usr_num;
            $chk->sto_num=$sto_num;
            $chk->chk_in_time=date('Y-m-d H:i:s');
            return $chk;
        }

        private function __assemble_update_checkin($chk_num, $chk_note){
            $chk = new stdClass();
            $chk->chk_num=$chk_num;
            if (!empty($chk_note)) {
                $chk->chk_note=$chk_note;
            }

            $chk->chk_out_time=date('Y-m-d H:i:s');
            return $chk;
        }

        private function __assemble_update_confirm($input,$usr_num){
            $chk = new stdClass();
            $chk->chk_num=$input['chk_num'];
            // $chk->chk_out_time=$input['chk_out_time'];
            $chk->confirm_hours=$input['confirm_hours'];
            $chk->confirm_usr_num=$usr_num;
            $chk->confirm_date=date('Y-m-d H:i:s');

            if (!empty($input['confirm_note'])) {
                $chk->confirm_note = $input['confirm_note'];
            }

            return $chk;
        }

        private function __assemble_user_checkin($user,$chk, $store){
            $result = new stdClass();
            $result->chk_num=$chk->chk_num;
            $result->usr_num=$chk->usr_num;
            $result->usr_name=$user->usr_name;
            $result->chk_in_time=$chk->chk_in_time;
            $result->sto_name=$store->sto_name;
            if(isset($chk->chk_out_time)){
                $result->chk_out_time=$chk->chk_out_time;
                $result->interval=$this->__calculate_time_interval($chk->chk_in_time, $chk->chk_out_time);
            }

            $result->chk_note=$chk->chk_note;

            return $result;

        }

        private function __calculate_time_interval($str_start_time,$str_end_time){
            $start_time=strtotime($str_start_time);
            $end_time=strtotime($str_end_time);
            $real_interval=round((($end_time-$start_time)/3600),1);
            return (floor($real_interval*2))/2;
        }

        private function __calculate_summary($chks) {

                $total_hours=0;
                $total_confirm_hours=0;
                foreach($chks as $chk){
                    $total_hours += $chk->interval;
                    $total_confirm_hours+=$chk->confirm_hours;
                }
                $result = new stdClass();
                $result->total_hours=$total_hours;
                $result->total_confirm_hours=$total_confirm_hours;

                return $result;
        }

    }

?>