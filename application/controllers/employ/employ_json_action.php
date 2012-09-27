<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    /**
     * 
     */
    class Employ_json_action extends CI_Controller {
    	function __construct()
	    {
	        parent::__construct();
			$this->load->library('form_validation');
			$this->load->model("employ/employ_service");
			
	    }
		
		public function save(){
			if(!$this->__user_login_validate()){
				$data->redirect=TRUE;
				echo json_encode($data);
				return;
			}
			
			$user = $this->session->userdata('user');
			
			log_message("info","Employ_json_action.save() - start usr_num=".$user->usr_num);
			
			$has_unfinished=$this->employ_service->check_unfinished_checkin($user->usr_num);
			
			if($has_unfinished){
				$data->isSuccess=FALSE;
			}else{
				$chk = $this->employ_service->check_in($user->usr_num);
			
				$data->chk=$chk;
				$data->isSuccess=TRUE;
				
				log_message("chk=".print_r($chk,TRUE));
			}
			
			echo json_encode($data);
			
			log_message("info","Employ_json_action.save() - end usr_num=".$user->usr_num);
			
		}

		public function update(){
			
			if(!$this->__user_login_validate()){
				$data->redirect=TRUE;
				echo json_encode($data);
				return;
			}
			
			$user = $this->session->userdata('user');
			
			$input=$this->input->post();
			
			log_message("info","Employ_json_action.update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
				
			//step1. 驗證輸入資料格式	
			$this->__update_employ_format_validate();
			if($this->form_validation->run() != TRUE){
				$data->isSuccess=FALSE;
				echo json_encode($data);
				return;
			}
			$chk_num=$input['chk_num'];
			$data->isSuccess=$this->employ_service->check_out($chk_num,$user->usr_num);
			$data->chk_out_time=date('Y-m-d H:i:s');
			
			echo json_encode($data);
			
			log_message("info","Employ_json_action.update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
			
		}
		
		public function update_confirm(){
			
			if(!$this->__user_login_validate()){
				$data->redirect=TRUE;
				echo json_encode($data);
				return;
			}
			
			$user = $this->session->userdata('user');
			
			$input=$this->input->post();
			
			log_message("info","Employ_json_action.update_confirm(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
				
			//step1. 驗證輸入資料格式	
			$this->__update_employ_format_validate();
			if($this->form_validation->run() != TRUE){
				$data->isSuccess=FALSE;
				echo json_encode($data);
				return;
			}
			// $chk_num=$input['chk_num'];
			$data->isSuccess=$this->employ_service->confirm($input,$user->usr_num);
			$data->confirm_date=date('Y-m-d H:i:s');
			
			echo json_encode($data);
			
			log_message("info","Employ_json_action.update_confirm(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
			
		}
		
		private function __user_login_validate(){
			$login=$this->session->userdata('logged_in');
			if(empty($login)){
				return FALSE;
			}
			
			
			if($this->session->userdata('logged_in') != TRUE){
				return FALSE;
			}
			return TRUE;
		}
		
		private function __update_employ_format_validate(){
			$this->form_validation->set_rules('chk_num', '打卡流水號', 'trim|required|integer|xss_clean');
		}
		
		private function __list_user_format_validate(){
			$this->form_validation->set_rules('usr_id', '帳號', 'trim|max_length[32]|xss_clean');
			$this->form_validation->set_rules('usr_name', '名稱', 'trim|max_length[32]|xss_clean');
			$this->form_validation->set_rules('usr_role', '使用者角色', 'trim|xss_clean');
			$this->form_validation->set_rules('usr_status', '啟用狀態', 'trim|xss_clean');
		}
		
	}
    
?>