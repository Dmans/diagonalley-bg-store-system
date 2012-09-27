<?php
    /**
     * 
     */
    class Login_service extends CI_Model {
        
        function __construct()
	    {
	        parent::__construct();
			$this->load->model("dao/dia_user_dao");
			$this->load->model("service/user_data_service");
	    }
		
		public function validate_user($usr_id, $usr_passwd){
				
			//step1.password轉sha1
			$this->load->library('encrypt');
			$usr_passwd =$this->encrypt->sha1($usr_passwd);
			
			//step2.撈取使用者帳號
			$user = $this->dia_user_dao->query_by_usr_id($usr_id);
			
			//step3.判斷使用者是否存在
			if($user ===NULL){
				return FALSE;
			}
			
			log_message("debug","usr_id=$usr_id exists");
			
			//step4.檢查帳號是否為會員
			if($user->usr_role==3){
				$this->__record_real_user_login_error($user);
				return FALSE;
			}
			
			log_message("debug","usr_id=$usr_id not member");
			
			//step4.檢查帳號是否已停用
			if($user->usr_status==0){
				$this->__record_real_user_login_error($user);
				return FALSE;
			}
			
			log_message("debug","usr_id=$usr_id enabled");
			
			//step6.檢查密碼是否正確
			if($usr_passwd != $user->usr_passwd){
				$this->__record_real_user_login_error($user);
				return FALSE;
			}
			
			log_message("debug","usr_id=$usr_id password correct");
			
			return TRUE;
			
		}
		
		public function find_user_by_usr_id($usr_id){
			return $this->dia_user_dao->query_by_usr_id($usr_id);
		}
		
		private function __record_real_user_login_error($user){
			$update_user['usr_num']=$user->usr_num;
			$update_user['usr_error_login']=$user->usr_error_login+1;
			
			$this->user_data_service->update_user($update_user);
		}
		
    }
    
?>