<?php
    /**
     * dia_calendar table data access object
     */
class Dia_calendar_dao extends MY_Model {
    
    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->table_name="dia_calendar"; // Table name
        $this->pk="cal_num"; // Primary key
        $this->string_conditions = array(); // Field for "LIKE" criteria
        $this->custom_value_conditions= array("cal_type"); // Field for full text criteria
    }
        
    protected function special_query_conditions($condition) {
        if(isset($condition["start_cal_date"])){
            $this->db->where("cal_date >= ",$condition["start_cal_date"]);
        }
        
        if(isset($condition["end_cal_date"])){
            $this->db->where("cal_date <= ",$condition["end_cal_date"]);
        }
    }
}

?>