<?php
    /**
     * dia_user table data access object
     */
    class Dia_order_dao extends CI_Model {
        
		private $table_name;	
			
        function __construct()
	    {
	        parent::__construct();
			$this->load->helper("dao");
			$this->table_name="dia_order";	
	    }
		
        public function query_all(){
        	$query = $this->db->get($this->table_name);
			return generate_result_list($query);
        }
		
		public function query_by_ord_num($ord_num){
			$this->db->where('ord_num',$ord_num);
			$query = $this->db->get($this->table_name);
			return generate_single_result($query);
		}
		
		public function query_by_gam_num($gam_num){
			$condition['gam_num']=$gam_num;
			return $this->query_by_condition($condition);
		}
		
		public function insert($order){
			$this->db->insert($this->table_name,$order);
			return $this->db->insert_id();
		}
		
		public function update($order){
			$this->db->where("ord_num",$order->ord_num);
			$this->db->update($this->table_name,$order);
		}
		
		public function query_by_condition($condition){
				
			//step1.加入where條件
			$value_conditions=array("ord_num","pod_num");
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
			$custom_value_conditions=array("gam_num","usr_num","ord_type","ord_status");
			foreach ($custom_value_conditions as $field_name) {
				if(isset($condition[$field_name]) && $condition[$field_name]!=-1){
					$this->db->where($field_name,$condition[$field_name]);
				}
			}
			
			if(isset($condition["start_order_date"])){
				$this->db->where("ord_date >= ",$condition["start_order_date"]);
			}
			
			if(isset($condition["end_order_date"])){
				$this->db->where("ord_date <= ",$condition["end_order_date"]." 23:59:59");
			}
			
			
			$query = $this->db->get($this->table_name);
			return generate_result_list($query);
		}
		
    }
    
?>