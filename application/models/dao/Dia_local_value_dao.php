<?php
    /**
     * dia_local_value table data access object
     */
    class Dia_local_value_dao extends CI_Model {
        
		private $table_name;
		
        function __construct()
	    {
	    	
	        // Call the Model constructor
	        parent::__construct();
			$this->load->helper("dao");
			$this->table_name="dia_local_value";
	    }
		
        public function query_all(){
        	$query = $this->db->get($this->table_name);
			return generate_result_list($query);
        }
		
		public function query_by_dlv_num($dlv_num){
			$this->db->where('dlv_num',$dlv_num);
			$query = $this->db->get($this->table_name);
			return generate_single_result($query);
		}
		
		public function query_by_dlv_id($dlv_id){
			$condition['dlv_id']=$dlv_id;
			return $this->query_by_condition($condition);
		}
		
		
		public function insert($dlv){
			$this->db->insert($this->table_name,$dlv);
			return $this->db->insert_id();
		}
		
		public function update($dlv){
			$this->db->where("dgt_num",$dlv->dlv_num);
			$this->db->update($this->table_name,$dlv);
		}
		
		public function delete_by_dlv_num($dlv_num){
			$this->db->where("dlv_num",$dlv_num);
			$this->db->delete($this->table_name);
		}
		
		public function delete_by_dlv_id($dlv_id){
			$this->db->where("dlv_id",$dlv_id);
			$this->db->delete($this->table_name);
		}
		
		public function query_by_condition($condition){
				
			//step1.加入where條件
			$value_conditions=array("dlv_num", "dlv_enabled");
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
			$custom_value_conditions=array("dlv_id");
			foreach ($custom_value_conditions as $field_name) {
				if(isset($condition[$field_name]) && $condition[$field_name]!=-1){
					$this->db->where($field_name,$condition[$field_name]);
				}
			}
			
			
			
			$query = $this->db->get($this->table_name);
			return generate_result_list($query);
		}
		
    }
    
?>