<?php
    /**
     * dia_fast_pos table data access object
     */
    class Dia_fast_pos_dao extends MY_Model {
        
        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_fast_pos"; // Table name
            $this->pk="pfs_num"; // Primary key
            $this->value_conditions = array("tag_num");
            $this->string_conditions = array(); // Field for "LIKE" criteria
            $this->custom_value_conditions= array("pfs_visible"); // Field for full text criteria
        }
        
        public function query_by_tag_num($tag_num){
            $condition['tag_num']=$tag_num;
            return $this->query_by_condition($condition);
        }
        
        protected function special_query_conditions($condition) {
            if(isset($condition["order_pfs_order"])){
                $this->db->order_by("pfs_order",$condition["order_pfs_order"]);
            }
        }
    }
    
?>