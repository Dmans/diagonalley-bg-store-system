<?php
    /**
     * dia_tag table data access object
     */
    class Dia_tag_dao extends MY_Model {
        
        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_tag"; // Table name
            $this->pk="tag_num"; // Primary key
            $this->string_conditions = array("tag_name"); // Field for "LIKE" criteria
            $this->custom_value_conditions= array("tag_type","tag_status"); // Field for full text criteria
        }
        
        public function query_by_tag_type($tag_type){
            $condition['tag_type']=$tag_type;
            return $this->query_by_condition($condition);
        }
        
        protected function special_query_conditions($condition) {
            if(isset($condition["order_tag_name"]) && $condition["order_tag_name"]==TRUE){
                $this->db->order_by("tag_name",$condition["order_tag_name"]);
            }
        }
    }
    
?>