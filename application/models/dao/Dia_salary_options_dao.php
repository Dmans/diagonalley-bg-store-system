<?php
    /**
     * dia_salary_options table data access object
     */
    class Dia_salary_options_dao extends MY_Model {
        
        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_salary_options";
            $this->pk="dso_num";
            $this->string_conditions = array();
            $this->custom_value_conditions= array("say_num");
        }
        
        public function query_by_dso_num($pk){
            $this->db->where($this->pk, $pk);
            $query = $this->db->get($this->table_name);
            return generate_single_result($query);
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