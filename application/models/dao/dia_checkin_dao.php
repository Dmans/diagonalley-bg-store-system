<?php
    /**
     * dia_checkin table data access object
     */
    class Dia_checkin_dao extends CI_Model {

		private $table_name;

        function __construct()
	    {

	        // Call the Model constructor
	        parent::__construct();
			$this->load->helper("dao");
			$this->table_name="dia_checkin";
	    }

        public function query_all(){
        	$query = $this->db->get($this->table_name);
			return generate_result_list($query);
        }

		public function query_by_chk_num($chk_num){
			$this->db->where('chk_num',$chk_num);
			$query = $this->db->get($this->table_name);
			return generate_single_result($query);
		}

		public function query_by_usr_num($usr_num){
			$condition['usr_num']=$usr_num;
			return $this->query_by_condition($condition);
		}

		public function insert($chk){
			$this->db->insert($this->table_name,$chk);
			return $this->db->insert_id();
		}

		public function update($chk){
			$this->db->where("chk_num",$chk->chk_num);
			$this->db->update($this->table_name,$chk);
		}

		public function query_by_condition($condition){
			// log_message("info","condition:".print_r($condition,TRUE));
			//step1.加入where條件
			$value_conditions=array("chk_num");
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
			$custom_value_conditions=array("usr_num", "sto_num");
			foreach ($custom_value_conditions as $field_name) {
				if(isset($condition[$field_name]) && $condition[$field_name]!=-1){
					$this->db->where($field_name,$condition[$field_name]);
				}
			}

			//step4.加入特殊條件
			if(isset($condition['uncheck']) && $condition['uncheck']==TRUE){
				// log_message("info","in!");
				$this->db->where("confirm_date IS NULL",NULL, FALSE);
				$this->db->where("chk_out_time IS NOT NULL",NULL, FALSE);
			}

			if(isset($condition["chkin_start_time"])){
				$this->db->where("chk_in_time >= ",$condition["chkin_start_time"]." 00:00:00");
			}

			if(isset($condition["chkout_start_time"])){
				$this->db->where("chk_out_time >= ",$condition["chkout_start_time"]." 00:00:00");
			}

			if(isset($condition["chkin_end_time"])){
				$this->db->where("chk_in_time <= ",$condition["chkin_end_time"]." 23:59:59");
			}

			if(isset($condition["chkout_end_time"])){
				$this->db->where("chk_out_time <= ",$condition["chkout_end_time"]." 23:59:59");
			}


			$query = $this->db->get($this->table_name);
			return generate_result_list($query);
		}

    }

?>