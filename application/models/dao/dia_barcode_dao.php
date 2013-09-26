<?php
    /**
     * dia_barcode table data access object
     */
    class Dia_barcode_dao extends CI_Model {
        
		private $table_name;	
			
        function __construct()
	    {
	        parent::__construct();
			$this->load->helper("dao");
			$this->table_name="dia_barcode";	
	    }
		
        public function query_all(){
        	$query = $this->db->get($this->table_name);
			return generate_result_list($query);
        }
		
		public function query_by_bar_num($bar_num){
			$this->db->where('bar_num',$bar_num);
			$query = $this->db->get($this->table_name);
			return generate_single_result($query);
		}
		
		public function query_by_bar_code($bar_code){
			$this->db->where('bar_code',$bar_code);
			$query = $this->db->get($this->table_name);
			return generate_single_result($query);
		}
		
		public function query_by_bar_type($bar_type){
			$condition['bar_type']=$bar_type;
			return $this->query_by_condition($condition);
		}
		
		public function insert($barcode){
			$this->db->insert($this->table_name,$barcode);
			return $this->db->insert_id();
		}
		
		public function update($barcode){
			$this->db->where("bar_num",$barcode->bar_num);
			$this->db->update($this->table_name,$barcode);
		}
		
		public function query_by_condition($condition){
				
			//step1.加入where條件
			$value_conditions=array("bar_num", "bar_code");
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
			$custom_value_conditions=array("bar_type", "bar_value");
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