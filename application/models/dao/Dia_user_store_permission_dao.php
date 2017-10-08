<?php
    /**
     * Dia_user_store_permission table data access object
     */
    class Dia_user_store_permission_dao extends MY_Model {

        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_user_store_permission"; // Table name
            $this->pk="usp_num"; // Primary key
            $this->string_conditions = array(); // Field for "LIKE" criteria
            $this->custom_value_conditions= array("usr_num","sto_num"); // Field for full text criteria
        }
        
        public function query_by_usr_num($usr_num){
            $condition['usr_num']=$usr_num;
            return $this->query_by_condition($condition);
        }

        public function query_by_sto_num($sto_num){
            $condition['sto_num']=$sto_num;
            return $this->query_by_condition($condition);
        }

        public function delete_by_usr_num($usr_num){
            $condition['usr_num']=$usr_num;
            return $query = $this->db->delete($this->table_name, $condition);
        }
    }

?>