<?php
    /**
     * dia_game_id table data access object
     */
    class Dia_game_id_dao extends MY_Model {
        
        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_game_id"; // Table name
            $this->pk="gid_num"; // Primary key
            $this->string_conditions = array(); // Field for "LIKE" criteria
            $this->custom_value_conditions= array("gid_enabled","gid_status","gid_rentable"); // Field for full text criteria
        }
    }
    
?>