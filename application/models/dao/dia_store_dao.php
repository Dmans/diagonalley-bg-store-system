<?php
    /**
     * dia_store table data access object
     */
    class Dia_store_dao extends CI_Model {

		private $table_name;

        function __construct()
	    {

	        // Call the Model constructor
	        parent::__construct();
			$this->load->helper("dao");
			$this->table_name="dia_store";
	    }

        public function query_all(){
        	$query = $this->db->get($this->table_name);
			return generate_result_list($query);
        }

		public function query_by_sto_num($sto_num){
			$this->db->where('sto_num',$sto_num);
			$query = $this->db->get($this->table_name);
			return generate_single_result($query);
		}

		public function insert($sto){
			$this->db->insert($this->table_name,$sto);
			return $this->db->insert_id();
		}

		public function update($sto){
			$this->db->where("sto_num",$sto->sto_num);
			$this->db->update($this->table_name,$sto);
		}

		public function query_by_condition($condition){

			//step1.加入where條件
			$value_conditions=array("sto_num");
			foreach ($value_conditions as $field_name) {
				if(!empty($condition[$field_name])){
					$this->db->where($field_name,$condition[$field_name]);
				}
			}

			//step2.加入like條件
			// $string_conditions=array("gam_cname","gam_ename");
			// foreach ($string_conditions as $field_name) {
				// if(!empty($condition[$field_name])){
					// $this->db->like($field_name,$condition[$field_name]);
				// }
			// }

			//step3.加入選用where條件
			$custom_value_conditions=array("sto_name", "sto_type");
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