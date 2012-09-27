<?php
    /**
     * dia_user table data access object
     */
    class Dia_user_dao extends CI_Model {
        
		private $table_name;	
			
        function __construct()
	    {
	        parent::__construct();
			$this->load->helper("dao");
			$this->table_name="dia_user";	
	    }
		
        public function query_all(){
        	$query = $this->db->get($this->table_name);
			return generate_result_set($query);
        }
		
		public function query_by_usr_id($usr_id){
			$this->db->where("usr_id",$usr_id);
			$query = $this->db->get($this->table_name);
			return generate_result_set($query);
		}
		
		public function query_by_usr_num($usr_num){
			$condition['usr_num']=$usr_num;
			return $this->query_by_condition($condition);
		}
		
		public function insert($user){
			$this->db->insert($this->table_name,$user);
			return $this->db->insert_id();
		}
		
		public function update($user){
			$this->db->where("usr_num",$user->usr_num);
			$this->db->update($this->table_name,$user);
		}
		
		public function query_by_condition($condition){
				
			//step1.加入where條件
			$value_conditions=array("usr_num");
			foreach ($value_conditions as $field_name) {
				if(!empty($condition[$field_name])){
					$this->db->where($field_name,$condition[$field_name]);
				}
			}
			
			//step2.加入like條件
			$string_conditions=array("usr_name","usr_id");
			foreach ($string_conditions as $field_name) {
				if(!empty($condition[$field_name])){
					$this->db->like($field_name,$condition[$field_name]);
				}
			}
			
			//step3.加入選用where條件
			$custom_value_conditions=array("usr_role","usr_status");
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