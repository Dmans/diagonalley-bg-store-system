<?php
    /**
     * dia_game_id table data access object
     */
    class Dia_game_id_dao extends CI_Model {
        
		private $table_name;
		
        function __construct()
	    {
	    	
	        // Call the Model constructor
	        parent::__construct();
			$this->load->helper("dao");
			$this->table_name="dia_game_id";
	    }
		
        public function query_all(){
        	$query = $this->db->get($this->table_name);
			return generate_result_set($query);
        }
		
		public function query_by_gid_num($gid_num){
			$condition['gid_num']=$gid_num;
			return $this->query_by_condition($condition);
		}
		
		public function insert($gid){
			$this->db->insert($this->table_name,$gid);
			return $this->db->insert_id();
		}
		
		public function update($gid){
			$this->db->where("gid_num",$gid->gid_num);
			$this->db->update($this->table_name,$gid);
		}
		
		public function query_by_condition($condition){
				
			//step1.加入where條件
			$value_conditions=array("gid_num");
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
			$custom_value_conditions=array("gid_enabled","gid_status","gid_rentable");
			foreach ($custom_value_conditions as $field_name) {
				if(isset($condition[$field_name]) && $condition[$field_name]!=-1){
					$this->db->where($field_name,$condition[$field_name]);
				}
			}
			
			$query = $this->db->get($this->table_name);
			return generate_result_set($query);
		}
		
    }
    
?>