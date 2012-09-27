<?php
    /**
     * 
     */
    class User_service extends CI_Model {
        
        function __construct()
	    {
	        parent::__construct();
			$this->load->library('encrypt');
			$this->load->model("service/user_data_service");
			$this->load->model("constants/form_constants");
	    }
		
		public function save_user($input){
			return $this->user_data_service->save_user($input);
		}
		
		public function update_user($input){
			$this->user_data_service->update_user($input);
		}
		
		public function update_passwd($input){
			$this->user_data_service->update_user($this->__assemble_update_passwd($input));
		}
		
		public function find_users_for_list($input){
			return $this->user_data_service->find_users_list($input);
		}
		
		public function find_user_for_update($usr_num){
			return $this->user_data_service->find_user($usr_num);
		}
		
		public function save_member_user($input){
			return $this->user_data_service->save_user($this->__assemble_save_member_user($input));
		}
		
		private function __assemble_update_passwd($input){
				
			$input['usr_passwd'] = $this->encrypt->sha1($input['usr_passwd']);

			return $input;
		}
		
		private function __assemble_save_member_user($input){
			$input['usr_passwd']="qazwsxedcrfvtgb12345";
			$input['usr_role']=3;
			
			return $input;
		}
		
		
    }
    
?>