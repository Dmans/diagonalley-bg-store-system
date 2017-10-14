<?php
    /**
     * dia_barcode table data access object
     */
    class Dia_barcode_dao extends MY_Model {
        
        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_barcode"; // Table name
            $this->pk="bar_num"; // Primary key
            $this->value_conditions = array("bar_code");
            $this->string_conditions = array("act_name"); // Field for "LIKE" criteria
            $this->custom_value_conditions= array("act_type","act_status"); // Field for full text criteria
        }
        
        public function query_by_bar_code($bar_code){
            $this->db->where('bar_code',$bar_code);
            $query = $this->db->get($this->table_name);
            return generate_single_result($query);
        }
        
        public function query_by_bar_type($bar_type){
            $condition['bar_type']=$bar_type;
            return $this->query_by_condition($condition);
        }
    }
    
?>