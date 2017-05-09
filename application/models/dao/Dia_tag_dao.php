<?php
    /**
     * dia_tag table data access object
     */
    class Dia_tag_dao extends CI_Model {
        
		private $table_name;
		
        function __construct()
	    {
	    	
	        // Call the Model constructor
	        parent::__construct();
			$this->load->helper("dao");
			$this->table_name="dia_tag";
	    }
		
        public function query_all(){
        	$query = $this->db->get($this->table_name);
			return generate_result_list($query);
        }
		
		public function query_by_tag_num($tag_num){
			$this->db->where('tag_num',$tag_num);
			$query = $this->db->get($this->table_name);
			return generate_single_result($query);
		}
		
		public function query_by_tag_type($tag_type){
			$condition['tag_type']=$tag_type;
			return $this->query_by_condition($condition);
		}
		
		public function insert($tag){
			$this->db->insert($this->table_name,$tag);
			return $this->db->insert_id();
		}
		
		public function update($tag){
			$this->db->where("tag_num",$tag->tag_num);
			$this->db->update($this->table_name,$tag);
		}
		
		public function query_by_condition($condition){

			//step1.加入where條件
			$value_conditions=array("tag_num");
			foreach ($value_conditions as $field_name) {
				if(!empty($condition[$field_name])){
					$this->db->where($field_name,$condition[$field_name]);
				}
			}
			
			//step2.加入like條件
			$string_conditions=array("tag_name");
			foreach ($string_conditions as $field_name) {
				if(!empty($condition[$field_name])){
					$this->db->like($field_name,$condition[$field_name]);
				}
			}
			
			//step3.加入選用where條件
			$custom_value_conditions=array("tag_type","tag_status");
			foreach ($custom_value_conditions as $field_name) {
				if(isset($condition[$field_name]) && $condition[$field_name]!=-1){
					$this->db->where($field_name,$condition[$field_name]);
				}
			}
			
			if(isset($condition["order_tag_name"]) && $condition["order_tag_name"]==TRUE){
				$this->db->order_by("tag_name",$condition["order_tag_name"]);
			}
			
			$query = $this->db->get($this->table_name);
			return generate_result_list($query);
		}
		
    }
    
?>