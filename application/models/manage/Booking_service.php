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
            $this->load->model("dao/dia_store_dao");
            $this->load->model("constants/form_constants");
            $this->load->model("dao/dia_user_dao");
            $this->load->model("dao/dia_tables_dao");
            $this->load->model("dao/dia_booking_tables_dao");
        }

        public function save_booking($input,$usr_num){

            // 1. Insert booking data
            $data=$this->__assemble_save_booking($input, $usr_num);
            $new_dbk_num = $this->dia_booking_dao->insert($data);
            $this->seve_booking_tables($new_dbk_num, $input['dtb_num']);
            

            return $new_dbk_num;
        }

        public function find_booking($dbk_num){
            $data=$this->dia_booking_dao->query_by_dbk_num($dbk_num);
            return $this->__assemble_query_result($data);
        }

        public function find_enabled_bookings($end_dbk_date=NULL){
            $condition=NULL;
            $condition['dbk_status']=1;
            $condition["order_dbk_date"]="ASC";
            $condition["start_dbk_date"]=date('Y-m-d');

            if($end_dbk_date!=NULL){
                $condition["end_dbk_date"]=$end_dbk_date;
            }
            
            $data=$this->dia_booking_dao->query_by_condition($condition);
            return $this->__assemble_query_result_list($data);
        }
        
        public function find_bookings_list($input){
            $condition=$input;
            $condition['dbk_status']=1;
            $condition["order_dbk_date"]="ASC";
            $condition["start_dbk_date"]=date('Y-m-d');
           
            if(!empty($condition['dbk_phone'])){
                $condition['sto_num']=null;
            }
            
            $data=$this->dia_booking_dao->query_by_condition($condition);
            return $this->__assemble_query_result_list($data);
        }
        public function find_historical_list($input){
            $condition=$input;
            $condition["order_dbk_date"]="DESC";
            $condition["start_dbk_date"]= date('Y-m-d', strtotime($condition['year_month'].'-01'));
            $condition["end_dbk_date"]= date('Y-m-t', strtotime($condition['year_month'].'-01'));
            
            if(!empty($condition['dbk_phone'])){
                $condition["start_dbk_date"]=NULL;
                $condition["end_dbk_date"]=NULL;
            }
            
            $data=$this->dia_booking_dao->query_by_condition($condition);
            return $this->__assemble_query_result_list($data);
        }

        public function update_booking($input){
            $data=$this->__assemble_update_booking($input);
            $this->seve_booking_tables($input['dbk_num'], $input['dtb_num']);
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
        
        public function find_unbooking_tables($input){
            $condition_for_table= array();
            $condition_for_table['sto_num']=$input['sto_num']; 
            $table_keyset=array();
            $table_list = $this->dia_tables_dao->query_by_condition($condition_for_table);
            foreach ($table_list as $table){
                $table_keyset[]=$table->dtb_num;
            }
            // dia_booking_dao
            $condition_for_booking=array();
            $condition_for_booking['dbk_date']=$input['dbk_date'];
            if(strtotime($condition_for_booking["dbk_date"]) <= strtotime(date('Y-m-d 17:00:00',strtotime($condition_for_booking["dbk_date"])))){
                $condition_for_booking["start_dbk_date"]=date('Y-m-d ',strtotime($condition_for_booking["dbk_date"]));
                $condition_for_booking["end_dbk_date"]=date('Y-m-d 17:00:00',strtotime($condition_for_booking["dbk_date"]));
            }
            else {
                $condition_for_booking["start_dbk_date"]=date('Y-m-d 17:00:00',strtotime($condition_for_booking["dbk_date"]));
                $condition_for_booking["end_dbk_date"]=date('Y-m-d',strtotime($condition_for_booking["dbk_date"]));
            }
            $booking_list = $this->dia_booking_dao->query_by_condition($condition_for_booking);
            
            // dis_booking_tables_dao
            $booking_table_keysets=array();
            foreach ($booking_list as $row){
                $condition_by_booking_tables=array();
                $condition_by_booking_tables['dbk_num']=$row->dbk_num;
                $booking_tables_list=$this->dia_booking_tables_dao->query_by_condition($condition_by_booking_tables);
                foreach ($booking_tables_list as $booking_table){
                    $booking_table_keysets[]=$booking_table->dtb_num;
                }
                
            }
            
            $not_booking_table_keysets= array_filter($table_keyset, function ($v) use ($booking_table_keysets)
                {
                    foreach ($booking_table_keysets as $booking_table_keyset){
                        if($v == $booking_table_keyset){
                        return  false;
                        }
                    }
                    return true;
                }
            );
            $not_booking_tables=array();
            foreach($not_booking_table_keysets as $not_booking_tables_keyset){
                $not_booking_tables[] = $this->dia_tables_dao->query_by_dtb_num($not_booking_tables_keyset);
            }
            
            return $not_booking_tables;
        }
        
        public function update_checkin($input){
            $this->dia_booking_dao->update($this->__assemble_update_booking($input));
        }
//         public function update_cancel($input){
//             $dbk = new stdClass();
//             $dbk->dbK_num=$input['dbk_num'];
//             $dbk->dbk_status="3";
//             $this->dia_booking_dao->update($dbk);
//         }
        
        public function seve_booking_tables($dbk_num,$dtb_nums){
            $this->dia_booking_tables_dao->delete_by_dbk_num($dbk_num);
            
            foreach ($dtb_nums as $dtb_num) {
                $dbt = array();
                $dbt['dbk_num'] = $dbk_num;
                $dbt['dtb_num'] = $dtb_num;
                $this->dia_booking_tables_dao->insert($dbt);
            }
        }

        private function __assemble_save_booking($input,$usr_num){
            $dbk = new stdClass();
            $dbk->usr_num=$usr_num;
            $dbk->dbk_date=$input['dbk_date'];
            $dbk->dbk_name=$input['dbk_name'];
            $dbk->dbk_count=$input['dbk_count'];
            $dbk->dbk_phone=$input['dbk_phone'];
            $dbk->dbk_memo=$input['dbk_memo'];
            $dbk->dbk_status=$input['dbk_status'];
            //$dbk->dtb_num=$input['dtb_num'];
            $dbk->sto_num=$input['sto_num'];
            $dbk->register_date=date('Y-m-d H:i:s');

            return $dbk;
        }

        private function __assemble_update_booking($input){

            $dbk=new stdClass();
            $dbk->sto_num=$input['sto_num'];
            $dbk->dbk_num=$input['dbk_num'];

            if(isset($input['dbk_memo'])){
                $dbk->dbk_memo=$input['dbk_memo'];
            }

            if(isset($input['dbk_status'])){
                $dbk->dbk_status=$input['dbk_status'];
            }

            if(isset($input['dbk_date'])){
                $dbk->dbk_date=$input['dbk_date'];
            }
            
            if(isset($input['dbk_count'])){
                $dbk->dbk_count=$input['dbk_count'];
            }
            
            if(isset($input['dbk_name'])){
                $dbk->dbk_name=$input['dbk_name'];
            }
            
            if(isset($input['dbk_phone'])){
                $dbk->dbk_phone=$input['dbk_phone'];
            }
            return $dbk;
        }

        private function __assemble_view_daily($daily,$user){

            $daily->usr_name=$user->usr_name;
            $daily->ddr_status_desc=$this->form_constants->transfer_ddr_status($daily->ddr_status);
            $daily->ddr_type_desc=$this->form_constants->transfer_ddr_type($daily->ddr_type);

            return $daily;
        }
        
        private function __assemble_query_result_list($query_result){
         $output = array();
         if(!empty($query_result)){
          foreach ($query_result as $row) {
           $output[]=$this->__assemble_query_result($row);
          }
         }         
         return $output;
        }
        
        private function __assemble_query_result($row){
         $result=new stdClass();
         $result->dbk_num=$row->dbk_num;
         $result->usr_num=$row->usr_num;
         $result->dbk_date=$row->dbk_date;
         $result->dbk_name=$row->dbk_name;
         $result->dbk_count=$row->dbk_count;
         $result->dbk_phone=$row->dbk_phone;
         $result->dbk_memo=$row->dbk_memo;
         $result->dbk_status=$row->dbk_status;
         //$result->dtb_num=$row->dtb_num;
         $result->sto_num=$row->sto_num;
         $gsns = $this->dia_store_dao->query_by_pk($row->sto_num);
         $result->sto_name=$gsns->sto_name;
         $guns = $this->dia_user_dao->query_by_pk($row->usr_num);
         $result->usr_name=$guns->usr_name;
         $get_tables_nums=$this->dia_booking_tables_dao->query_by_dbk_num($row->dbk_num);
         $result->dtb_name=null;
         $result->dtb_num=null;
         foreach ($get_tables_nums as $get_tables_num){
             $result->dtb_num="$result->dtb_num"."$get_tables_num->dtb_num";
             $gtns = $this->dia_tables_dao->query_by_dtb_num($get_tables_num->dtb_num);
             $result->dtb_name="$result->dtb_name".","."$gtns->dtb_name";
         }
         log_message("debug","Booking_service.__assemble_query_result(".print_r($get_tables_nums,TRUE).") - end");
         
         log_message("debug","Booking_service.__assemble_query_result(".print_r($result,TRUE).") - end");
         
         //$gtns = $this->dia_tables_dao->query_by_dtb_num($row->dtb_num);
         //$result->dtb_name=$gtns->dtb_name;
         return $result;
         
        } 

    }

?>