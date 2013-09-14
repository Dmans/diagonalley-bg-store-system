<?php
    /**
     * 
     */
    class MY_Controller extends CI_Controller {
        
        function __construct() {
            parent::__construct();
			if($this->session->userdata('logged_in') != TRUE){
				redirect("login_action/logout","refresh");
			}
        }
		
		protected function __user_role_check($usr_role){
			if($usr_role >= 2){
				$data['message']="無此功能使用權限";
				$this->load->view("message",$data);
				return TRUE;
			}
		}
		
		protected function __generate_url_data($title,$target_url,$param=NULL){
			$url_data=NULL;
			$url_data->title=$title;
			
			if($param!=NULL){
				$target_url=$target_url.$param;
			}
			
			$url_data->url=site_url($target_url);
			
			return $url_data;
		}
    }
	
	/**
	 * controller for ajax
	 */
	class MY_AjaxController extends CI_Controller {
        
        function __construct() {
            parent::__construct();
			/*if($this->session->userdata('logged_in') != TRUE){
				redirect("login_action/logout","refresh");
			}*/
        }
		/*
		protected function __user_role_check($usr_role){
			if($usr_role >= 2){
				$data['message']="無此功能使用權限";
				$this->load->view("message",$data);
				return TRUE;
			}
		}*/
		
		protected function __user_login_validate(){
			log_message("info","ffffff");
			$login=$this->session->userdata('logged_in');
			if(empty($login)){
				return FALSE;
			}
			
			log_message("info","gggg");
			if($this->session->userdata('logged_in') != TRUE){
				return FALSE;
			}
			return TRUE;
		}
		
		protected function __generate_url_data($title,$target_url,$param=NULL){
			$url_data=NULL;
			$url_data->title=$title;
			
			if($param!=NULL){
				$target_url=$target_url.$param;
			}
			
			$url_data->url=site_url($target_url);
			
			return $url_data;
		}
    }
    
?>