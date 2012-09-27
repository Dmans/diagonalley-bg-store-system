<?php
    /**
     * dia_game_id_record table data access object
     */
    class Dia_game_id_record_dao extends CI_Model {
        
		private $table_name;
		
        function __construct()
	    {
	    	
	        // Call the Model constructor
	        parent::__construct();
			$this->load->helper("dao");
			$this->table_name="dia_game_id_record";
	    }
		
        public function query_all(){
        	$query = $this->db->get($this->table_name);
			return generate_result_set($query);
        }
		
		public function query_by_grd_num($grd_num){
			$condition['grd_num']=$grd_num;
			return $this->query_by_condition($condition);
		}
		
		public function insert($grd){
			$this->db->insert($this->table_name,$grd);
			return $this->db->insert_id();
		}
		
		public function update($grd){
			$this->db->where("grd_num",$grd->grd_num);
			$this->db->update($this->table_name,$grd);
		}
		
		public function query_by_condition($condition){
				
			//step1.加入where條件
			$value_conditions=array("grd_num");
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
			$custom_value_conditions=array("gid_num","grd_susr_num","grd_eusr_num");
			foreach ($custom_value_conditions as $field_name) {
				if(isset($condition[$field_name]) && $condition[$field_name]!=-1){
					$this->db->where($field_name,$condition[$field_name]);
				}
			}
			
			if(isset($condition["grd_start_time"])){
				$this->db->where("grd_start_time > ",$condition["grd_start_time"]);
			}
			
			if(isset($condition["grd_end_time"])){
				$this->db->where("grd_end_time < ",$condition["grd_end_time"]);
			}
			
			if(isset($condition["null_grd_end_time"])){
				$this->db->where("grd_end_time is null");
			}
			
			$query = $this->db->get($this->table_name);
			return generate_result_set($query);
		}
		
    }
    
?>