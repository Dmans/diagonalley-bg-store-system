<?php
    /**
     * dia_game_import_item table data access object
     */
    class Dia_game_import_item_dao extends CI_Model {
        
		private $table_name;
		
        function __construct()
	    {
	    	
	        // Call the Model constructor
	        parent::__construct();
			$this->load->helper("dao");
			$this->table_name="dia_game_import_item";
	    }
		
        public function query_all(){
        	$query = $this->db->get($this->table_name);
			return generate_result_list($query);
        }
		
		public function query_by_gii_num($gii_num){
			$this->db->where('gii_num',$gii_num);
			$query = $this->db->get($this->table_name);
			return generate_single_result($query);
		}
		
		public function query_by_gam_num($gam_num){
			$condition['gam_num']=$gam_num;
			return $this->query_by_condition($condition);
		}
		
		public function query_by_gim_num($gim_num){
			$condition['gim_num']=$gim_num;
			return $this->query_by_condition($condition);
		}
		
		public function insert($gii){
			$this->db->insert($this->table_name,$gii);
			return $this->db->insert_id();
		}
		
		public function update($gii){
			$this->db->where("gii_num",$gii->gii_num);
			$this->db->update($this->table_name,$gii);
		}
		
		public function query_by_condition($condition){
			
			//step1.加入where條件
			$value_conditions=array("gii_num", "gam_num", "gim_num");
			foreach ($value_conditions as $field_name) {
				if(!empty($condition[$field_name])){
					$this->db->where($field_name,$condition[$field_name]);
				}
			}
			
			//step2.加入like條件
			$string_conditions=array("gii_source");
			foreach ($string_conditions as $field_name) {
				if(!empty($condition[$field_name])){
					$this->db->like($field_name,$condition[$field_name]);
				}
			}
			
			//step3.加入選用where條件
			$custom_value_conditions=array("gii_ivalue", "gii_imp_cvalue", "gii_old_cvalue", "gii_new_cvalue");
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