<?php
    /**
     * dia_salary_stores table data access object
     */
    class Dia_salary_stores_dao extends MY_Model {
        
        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_salary_stores"; // Table name
            $this->pk="dss_num"; // Primary key
            $this->string_conditions = array(); // Field for "LIKE" criteria
            $this->custom_value_conditions= array("say_num"); // Field for full text criteria
        }
        
        public function query_by_say_num($say_num){
            $condition['say_num']=$say_num;
            return $this->query_by_condition($condition);
        }
        
        public function delete_by_say_num($say_num){
            $condition['say_num']=$say_num;
            return $query = $this->db->delete($this->table_name, $condition);
        }
        
    }
    
?>