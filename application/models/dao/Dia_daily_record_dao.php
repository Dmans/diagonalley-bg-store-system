<?php
    /**
     * dia_daily_record table data access object
     */
    class Dia_daily_record_dao extends MY_Model {
        
        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_daily_record"; // Table name
            $this->pk="ddr_num"; // Primary key
            $this->string_conditions = array(); // Field for "LIKE" criteria
            $this->custom_value_conditions= array("usr_num","ddr_status","ddr_type"); // Field for full text criteria
        }
        
        public function query_by_usr_num($usr_num){
            $condition['usr_num']=$usr_num;
            return $this->query_by_condition($condition);
        }
        
        protected function special_query_conditions($condition) {
            if(isset($condition["start_register_date"])){
                $this->db->where("register_date >= ",$condition["start_register_date"]);
            }
            
            if(isset($condition["end_register_date"])){
                $this->db->where("register_date <= ",$condition["end_register_date"]." 23:59:59");
            }
            
            if(isset($condition["start_modify_date"])){
                $this->db->where("modify_date >= ",$condition["start_modify_date"]);
            }
            
            if(isset($condition["end_modify_date"])){
                $this->db->where("modify_date <= ",$condition["end_modify_date"]." 23:59:59");
            }
            
            if(isset($condition["order_register_date"])){
                $this->db->order_by("register_date",$condition["order_register_date"]);
            }
            
            if(isset($condition["order_modify_date"])){
                $this->db->order_by("modify_date",$condition["order_modify_date"]);
            }
            
            if(isset($condition["not_ddr_status"])){
                $this->db->where_not_in("ddr_status",$condition["not_ddr_status"]);
            }
        }
    }
    
?>