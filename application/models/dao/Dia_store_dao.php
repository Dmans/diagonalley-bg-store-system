<?php
    /**
     * dia_store table data access object
     */
    class Dia_store_dao extends MY_Model {
        
        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_store"; // Table name
            $this->pk="sto_num"; // Primary key
            $this->string_conditions = array(); // Field for "LIKE" criteria
            $this->custom_value_conditions= array("sto_name", "sto_type"); // Field for full text criteria
        }

    }

?>