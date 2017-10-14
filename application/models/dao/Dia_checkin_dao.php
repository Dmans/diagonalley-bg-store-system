<?php
    /**
     * dia_checkin table data access object
     */
    class Dia_checkin_dao extends MY_Model {
        
        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_checkin"; // Table name
            $this->pk="chk_num"; // Primary key
            $this->string_conditions = array(); // Field for "LIKE" criteria
            $this->custom_value_conditions= array("usr_num", "sto_num"); // Field for full text criteria
        }
        
        public function query_by_usr_num($usr_num){
            $condition['usr_num']=$usr_num;
            return $this->query_by_condition($condition);
        }
        
        protected function special_query_conditions($condition) {
            if(isset($condition['unconfirmed']) && $condition['unconfirmed']==TRUE){
                $this->db->where("confirm_date IS NULL",NULL, FALSE);
                $this->db->where("chk_out_time IS NOT NULL",NULL, FALSE);
            }
            
            if(isset($condition['uncheckout']) && $condition['uncheckout']==TRUE){
                $this->db->where("chk_out_time IS NULL",NULL, FALSE);
            }
            
            if(isset($condition["chkin_start_time"])){
                $this->db->where("chk_in_time >= ",$condition["chkin_start_time"]." 00:00:00");
            }
            
            if(isset($condition["chkout_start_time"])){
                $this->db->where("chk_out_time >= ",$condition["chkout_start_time"]." 00:00:00");
            }
            
            if(isset($condition["chkin_end_time"])){
                $this->db->where("chk_in_time <= ",$condition["chkin_end_time"]." 23:59:59");
            }
            
            if(isset($condition["chkout_end_time"])){
                $this->db->where("chk_out_time <= ",$condition["chkout_end_time"]." 23:59:59");
            }
        }
        
    }

?>