<?php
    /**
     * dia_order table data access object
     */
    class Dia_order_dao extends MY_Model {
        
        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_order"; // Table name
            $this->pk="ord_num"; // Primary key
            $this->value_conditions = array("pod_num");
            $this->string_conditions = array(); // Field for "LIKE" criteria
            $this->custom_value_conditions= array("gam_num","usr_num","ord_type","ord_status"); // Field for full text criteria
        }
        
        public function query_by_gam_num($gam_num){
            $condition['gam_num']=$gam_num;
            return $this->query_by_condition($condition);
        }
        
        protected function special_query_conditions($condition) {
            if(isset($condition["start_order_date"])){
                $this->db->where("ord_date >= ",$condition["start_order_date"]);
            }
            
            if(isset($condition["end_order_date"])){
                $this->db->where("ord_date <= ",$condition["end_order_date"]." 23:59:59");
            }
        }
    }
    
?>