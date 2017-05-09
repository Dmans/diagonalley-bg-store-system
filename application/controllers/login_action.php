<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    /**
     *
     */
    class Login_action extends CI_Controller {
        function __construct()
	    {
	        parent::__construct();
			$this->load->library('form_validation');
			$this->load->model("login_service");
	    }


        public function index(){
        	$this->load->library('form_validation');
			$this->load->helper(array('form','url'));
			$data['system_name']="古靈閣";
        	$this->load->view("login_form", $data);
        }


		public function login(){

			$usr_id = $this->input->post("usr_id");
			$usr_passwd = $this->input->post("usr_passwd");
			log_message("info","Login_action.login() - usrId=".$usr_id);

			$this->__login_format_validation($usr_passwd);
			if($this->form_validation->run() != TRUE){
			    $data['system_name']="古靈閣";
				$this->load->view("login_form", $data);
				return;
			}

			$user = $this->login_service->find_user_by_usr_id($usr_id);

			//儲存使用者資訊
			$this->session->set_userdata('logged_in','1');
			$this->session->set_userdata('user',$user);
			redirect("main_action");

		}

		public function logout(){
			$this->session->sess_destroy();
			$this->load->view("logout_page");
		}

		public function validate_user($usr_id, $usr_passwd){
			if($this->login_service->validate_user($usr_id, $usr_passwd)==TRUE){
				return TRUE;
			}else{
				$this->form_validation->set_message('validate_user', '帳號或密碼錯誤或帳號已鎖定');
				return FALSE;
			}
		}

		private function __login_format_validation($usr_passwd){
			$this->form_validation->set_rules('usr_id', '帳號', 'required|max_length[64]|callback_validate_user['.$usr_passwd.']');
		    $this->form_validation->set_rules('usr_passwd', '密碼', 'required|max_length[32]');
		}



    }

?>