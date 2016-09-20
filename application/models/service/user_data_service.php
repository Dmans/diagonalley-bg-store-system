<?php
    /**
     *
     */
    class user_data_service extends CI_Model {

        function __construct()
	    {
	        parent::__construct();
			$this->load->model("dao/dia_user_dao");
            $this->load->model("dao/dia_user_store_permission_dao");
			$this->load->model("constants/form_constants");
	    }

		public function save_user($input){
		    $usr_num = $this->dia_user_dao->insert($this->__assemble_save_user($input));

            if(!empty($input['sto_nums'])) {
                $this->save_user_store_permission($usr_num, $input['sto_nums']);
            }

			return $usr_num;
		}

		public function update_user($input){
			$this->dia_user_dao->update($this->__assemble_update_user($input));

            if(!empty($input['sto_nums'])) {
                $this->save_user_store_permission($input['usr_num'], $input['sto_nums']);
            }
		}

		public function find_users_list($input){
			return $this->__assemble_query_result_list($this->dia_user_dao->query_by_condition($input));
		}

		public function find_user($usr_num){
			return $this->__assemble_query_result($this->dia_user_dao->query_by_usr_num($usr_num));
		}

        public function save_user_store_permission($usr_num, $sto_nums) {
            $this->dia_user_store_permission_dao->delete_by_usr_num($usr_num);

            foreach ($sto_nums as $key => $sto_num) {
                $usp['usr_num'] = $usr_num;
                $usp['sto_num'] = $sto_num;
                $this->dia_user_store_permission_dao->insert($usp);
            }
        }

		private function __assemble_save_user($input){

			$user->usr_id=$input['usr_id'];
			$user->usr_passwd = $this->encrypt->sha1($input['usr_passwd']);
			$user->usr_name = $input['usr_name'];
			$user->usr_role = $input['usr_role'];
			$user->usr_status = 1; //預設:啟用(1)
			$user->usr_error_login=0; //預設:登入錯誤0次
			$user->register_date = date('Y-m-d H:i:s');

			if(isset($input['usr_memo'])){
				$user->usr_memo = $input['usr_memo'];
			}


			return $user;
		}

		private function __assemble_update_user($input){

			$user->usr_num=$input['usr_num'];

			if(isset($input['usr_name'])){
				$user->usr_name = $input['usr_name'];
			}

			if(isset($input['usr_role'])){
				$user->usr_role = $input['usr_role'];
			}

			if(isset($input['usr_status'])){
				$user->usr_status = $input['usr_status'];
			}

			if(isset($input['usr_passwd'])){
				$user->usr_passwd = $input['usr_passwd'];
			}

			if(isset($input['usr_error_login'])){
				$user->usr_error_login = $input['usr_error_login'];
			}

			if(isset($input['usr_memo'])){
				$user->usr_memo = $input['usr_memo'];
			}


			return $user;
		}

		private function __assemble_query_result_list($query_result){
			$output = array();
			if(!empty($query_result)){
				foreach ($query_result as $row) {
					$output[]=$this->__assemble_query_result($row);
				}
			}

			return $output;
		}

		private function __assemble_query_result($row){

			$result=NULL;
			$result->usr_num=$row->usr_num;
			$result->usr_id=$row->usr_id;
			$result->usr_name=$row->usr_name;
			$result->usr_role=$row->usr_role;

			$result->usr_role_desc=$this->form_constants->transfer_usr_role($row->usr_role);
			$result->usr_status=$row->usr_status;
			$result->usr_status_desc=$this->form_constants->transfer_usr_status($row->usr_status);
			$result->usr_memo=(isset($row->usr_memo))?$row->usr_memo:"";
			$result->register_date=$row->register_date;
			$result->modify_date=$row->modify_date;
			$result->usr_error_login=$row->usr_error_login;


            // Assemble user store permission
            $usps = $this->dia_user_store_permission_dao->query_by_usr_num($row->usr_num);
            $tmpusps = array();
            if(!empty($usps)) {
                foreach ($usps as $key => $usp) {
                   $tmpusps[] = $usp->sto_num;
                }
            }


            $result->user_store_permission = $tmpusps;


			return $result;
		}
    }

?>