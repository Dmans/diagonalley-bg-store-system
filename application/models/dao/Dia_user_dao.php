<?php
    /**
     * dia_user table data access object
     */
    class Dia_user_dao extends MY_Model {
        
        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_user"; // Table name
            $this->pk="usr_num"; // Primary key
            $this->string_conditions = array("usr_name","usr_id","usr_mail"); // Field for "LIKE" criteria
            $this->custom_value_conditions= array("usr_role","usr_status"); // Field for full text criteria
        }
		
		public function query_by_usr_id($usr_id){
			$this->db->where("usr_id",$usr_id);
			$query = $this->db->get($this->table_name);
			return generate_single_result($query);
		}
    }
    
?>