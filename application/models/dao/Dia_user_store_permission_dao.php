<?php
    /**
     * Dia_user_store_permission table data access object
     */
    class Dia_user_store_permission_dao extends CI_Model {

		private $table_name;

        function __construct()
	    {
	        // Call the Model constructor
	        parent::__construct();
			$this->load->helper("dao");
			$this->table_name="dia_user_store_permission";
	    }

        public function query_all(){
        	$query = $this->db->get($this->table_name);
			return generate_result_list($query);
        }

		public function query_by_usp_num($usp_num){
			$this->db->where('usp_num',$usp_num);
			$query = $this->db->get($this->table_name);
			return generate_single_result($query);
		}

		public function query_by_usr_num($usr_num){
			$condition['usr_num']=$usr_num;
			return $this->query_by_condition($condition);
		}

        public function query_by_sto_num($sto_num){
            $condition['sto_num']=$sto_num;
            return $this->query_by_condition($condition);
        }

        public function delete_by_usr_num($usr_num){
            $condition['usr_num']=$usr_num;
            return $query = $this->db->delete($this->table_name, $condition);
        }

		public function insert($usp){
			$this->db->insert($this->table_name,$usp);
			return $this->db->insert_id();
		}

		public function update($usp){
			$this->db->where("usp_num",$usp->usp_num);
			$this->db->update($this->table_name,$usp);
		}

		public function query_by_condition($condition){
			//step1.加入where條件
			$value_conditions=array("usp_num");
			foreach ($value_conditions as $field_name) {
				if(!empty($condition[$field_name])){
					$this->db->where($field_name,$condition[$field_name]);
				}
			}

			//step2.加入like條件
			// $string_conditions=array("act_name");
			// foreach ($string_conditions as $field_name) {
				// if(!empty($condition[$field_name])){
					// $this->db->like($field_name,$condition[$field_name]);
				// }
			// }

			//step3.加入選用where條件
			$custom_value_conditions=array("usr_num","sto_num");
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