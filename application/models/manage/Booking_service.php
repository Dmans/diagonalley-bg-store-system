<?php
    /**
     *
     */
    class Booking_service extends CI_Model {

        function __construct()
        {
            parent::__construct();
            $this->load->model('dao/dia_booking_dao');
            $this->load->model('dao/dia_booking_table_dao');
            $this->load->model("constants/form_constants");
        }

        public function save_booking($input,$usr_num){

            // 1. Insert booking data
            $data=$this->__assemble_save_booking($input, $usr_num);
            $new_dbk_num = $this->dia_booking_dao->insert($data);

            //2. Insert booking and table relation data
            foreach ($$input['dtb_nums'] as $key => $dtb_num) {
                $table_data=$this->__assemble_save_booking_table($dtb_num, $new_dbk_num);
                $this->dia_booking_table_dao->insert($table_data);
            }

            return $new_dbk_num;
        }

        public function find_booking($dbk_num){
            return $this->dia_booking_dao->query_by_dbk_num($dbk_num);
        }

        public function find_enabled_bookings($end_dbk_date=NULL){
            $condition=NULL;
            $condition['dbk_status']=1;
            $condition["order_dbk_date"]="ASC";
            $condition["start_dbk_date"]=date('Y-m-d');

            if($end_dbk_date!=NULL){
                $condition["end_dbk_date"]=$end_dbk_date;
            }

            return $this->dia_booking_dao->query_by_condition($condition);

        }

        public function update_booking($input){
            $data=$this->__assemble_update_booking($input);
            $this->dia_booking_dao->update($data);
        }






        public function find_dailys($usr_num=NULL){
            return $this->find_daily_record_for_list(FALSE,$usr_num);
        }

        public function find_ontop_dailys(){
            return $this->find_daily_record_for_list(TRUE,NULL);
        }

        public function find_daily_record_for_list($is_ontop=FALSE,$usr_num=NULL){

            /*
             * step1. 判斷是否傳入usr_num
             * 有-撈出該使用者所有公告紀錄
             * 無-撈出查詢日3個月內公告紀錄
             */
            $condition=NULL;
            $condition['order_register_date']="DESC";

            if($usr_num==NULL){
                $today= date('Y-m-d H:i:s');
                $three_month_ago = date('Y-m-d H:i:s',strtotime("now -1 month"));
                $condition['start_modify_date']=$three_month_ago;
                $condition['end_modify_date']=$today;
                $condition['ddr_status']=1; //只撈顯示的
                $condition['ddr_type']=($is_ontop)?1:0; //撈取置頂或一般公告
            }else{
                $condition['usr_num']=$usr_num;
                $condition['not_ddr_status']=2; //不撈停用的
            }

            $dailys = $this->dia_daily_record_dao->query_by_condition($condition);

            // step2. 組dailys所需資訊
            $users=array();
            foreach ($dailys as $daily) {

                if(count($users)<=0 || !array_key_exists($daily->usr_num, $users)){
                    $users[$daily->usr_num]=$this->user_data_service->find_user($daily->usr_num);
                }

                $daily = $this->__assemble_view_daily($daily, $users[$daily->usr_num]);
            }


            return $dailys;
        }




        private function __assemble_save_booking($input,$usr_num){
            $dbk->usr_num=$usr_num;
            $dbk->dbk_date=$input['dbk_date'];
            $dbk->dbk_cus_name=$input['dbk_cus_name'];
            $dbk->dbk_cus_phone=$input['dbk_cus_phone'];
            $dbk->dbk_content=$input['dbk_content'];
            $dbk->dbk_status=$input['dbk_status'];
            $dbk->register_date=date('Y-m-d H:i:s');

            return $dbk;
        }

        private function __assemble_save_booking_table($dtb_num, $new_dbk_num){
            $dbt->dbk_num=$new_dbk_num;
            $dbt->dtb_num=$dtb_num;
            $dbt->dbk_num=$dtb_num;

            return $dbt;
        }

        private function __assemble_update_booking($input){

            $dbk->dbk_num=$input['dbk_num'];

            if(isset($input['dbk_content'])){
                $dbk->dbk_content=$input['dbk_content'];
            }

            if(isset($input['dbk_status'])){
                $dbk->dbk_status=$input['dbk_status'];
            }

            if(isset($input['dbk_date'])){
                $dbk->dbk_date=$input['dbk_date'];
            }

            return $dbk;
        }

        private function __assemble_view_daily($daily,$user){

            $daily->usr_name=$user->usr_name;
            $daily->ddr_status_desc=$this->form_constants->transfer_ddr_status($daily->ddr_status);
            $daily->ddr_type_desc=$this->form_constants->transfer_ddr_type($daily->ddr_type);

            return $daily;
        }

    }

?>