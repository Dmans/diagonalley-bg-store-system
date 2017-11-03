<?php
    /**
     * dia_game_id_record table data access object
     */
    class Dia_game_id_record_dao extends MY_Model {
        
        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_game_id_record"; // Table name
            $this->pk="grd_num"; // Primary key
            $this->string_conditions = array(); // Field for "LIKE" criteria
            $this->custom_value_conditions= array("gid_num","grd_susr_num","grd_eusr_num"); // Field for full text criteria
        }
        
        protected function special_query_conditions($condition) {
            if(isset($condition["grd_start_time"])){
                $this->db->where("grd_start_time > ",$condition["grd_start_time"]);
            }
            
            if(isset($condition["grd_end_time"])){
                $this->db->where("grd_end_time < ",$condition["grd_end_time"]);
            }
            
            if(isset($condition["null_grd_end_time"])){
                $this->db->where("grd_end_time is null");
            }
        }
    }
    
?>