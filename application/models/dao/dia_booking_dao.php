<?php
    /**
     * dia_booking table data access object
     */
    class Dia_booking_dao extends CI_Model {
        
		private $table_name;
		
        function __construct()
	    {
	    	
	        // Call the Model constructor
	        parent::__construct();
			$this->load->helper("dao");
			$this->table_name="dia_booking";
	    }
		
        public function query_all(){
        	$query = $this->db->get($this->table_name);
			return generate_result_list($query);
        }
		
		public function query_by_dbk_num($dbk_num){
			$this->db->where('dbk_num',$dbk_num);
			$query = $this->db->get($this->table_name);
			return generate_single_result($query);
		}
		
		public function query_by_usr_num($usr_num){
			$condition['usr_num']=$usr_num;
			return $this->query_by_condition($condition);
		}
		
		public function query_by_dbk_date_interval($start_date,$end_date=NULL){
			$condition['start_dbk_date']=$start_date;
			if($end_date!=NULL){
				$condition['end_dbk_date']=$end_date;
			}
			
			return $this->query_by_condition($condition);
		}
		
		public function insert($dbk){
			$this->db->insert($this->table_name,$dbk);
			return $this->db->insert_id();
		}
		
		public function update($dbk){
			$this->db->where("dbk_num",$dbk->dbk_num);
			$this->db->update($this->table_name,$dbk);
		}
		
		public function query_by_condition($condition){
				
			//step1.加入where條件
			$value_conditions=array("dbk_num");
			foreach ($value_conditions as $field_name) {
				if(!empty($condition[$field_name])){
					$this->db->where($field_name,$condition[$field_name]);
				}
			}
			
			//step2.加入like條件
			// $string_conditions=array("gam_cname","gam_ename");
			// foreach ($string_conditions as $field_name) {
				// if(!empty($condition[$field_name])){
					// $this->db->like($field_name,$condition[$field_name]);
				// }
			// }
			
			//step3.加入選用where條件
			$custom_value_conditions=array("usr_num","dbk_status");
			foreach ($custom_value_conditions as $field_name) {
				if(isset($condition[$field_name]) && $condition[$field_name]!=-1){
					$this->db->where($field_name,$condition[$field_name]);
				}
			}
			
			if(isset($condition["start_dbk_date"])){
				$this->db->where("dbk_date >= ",$condition["start_dbk_date"]);
			}
			
			if(isset($condition["end_dbk_date"])){
				$this->db->where("dbk_date <= ",$condition["end_dbk_date"]." 23:59:59");
			}
			
			if(isset($condition["order_dbk_date"])){
				$this->db->order_by("dbk_date",$condition["order_dbk_date"]);
			}
			
			if(isset($condition["order_register_date"])){
				$this->db->order_by("register_date",$condition["order_register_date"]);
			}
			
			if(isset($condition["order_modify_date"])){
				$this->db->order_by("modify_date",$condition["order_modify_date"]);
			}
			
			if(isset($condition["not_dbk_status"])){
				$this->db->where_not_in("dbk_status",$condition["not_dbk_status"]);
			}
			
			$query = $this->db->get($this->table_name);
			return generate_result_list($query);
		}
		
    }
    
?>