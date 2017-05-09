<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    /**
     *
     */
    class User_action extends MY_Controller {
    	function __construct()
	    {
	        parent::__construct();
			$this->load->library('form_validation');
			$this->load->model("user/user_service");
            $this->load->model('service/store_data_service');

	    }

        public function save_form(){

        	$user = $this->session->userdata('user');

			if($this->__user_role_check($user->usr_role)){return;}

			log_message("info","User_action.save_form - start usr_num=".$user->usr_num);

			$data['usr_role'] =$user->usr_role ;
            $data['stores'] = $this->store_data_service->get_stores();

        	$this->load->view("user/user_iform",$data);

			log_message("info","User_action.save_form - end usr_num=".$user->usr_num);
        }

		public function save(){

			$user = $this->session->userdata('user');

			if($this->__user_role_check($user->usr_role)){return;}

			$input=$this->input->post();

			log_message("info","User_action.save(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);

			//step1. 驗證輸入資料格式
			$this->__save_user_format_validate();
			if($this->form_validation->run() != TRUE){
				$this->save_form();
				return;
			}

            if ($user->usr_role != 0) {
                unset($input['sto_nums']);
            }

			$usr_num=$this->user_service->save_user($input);

			$data['message']="新增使用者成功,使用者流水號:".$usr_num;

			$extend_url=array();
			$extend_url[]=$this->__generate_url_data("繼續新增使用者", "user/user_action/save_form/");
			$extend_url[]=$this->__generate_url_data("維護使用者", "user/user_action/update_form/",$usr_num);
			$extend_url[]=$this->__generate_url_data("查詢使用者", "user/user_action/list_form/");
			$data['extend_url']=$extend_url;


			$this->load->view("message",$data);

			log_message("info","User_action.save() - end usr_num=".$user->usr_num);

		}

		public function update_form($usr_num){

        	$user = $this->session->userdata('user');

			if($this->__user_role_check($user->usr_role)){return;}

			log_message("info","User_action.update_form(update_usr_num=".$usr_num.") - start usr_num=".$user->usr_num);

			$data['usr_role'] =$user->usr_role ;

			$update_user=$this->user_service->find_user_for_update($usr_num);
			$data['update_user'] =$update_user;
            $data['stores'] = $this->store_data_service->get_stores();


        	$this->load->view("user/user_uform",$data);

			log_message("info","User_action.update_form(update_usr_num=".$usr_num.") - end usr_num=".$user->usr_num);
        }

		public function update(){

			$user = $this->session->userdata('user');

			if($this->__user_role_check($user->usr_role)){return;}

			$input=$this->input->post();

			log_message("info","User_action.update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);

			//step1. 驗證輸入資料格式
			$this->__update_user_format_validate();
			if($this->form_validation->run() != TRUE){
				$this->update_form($input['usr_num']);
				return;
			}

            if ($user->usr_role != 0) {
                unset($input['sto_nums']);
            }

			$this->user_service->update_user($input);

			$data['message']="維護使用者成功";

			$extend_url=array();
			$extend_url[]=$this->__generate_url_data("維護使用者", "user/user_action/update_form/",$input['usr_num']);
			$extend_url[]=$this->__generate_url_data("查詢使用者", "user/user_action/list_form/");
			$data['extend_url']=$extend_url;

			$this->load->view("message",$data);

			log_message("info","User_action.update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);

		}

		public function list_form($query_result=NULL){

        	$user = $this->session->userdata('user');

			if($this->__user_role_check($user->usr_role)){return;}

			log_message("info","User_action.list_form - start usr_num=".$user->usr_num);

			$data['usr_role'] =$user->usr_role ;

			if(!empty($query_result)){
				$data['query_result']=$query_result;
			}

        	$this->load->view("user/user_qform",$data);

			log_message("info","User_action.list_form - end usr_num=".$user->usr_num);
        }

		public function lists(){

			$user = $this->session->userdata('user');

			if($this->__user_role_check($user->usr_role)){return;}

			$input=$this->input->post();

			log_message("info","User_action.lists(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);

			//step1. 驗證輸入資料格式
			$this->__list_user_format_validate();
			if($this->form_validation->run() != TRUE){
				$this->list_form();
				return;
			}

			$query_result=$this->user_service->find_users_for_list($input);

			$this->list_form($query_result);

			log_message("info","User_action.lists() - end usr_num=".$user->usr_num);

		}

		public function page_detail($usr_num){

        	$user = $this->session->userdata('user');

			log_message("info","User_action.page_detail(detail_usr_num=".$usr_num.") - start usr_num=".$user->usr_num);

			$data['user'] =$this->user_service->find_user_for_update($usr_num);

        	$this->load->view("user/user_page_detail",$data);

			log_message("info","User_action.page_detail(detail_usr_num=".$usr_num.") - end usr_num=".$user->usr_num);
        }

		public function change_passwd_form(){

        	$user = $this->session->userdata('user');


			log_message("info","User_action.change_passwd_form - start usr_num=".$user->usr_num);

        	$this->load->view("user/passwd_uform");

			log_message("info","User_action.change_passwd_form - end usr_num=".$user->usr_num);
        }

		public function change_passwd(){

			$user = $this->session->userdata('user');

			$input=$this->input->post();

			log_message("info","User_action.change_passwd() - start usr_num=".$user->usr_num);
			//step1. 驗證輸入資料格式
			$this->__change_passwd_format_validate($user->usr_passwd);
			if($this->form_validation->run() != TRUE){
				$this->change_passwd_form();
				return;
			}

			$input['usr_num']=$user->usr_num;
			$this->user_service->update_passwd($input);

			$data['message']="維護使用者密碼成功";

			$this->load->view("message",$data);

			log_message("info","User_action.change_passwd() - end usr_num=".$user->usr_num);

		}

		public function member_save_form(){

        	$user = $this->session->userdata('user');

			log_message("info","User_action.member_save_form - start usr_num=".$user->usr_num);

        	$this->load->view("user/user_mem_iform");

			log_message("info","User_action.member_save_form - end usr_num=".$user->usr_num);
        }

		public function member_save(){

			$user = $this->session->userdata('user');

			$input=$this->input->post();

			log_message("info","User_action.member_save(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);

			//step1. 驗證輸入資料格式
			$this->__save_member_format_validate();
			if($this->form_validation->run() != TRUE){
				$this->member_save_form();
				return;
			}


			$new_usr_num = $this->user_service->save_member_user($input);

			$data['message']="新增客戶成功,新客戶流水號:".$new_usr_num;

			$this->load->view("message",$data);

			log_message("info","User_action.member_save() - end usr_num=".$user->usr_num);

		}

		public function old_password_validate($old_password,$confirm_old_passwd){

			if(sha1($old_password)==$confirm_old_passwd){
				return TRUE;
			}else{
				$this->form_validation->set_message('old_password_validate', ' %s 欄位輸入錯誤');
				return FALSE;
			}
		}


		private function __save_user_format_validate(){
			$this->form_validation->set_rules('usr_id', '帳號', 'trim|required|max_length[32]');
			$this->form_validation->set_rules('usr_name', '名稱', 'trim|required|max_length[32]');
		    $this->form_validation->set_rules('usr_passwd', '密碼', 'trim|required|max_length[32]|matches[confirm_usr_passwd]');
			$this->form_validation->set_rules('confirm_usr_passwd', '確認密碼', 'trim|required|max_length[32]');
			$this->form_validation->set_rules('usr_role', '使用者角色', 'trim|required|integer');
			$this->form_validation->set_rules('usr_memo', '備註', 'trim|max_length[1024]');
		}

		private function __update_user_format_validate(){
			$this->form_validation->set_rules('usr_name', '名稱', 'trim|max_length[32]');
			$this->form_validation->set_rules('usr_role', '使用者角色', 'trim');
			$this->form_validation->set_rules('usr_status', '啟用狀態', 'trim');
			$this->form_validation->set_rules('usr_memo', '備註', 'trim|max_length[1024]');
		}

		private function __list_user_format_validate(){
			$this->form_validation->set_rules('usr_id', '帳號', 'trim|max_length[32]');
			$this->form_validation->set_rules('usr_name', '名稱', 'trim|max_length[32]');
			$this->form_validation->set_rules('usr_role', '使用者角色', 'trim');
			$this->form_validation->set_rules('usr_status', '啟用狀態', 'trim');
		}

		private function __change_passwd_format_validate($confirm_old_passwd){
			$this->form_validation->set_rules('old_usr_passwd', '舊密碼', 'trim|required|max_length[32]|callback_old_password_validate['.$confirm_old_passwd.']');
			$this->form_validation->set_rules('usr_passwd', '新密碼', 'trim|required|max_length[32]|matches[confirm_usr_passwd]');
			$this->form_validation->set_rules('confirm_usr_passwd', '確認密碼', 'trim|required|max_length[32]');
		}

		private function __save_member_format_validate(){
			$this->form_validation->set_rules('usr_id', '會員email', 'trim|required|max_length[128]|valid_email');
			$this->form_validation->set_rules('usr_name', '會員名稱', 'trim|required|max_length[32]');
			$this->form_validation->set_rules('usr_memo', '備註', 'trim|max_length[1024]');
		}
	}

?>