<?php
    /**
     * dia_salary table data access object
     */
    class Dia_salary_dao extends MY_Model {
        
        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_salary";
            $this->pk="say_num";
            $this->string_conditions = array();
            $this->custom_value_conditions= array("usr_num","say_month", "say_type");
        }
        
        public function query_by_say_num($pk){
            $this->db->where($this->pk, $pk);
            $query = $this->db->get($this->table_name);
            return generate_single_result($query);
        }
        
        public function query_by_usr_num($usr_num){
            $condition['usr_num']=$usr_num;
            return $this->query_by_condition($condition);
        }
        
        public function query_by_say_month($say_month) {
            $condition['say_month']=$say_month;
            return $this->query_by_condition($condition);
        }
        
        public function delete_by_say_month($say_month) {
            $condition['say_month'] = $say_month;
            return $query = $this->db->delete($this->table_name, $condition);
        }
        
        public function delete_by_say_month_and_say_type($say_month, $say_type) {
            $condition['say_month'] = $say_month;
            $condition['say_type'] = $say_type;
            return $query = $this->db->delete($this->table_name, $condition);
        }
    }
    
?>