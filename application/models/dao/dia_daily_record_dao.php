<?php
    /**
     * dia_daily_record table data access object
     */
    class Dia_daily_record_dao extends CI_Model {
        
		private $table_name;
		
        function __construct()
	    {
	    	
	        // Call the Model constructor
	        parent::__construct();
			$this->load->helper("dao");
			$this->table_name="dia_daily_record";
	    }
		
        public function query_all(){
        	$query = $this->db->get($this->table_name);
			return generate_result_set($query);
        }
		
		public function query_by_ddr_num($ddr_num){
			$condition['ddr_num']=$ddr_num;
			return $this->query_by_condition($condition);
		}
		
		public function query_by_usr_num($usr_num){
			$condition['usr_num']=$usr_num;
			return $this->query_by_condition($condition);
		}
		
		public function insert($ddr){
			$this->db->insert($this->table_name,$ddr);
			return $this->db->insert_id();
		}
		
		public function update($ddr){
			$this->db->where("ddr_num",$ddr->ddr_num);
			$this->db->update($this->table_name,$ddr);
		}
		
		public function query_by_condition($condition){
				
			//step1.加入where條件
			$value_conditions=array("ddr_num");
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
			$custom_value_conditions=array("usr_num","ddr_status","ddr_type");
			foreach ($custom_value_conditions as $field_name) {
				if(isset($condition[$field_name]) && $condition[$field_name]!=-1){
					$this->db->where($field_name,$condition[$field_name]);
				}
			}
			
			if(isset($condition["start_register_date"])){
				$this->db->where("register_date >= ",$condition["start_register_date"]);
			}
			
			if(isset($condition["end_register_date"])){
				$this->db->where("register_date <= ",$condition["end_register_date"]." 23:59:59");
			}
			
			if(isset($condition["start_modify_date"])){
				$this->db->where("modify_date >= ",$condition["start_modify_date"]);
			}
			
			if(isset($condition["end_modify_date"])){
				$this->db->where("modify_date <= ",$condition["end_modify_date"]." 23:59:59");
			}
			
			if(isset($condition["order_register_date"])){
				$this->db->order_by("register_date",$condition["order_register_date"]);
			}
			
			if(isset($condition["order_modify_date"])){
				$this->db->order_by("modify_date",$condition["order_modify_date"]);
			}
			
			if(isset($condition["not_ddr_status"])){
				$this->db->where_not_in("ddr_status",$condition["not_ddr_status"]);
			}
			
			$query = $this->db->get($this->table_name);
			return generate_result_set($query);
		}
		
    }
    
?>