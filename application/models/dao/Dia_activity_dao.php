<?php
    /**
     * dia_activity table data access object
     */
    class Dia_activity_dao extends MY_Model {
        
        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_activity"; // Table name
            $this->pk="act_num"; // Primary key
            $this->string_conditions = array("act_name"); // Field for "LIKE" criteria
            $this->custom_value_conditions= array("act_type","act_status"); // Field for full text criteria
        }
        
        public function query_all(){
            $query = $this->db->get($this->table_name);
            return generate_result_list($query);
        }
        
        public function query_by_act_type($act_type){
            $condition['act_type']=$act_type;
            return $this->query_by_condition($condition);
        }
    }
    
?>