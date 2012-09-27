<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    /**
     * 
     */
    class Employ_action extends MY_Controller {
    	function __construct()
	    {
	        parent::__construct();
			$this->load->library('form_validation');
			$this->load->model("employ/employ_service");
			
	    }
		
		public function list_form(){
        	
        	$user = $this->session->userdata('user');
			
			log_message("info","Employ_action.list_form - start usr_num=".$user->usr_num);
			
			$chks = $this->employ_service->find_user_check_list($user->usr_num);
			
			if(count($chks)==1){
				$chk=$chks;
				$chks=NULL;
				$chks[]=$chk;
			}
			
			$data['chks']=$chks;
			$data['usr_name']=$user->usr_name;
        	
        	$this->load->view("employ/employ_page_list",$data);
			
			log_message("info","Employ_action.list_form - end usr_num=".$user->usr_num);
        }
		
		public function change_passwd_form(){
        	
        	$user = $this->session->userdata('user');
			
			log_message("info","Employ_action.change_passwd_form - start usr_num=".$user->usr_num);
			
        	$this->load->view("user/passwd_uform");
			
			log_message("info","Employ_action.change_passwd_form - end usr_num=".$user->usr_num);
        }
		
		public function change_passwd(){
			
			$user = $this->session->userdata('user');
			
			$input=$this->input->post();
			
			log_message("info","Employ_action.change_passwd() - start usr_num=".$user->usr_num);
				
			//step1. 驗證輸入資料格式	
			$this->__change_passwd_format_validate();
			if($this->form_validation->run() != TRUE){
				//$this->load->view("login_form");
				$this->change_passwd_form();
				return;
			}
			
			
			$this->user_service->update_passwd($input);
			
			$data['message']="維護使用者密碼成功";
			
			$this->load->view("message",$data);
			
			log_message("info","Employ_action.change_passwd() - end usr_num=".$user->usr_num);
			
		}
		
		public function confirm_list_form(){
        	
        	$user = $this->session->userdata('user');
			
			if($this->__user_role_check($user->usr_role)){return;}
			
			log_message("info","Employ_action.confirm_list_form - start usr_num=".$user->usr_num);
			
			$chks = $this->employ_service->find_uncheck_list();
			
			log_message("info","chks:".print_r($chks,TRUE));
			
			$data['chks']=$chks;
			
			// $data['usr_name']=$user->usr_name;
			
        	
        	$this->load->view("employ/employ_uncheck_list",$data);
			
			log_message("info","Employ_action.confirm_list_form - end usr_num=".$user->usr_num);
        }
		
		public function employ_monthly_list_form($query_result=NULL){
        	
        	$user = $this->session->userdata('user');
			
			$input=$this->input->post();
			
			log_message("info","Employ_action.employ_monthly_list_form - start usr_num=".$user->usr_num);
			
			$data=null;
			if($query_result!=NULL){
				$data['query_result']=$query_result;
			}
        	
        	$this->load->view("employ/employ_monthly_page_list",$data);
			
			log_message("info","Employ_action.employ_monthly_list_form - end usr_num=".$user->usr_num);
        }
		
		public function employ_monthly_list(){
        	
        	$user = $this->session->userdata('user');
			
			$input=$this->input->post();
			
			log_message("info","Employ_action.employ_monthly_list(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
			
			$query_result=$this->employ_service->find_employ_monthly_record($input['chk_start_date'],$input['chk_end_date']);
        	
        	$this->employ_monthly_list_form($query_result);
			
			log_message("info","Employ_action.employ_monthly_list - end usr_num=".$user->usr_num);
        }
		
		
		
		private function __change_passwd_format_validate(){
			$this->form_validation->set_rules('old_usr_passwd', '舊密碼', 'trim|required|max_length[32]|xss_clean');
			$this->form_validation->set_rules('usr_passwd', '新密碼', 'trim|required|max_length[32]|matches[confirm_usr_passwd]|xss_clean');
			$this->form_validation->set_rules('confirm_usr_passwd', '確認密碼', 'trim|required|max_length[32]|xss_clean');
		}
	}
    
?>