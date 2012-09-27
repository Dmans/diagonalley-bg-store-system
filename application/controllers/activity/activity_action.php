<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Activity_action extends MY_Controller {
	
	function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("activity/activity_service");
    }
	
    public function save_form(){
        	
    	$user = $this->session->userdata('user');
		
		// if($this->__user_role_check($user->usr_role)){return;}
		
		log_message("info","Activity_action.save_form() - start usr_num=".$user->usr_num);
		// log_message("info","user_role:".$user->usr_role);
		
		$data['usr_role'] =$user->usr_role ;
    	
    	$this->load->view("activity/activity_iform",$data);
		
		log_message("info","Activity_action.save_form() - end usr_num=".$user->usr_num);
    }
		
	public function save(){
		
		$user = $this->session->userdata('user');
		
		// if($this->__user_role_check($user->usr_role)){return;}
		
		$input=$this->input->post();
		
		log_message("info","Activity_action.save(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		$this->__save_activity_format_validate();
		if($this->form_validation->run() != TRUE){
			$this->save_form();
			return;
		}
			
		$this->activity_service->save_activity($input);
		
		$data['message']="新增活動成功";
		
		$this->load->view("message",$data);
			
		log_message("info","Activity_action.save() - end usr_num=".$user->usr_num);
			
	}
	
	public function update_form($act_num){
        	
    	$user = $this->session->userdata('user');
		
		// if($this->__user_role_check($user->usr_role)){return;}
		
		log_message("info","Activity_action.update_form(act_num=$act_num) - start usr_num=".$user->usr_num);
		
		// $data['usr_role'] =$user->usr_role ;
		
		$update_act=$this->activity_service->find_activity_for_update($act_num);
		
		log_message("info","update_act:".print_r($update_act,TRUE));

    	
    	$this->load->view("activity/activity_uform",$update_act);
		
		log_message("info","Activity_action.update_form(act_num=$act_num) - end usr_num=".$user->usr_num);
    }
	
	public function update(){
		
		$user = $this->session->userdata('user');
		
		// if($this->__user_role_check($user->usr_role)){return;}
		
		$input=$this->input->post();
		
		log_message("info","Activity_action.update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		$this->__update_activity_format_validate();
		if($this->form_validation->run() != TRUE){
			$this->load->view("activity/activity_uform");
			// $this->update_form($input['act_num']);
			return;
		}
		
		$this->activity_service->update_activity($input);
		
		$data['message']="維護活動成功";
		
		$this->load->view("message",$data);
		
		log_message("info","Activity_action.update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
		
	}
	
	public function list_form($query_result=NULL){
        	
    	$user = $this->session->userdata('user');
		
		log_message("info","Activity_action.list_form - start usr_num=".$user->usr_num);
		
		$data=null;
		
		if(!empty($query_result)){
			$data['query_result']=$query_result;
		}
    	
    	$this->load->view("activity/activity_qform",$data);
		
		log_message("info","Activity_action.list_form - end usr_num=".$user->usr_num);
    }
	
	public function act_list(){
		
		$user = $this->session->userdata('user');
		
		$input=$this->input->post();
		
		log_message("info","Activity_action.act_list(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		$this->__list_activity_format_validate();
		if($this->form_validation->run() != TRUE){
			//$this->load->view("login_form");
			$this->list_form();
			return;
		}
		
		$query_result=$this->activity_service->find_activitys_for_list($input);
		
		$this->list_form($query_result);
		
		log_message("info","Activity_action.act_list() - end usr_num=".$user->usr_num);
		
	}
	
	public function page_detail($act_num){
    	
    	$user = $this->session->userdata('user');
		
		// if($this->__user_role_check($user->usr_role)){return;}
		
		log_message("info","Activity_action.page_detail(act_num=$act_num) - start usr_num=".$user->usr_num);
		
		// $data['usr_role'] =$user->usr_role ;
		
		$act =$this->activity_service->find_activity_for_update($act_num);
    	
    	$this->load->view("activity/activity_page_detail",$act);
		
		log_message("info","Activity_action.page_detail(act_num=$act_num) - end usr_num=".$user->usr_num);
    }
    
	private function __save_activity_format_validate(){
		$this->form_validation->set_rules('act_name', '活動名稱', 'trim|required|max_length[32]|xss_clean');
		$this->form_validation->set_rules('act_desc', '活動說明', 'trim|required|max_length[128]|xss_clean');
		$this->form_validation->set_rules('act_value', '活動數值', 'trim|required|greater_than[-1]|integer|xss_clean');
		$this->form_validation->set_rules('act_type', '活動類型', 'trim|xss_clean');
		$this->form_validation->set_rules('act_status', '活動啟用狀態', 'trim|xss_clean');
	}
	
	private function __update_activity_format_validate(){
		$this->form_validation->set_rules('act_name', '活動名稱', 'trim|required|max_length[32]|xss_clean');
		$this->form_validation->set_rules('act_desc', '活動說明', 'trim|required|max_length[128]|xss_clean');
		$this->form_validation->set_rules('act_value', '活動數值', 'trim|required|greater_than[-1]|integer|xss_clean');
		$this->form_validation->set_rules('act_type', '活動類型', 'trim|xss_clean');
		$this->form_validation->set_rules('act_status', '活動啟用狀態', 'trim|xss_clean');
	}
	
	private function __list_activity_format_validate(){
		$this->form_validation->set_rules('act_name', '活動名稱', 'trim|max_length[32]|xss_clean');
		$this->form_validation->set_rules('act_desc', '活動說明', 'trim|max_length[128]|xss_clean');
		$this->form_validation->set_rules('act_type', '活動類型', 'trim|xss_clean');
		$this->form_validation->set_rules('act_status', '活動啟用狀態', 'trim|xss_clean');
	}
	
	
}



?>