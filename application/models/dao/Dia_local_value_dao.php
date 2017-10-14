<?php
    /**
     * dia_local_value table data access object
     */
    class Dia_local_value_dao extends MY_Model {
        
        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_local_value"; // Table name
            $this->pk="dlv_num"; // Primary key
            $this->value_conditions = array("dlv_enabled");
            $this->string_conditions = array(); // Field for "LIKE" criteria
            $this->custom_value_conditions= array("dlv_id"); // Field for full text criteria
        }
        
        public function query_by_dlv_id($dlv_id){
            $condition['dlv_id']=$dlv_id;
            return $this->query_by_condition($condition);
        }
        
        public function delete_by_dlv_id($dlv_id){
            $this->db->where("dlv_id",$dlv_id);
            $this->db->delete($this->table_name);
        }
    }
    
?>