<?php
    /**
     * dia_salary_options table data access object
     */
    class Dia_salary_default_options_dao extends MY_Model {
        
        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_salary_default_options";
            $this->pk="dsdo_num";
            $this->string_conditions = array("dsdo_desc");
            $this->custom_value_conditions= array("dsdo_type");
            
        }
    }
    
?>