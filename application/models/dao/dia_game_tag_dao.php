<?php
    /**
     * dia_game_tag table data access object
     */
    class Dia_game_tag_dao extends CI_Model {
        
		private $table_name;
		
        function __construct()
	    {
	    	
	        // Call the Model constructor
	        parent::__construct();
			$this->load->helper("dao");
			$this->table_name="dia_game_tag";
	    }
		
        public function query_all(){
        	$query = $this->db->get($this->table_name);
			return $query;
        }
		
		public function query_by_dgt_num($dgt_num){
			$condition['dgt_num']=$dgt_num;
			return generate_result_set($this->query_by_condition($condition));
		}
		
		public function query_by_tag_num($tag_num){
			$condition['tag_num']=$tag_num;
			return $this->query_by_condition($condition);
		}
		
		public function query_by_gam_num($gam_num){
			$condition['gam_num']=$gam_num;
			return $this->query_by_condition($condition);
		}
		
		public function insert($dgt){
			$this->db->insert($this->table_name,$dgt);
			return $this->db->insert_id();
		}
		
		public function update($dgt){
			$this->db->where("dgt_num",$dgt->dgt_num);
			$this->db->update($this->table_name,$dgt);
		}
		
		public function delete_by_dgt_num($dgt_num){
			$this->db->where("dgt_num",$dgt_num);
			$this->db->delete($this->table_name);
		}
		
		public function delete_by_tag_num($tag_num){
			$this->db->where("tag_num",$tag_num);
			$this->db->delete($this->table_name);
		}
		
		public function delete_by_gam_num($gam_num){
			$this->db->where("gam_num",$gam_num);
			$this->db->delete($this->table_name);
		}
		
		public function query_by_condition($condition){
			// log_message("info","condition:"+print_r($condition,TRUE));
			//step1.加入where條件
			$value_conditions=array("dgt_num");
			foreach ($value_conditions as $field_name) {
				if(!empty($condition[$field_name])){
					$this->db->where($field_name,$condition[$field_name]);
				}
			}
			
			// //step2.加入like條件
			// $string_conditions=array("tag_name");
			// foreach ($string_conditions as $field_name) {
				// if(!empty($condition[$field_name])){
					// $this->db->like($field_name,$condition[$field_name]);
				// }
			// }
			
			//step3.加入選用where條件
			$custom_value_conditions=array("tag_num","gam_num");
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