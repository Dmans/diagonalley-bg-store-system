<?php
    /**
     * dia_pos_order table data access object
     */
    class Dia_pos_order_dao extends CI_Model {
        
		private $table_name;	
			
        function __construct()
	    {
	        parent::__construct();
			$this->load->helper("dao");
			$this->table_name="dia_pos_order";	
	    }
		
        public function query_all(){
        	$query = $this->db->get($this->table_name);
			return generate_result_list($query);
        }
		
		public function query_by_pod_num($pod_num){
			$this->db->where('pod_num',$pod_num);
			$query = $this->db->get($this->table_name);
			return generate_single_result($query);
		}
		
		public function insert($pod){
			$this->db->insert($this->table_name,$pod);
			return $this->db->insert_id();
		}
		
		public function update($pod){
			$this->db->where("pod_num",$pod->pod_num);
			$this->db->update($this->table_name,$pod);
		}
		
		public function query_by_condition($condition){
				
			//step1.加入where條件
			$value_conditions=array("pod_num","tag_num");
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
			$custom_value_conditions=array("pod_status");
			foreach ($custom_value_conditions as $field_name) {
				if(isset($condition[$field_name]) && $condition[$field_name]!=-1){
					$this->db->where($field_name,$condition[$field_name]);
				}
			}
			
			if(isset($condition["start_pod_date"])){
				$this->db->where("pod_date >= ",$condition["start_pod_date"]);
			}
			
			if(isset($condition["end_pod_date"])){
				$this->db->where("pod_date <= ",$condition["end_pod_date"]." 23:59:59");
			}
			
			
			$query = $this->db->get($this->table_name);
			return generate_result_list($query);
		}
		
    }
    
?>