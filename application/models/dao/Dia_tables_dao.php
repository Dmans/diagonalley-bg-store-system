<?php
    /**
     * dia_table table data access object
     */
    class Dia_tables_dao extends CI_Model {

		private $table_name;

        function __construct()
	    {

	        // Call the Model constructor
	        parent::__construct();
			$this->load->helper("dao");
			$this->table_name="dia_tables";
	    }

        public function query_all(){
        	$query = $this->db->get($this->table_name);
			return generate_result_list($query);
        }

        public function query_by_dtb_num($dtb_num){
            $this->db->where('dtb_num',$dtb_num);
            $query = $this->db->get($this->table_name);
            return generate_single_result($query);
        }

		public function query_by_sto_num($sto_num){
			$this->db->where('dbk_num',$sto_num);
			$query = $this->db->get($this->table_name);
			return generate_single_result($query);
		}

		public function insert($sto){
			$this->db->insert($this->table_name,$sto);
			return $this->db->insert_id();
		}

		public function update($dtb){
			$this->db->where("dtb_num",$dtb->dtb_num);
			$this->db->update($this->table_name,$dtb);
		}

		public function query_by_condition($condition){

			//step1.加入where條件
			$value_conditions=array("dtb_num");
			foreach ($value_conditions as $field_name) {
				if(!empty($condition[$field_name])){
					$this->db->where($field_name,$condition[$field_name]);
				}
			}

			//step2.加入like條件
			$string_conditions=array("dtb_name");
			foreach ($string_conditions as $field_name) {
				if(!empty($condition[$field_name])){
					$this->db->like($field_name,$condition[$field_name]);
				}
			}

			//step3.加入選用where條件
			$custom_value_conditions=array("sto_num");
			foreach ($custom_value_conditions as $field_name) {
				if(isset($condition[$field_name]) && $condition[$field_name]!=-1){
					$this->db->where($field_name,$condition[$field_name]);
				}
			}
			if(isset($condition["dtb_max_cap"])){
			        $this->db->where("dtb_max_cap <= ",$condition["dtb_max_cap"]);
			}
			

			$query = $this->db->get($this->table_name);
			return generate_result_list($query);
		}

    }

?>