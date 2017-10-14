<?php
    /**
     * dia_pos_order table data access object
     */
    class Dia_pos_order_dao extends MY_Model {
        
        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_pos_order"; // Table name
            $this->pk="pod_num"; // Primary key
            $this->value_conditions = array("tag_num");
            $this->string_conditions = array(); // Field for "LIKE" criteria
            $this->custom_value_conditions= array("pod_status"); // Field for full text criteria
        }
        
        protected function special_query_conditions($condition) {
            
            if(isset($condition["start_pod_date"])){
                $this->db->where("pod_date >= ",$condition["start_pod_date"]);
            }
            
            if(isset($condition["end_pod_date"])){
                $this->db->where("pod_date <= ",$condition["end_pod_date"]." 23:59:59");
            }
        }
    }
    
?>