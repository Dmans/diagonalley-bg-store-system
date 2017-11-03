<?php
    /**
     * dia_game_import table data access object
     */
    class Dia_game_import_dao extends MY_Model {
        
        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_game_import"; // Table name
            $this->pk="gim_num"; // Primary key
            $this->string_conditions = array(); // Field for "LIKE" criteria
            $this->custom_value_conditions= array("usr_num", "gim_status"); // Field for full text criteria
        }
        
        protected function special_query_conditions($condition) {
            if(isset($condition["start_gim_date"])){
                $this->db->where("gim_date >= ",$condition["start_gim_date"]);
            }
            
            if(isset($condition["end_gim_date"])){
                $this->db->where("gim_date <= ",$condition["end_gim_date"]." 23:59:59");
            }
        }
        
    }
    
?>