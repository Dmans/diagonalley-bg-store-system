<?php
    /**
     * dia_table table data access object
     */
    class Dia_tables_dao extends MY_Model {

        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_tables"; // Table name
            $this->pk="dtb_num"; // Primary key
            $this->string_conditions = array("dtb_name"); // Field for "LIKE" criteria
            $this->custom_value_conditions= array("sto_num"); // Field for full text criteria
        }
        
        public function query_by_sto_num($sto_num){
            $condition['sto_num']=$sto_num;
            return $this->query_by_condition($condition);
        }
        
        protected function special_query_conditions($condition) {
            if(isset($condition["dtb_max_cap"])){
                $this->db->where("dtb_max_cap <= ",$condition["dtb_max_cap"]);
            }
        }
    }
?>