<?php
/**
 * Dia_user_store_permission table data access object
 */
    class Dia_booking_tables_dao extends MY_Model {
        
        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_booking_tables"; // Table name
            $this->pk="dbt_num"; // Primary key
            $this->string_conditions = array(); // Field for "LIKE" criteria
            $this->custom_value_conditions= array("dbk_num","dtb_num"); // Field for full text criteria
        }
        
        public function query_by_dbk_num($dbk_num){
            $condition['dbk_num']=$dbk_num;
            return $this->query_by_condition($condition);
        }
        
        public function query_by_dtb_num($dtb_num){
            $condition['dtb_num']=$dtb_num;
            return $this->query_by_condition($condition);
        }
        
        public function delete_by_dbk_num($dbk_num){
            $condition['dbk_num']=$dbk_num;
            return $query = $this->db->delete($this->table_name, $condition);
        }
    }

?>