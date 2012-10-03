<?php
    /**
     * dia_game table data access object
     */
    class Dia_game_dao extends CI_Model {
        
		private $table_name;
		
        function __construct()
	    {
	    	
	        // Call the Model constructor
	        parent::__construct();
			$this->load->helper("dao");
			$this->table_name="dia_game";
	    }
		
        public function query_all(){
        	$query = $this->db->get($this->table_name);
			return generate_result_set($query);
        }
		
		public function query_by_gam_num($gam_num){
			$condition['gam_num']=$gam_num;
			return $this->query_by_condition($condition);
		}
		
		public function query_by_gam_ename($gam_ename){
			$condition['gam_ename']=$gam_ename;
			return $this->query_by_condition($condition);
		}
		
		public function query_by_gam_cname($gam_cname){
			$condition['gam_cname']=$gam_cname;
			return $this->query_by_condition($condition);
		}
		
		public function insert($game){
			$this->db->insert($this->table_name,$game);
			return $this->db->insert_id();
		}
		
		public function update($game){
			$this->db->where("gam_num",$game->gam_num);
			$this->db->update($this->table_name,$game);
		}
		
		public function query_by_condition($condition){
				
			//step1.加入where條件
			$value_conditions=array("gam_num");
			foreach ($value_conditions as $field_name) {
				if(!empty($condition[$field_name])){
					$this->db->where($field_name,$condition[$field_name]);
				}
			}
			
			//step2.加入like條件
			$string_conditions=array("gam_cname","gam_ename");
			foreach ($string_conditions as $field_name) {
				if(!empty($condition[$field_name])){
					$this->db->like($field_name,$condition[$field_name]);
				}
			}
			
			//step3.加入選用where條件
			$custom_value_conditions=array("gam_type","gam_status","gam_sale");
			foreach ($custom_value_conditions as $field_name) {
				if(isset($condition[$field_name]) && $condition[$field_name]!=-1){
					$this->db->where($field_name,$condition[$field_name]);
				}
			}
			
			if(isset($condition["order_gam_ename"]) && $condition["order_gam_ename"]==TRUE){
				$this->db->order_by("gam_ename",$condition["order_gam_ename"]);
			}
			
			$query = $this->db->get($this->table_name);
			return generate_result_set($query);
		}
		
    }
    
?>