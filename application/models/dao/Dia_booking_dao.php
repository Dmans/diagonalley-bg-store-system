<?php
    /**
     * dia_booking table data access object
     */
    class Dia_booking_dao extends MY_Model {
        
        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_booking"; // Table name
            $this->pk="dbk_num"; // Primary key
            $this->string_conditions = array("dbk_name","dbk_phone","dbk_memo"); // Field for "LIKE" criteria
            $this->custom_value_conditions= array("usr_num","dbk_status","dbk_count","dtb_num","sto_num"); // Field for full text criteria
        }
        
        public function query_by_usr_num($usr_num){
            $condition['usr_num']=$usr_num;
            return $this->query_by_condition($condition);
        }
        
        public function query_by_sto_num($sto_num){
            $condition['sto_num']=$sto_num;
            return $this->query_by_condition($condition);
        }
        
        public function query_by_dbk_date_interval($start_date,$end_date=NULL){
            $condition['start_dbk_date']=$start_date;
            if($end_date!=NULL){
                $condition['end_dbk_date']=$end_date;
            }
            
            return $this->query_by_condition($condition);
        }
        
        protected function special_query_conditions($condition) {
            if(isset($condition["start_dbk_date"])){
                $this->db->where("dbk_date >= ",$condition["start_dbk_date"]);
            }
            
            if(isset($condition["end_dbk_date"])){
                $this->db->where("dbk_date <= ",$condition["end_dbk_date"]." 23:59:59");
            }
            
            if(isset($condition["order_dbk_date"])){
                $this->db->order_by("dbk_date",$condition["order_dbk_date"]);
            }
            
            if(isset($condition["order_register_date"])){
                $this->db->order_by("register_date",$condition["order_register_date"]);
            }
            
            if(isset($condition["order_modify_date"])){
                $this->db->order_by("modify_date",$condition["order_modify_date"]);
            }
            
            if(isset($condition["not_dbk_status"])){
                $this->db->where_not_in("dbk_status",$condition["not_dbk_status"]);
            }
        }
        
    }
    
?>