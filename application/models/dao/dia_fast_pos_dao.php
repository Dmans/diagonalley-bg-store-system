<?php
    /**
     * dia_fast_pos table data access object
     */
    class Dia_fast_pos_dao extends CI_Model {
        
		private $table_name;	
			
        function __construct()
	    {
	        parent::__construct();
			$this->load->helper("dao");
			$this->table_name="dia_fast_pos";	
	    }
		
        public function query_all(){
        	$query = $this->db->get($this->table_name);
			return generate_result_set($query);
        }
		
		public function query_by_pfs_num($pfs_num){
			$condition['pfs_num']=$pfs_num;
			return $this->query_by_condition($condition);
		}
		
		public function query_by_tag_num($tag_num){
			$condition['tag_num']=$tag_num;
			return $this->query_by_condition($condition);
		}
		
		public function insert($pfs){
			$this->db->insert($this->table_name,$pfs);
			return $this->db->insert_id();
		}
		
		public function update($pfs){
			$this->db->where("pfs_num",$pfs->pfs_num);
			$this->db->update($this->table_name,$pfs);
		}
		
		public function query_by_condition($condition){
				
			//step1.加入where條件
			$value_conditions=array("pfs_num","tag_num");
			foreach ($value_conditions as $field_name) {
				if(!empty($condition[$field_name])){
					$this->db->where($field_name,$condition[$field_name]);
				}
			}
			
			// //step2.加入like條件
			// $string_conditions=array("usr_name","usr_id");
			// foreach ($string_conditions as $field_name) {
				// if(!empty($condition[$field_name])){
					// $this->db->like($field_name,$condition[$field_name]);
				// }
			// }
			
			//step3.加入選用where條件
			$custom_value_conditions=array("pfs_visible");
			foreach ($custom_value_conditions as $field_name) {
				if(isset($condition[$field_name]) && $condition[$field_name]!=-1){
					$this->db->where($field_name,$condition[$field_name]);
				}
			}
			
			if(isset($condition["order_pfs_order"])){
				$this->db->order_by("pfs_order",$condition["order_pfs_order"]);
			}
			
			
			$query = $this->db->get($this->table_name);
			return generate_result_set($query);
		}
		
    }
    
?>