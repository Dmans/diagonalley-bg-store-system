<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Report_json_action extends MY_Controller {
	
	function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("report/report_service");
    }
	
	public function gid_record_list(){
			
		$user = $this->session->userdata('user');

		$input=$this->input->get();
		
		log_message("info","Report_json_action.gid_record_list(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
		
		// $date=date( "Y-m-d H:i:s",$input['start']);
		// log_message("info",$date);
		$start=date( "Y-m-d H:i:s",$input['start']);
		$end=date( "Y-m-d H:i:s",$input['end']);
		log_message("info",json_encode($this->report_service->find_gid_record_for_calendar($start,$end)));
		echo json_encode($this->report_service->find_gid_record_for_calendar($start,$end));
		
		
		// log_message("info",print_r($this->report_service->find_gid_record_for_calendar($start,$end),TRUE));
		// $data['usr_role']=$user->usr_role ;
		// echo print_r($input,TRUE);
		
		
		// //step1. 驗證輸入資料格式	
		// $this->__list_gid_record_format_validate();
		// if($this->form_validation->run() != TRUE){
			// $this->gid_record_list_form();
			// return;
		// }
// 		
		// $query_result=$this->report_service->find_gid_record_for_list($input);
		
		// $this->gid_record_list_form($query_result);
		// echo json_encode("no");
		
		
		log_message("info","Report_json_action.gid_record_list(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
	}
	
	public function gid_record_page_list($query_result=NULL){

		$user = $this->session->userdata('user');

		log_message("info","Report_action.gid_record_page_list - start usr_num=".$user->usr_num);
		
		if($query_result!=NULL){
			$data['query_result']=$query_result;
		}
		
		// $data['gids']=$this->manage_service->find_gids_for_list();
		// $data['usr_role']=$user->usr_role ;
		
    	$this->load->view("report/gid_record_page_list",$data);
		
		log_message("info","Report_action.gid_record_page_list - end usr_num=".$user->usr_num);
	}
	
	public function gid_status_update(){
		
		$user = $this->session->userdata('user');
		
		// if($this->__user_role_check($user->usr_role)){return;}
		
		$input=$this->input->post();
		
		log_message("info","Manage_action.gid_status_update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		// $this->__update_gid_format_validate();
		// if($this->form_validation->run() != TRUE){
			// //$this->load->view("login_form");
			// $this->gid_update_form($input['gid_num']);
			// return;
		// }
		
		$grd_num = $this->manage_service->update_gid_status($input,$user->usr_num);
		
		
		$result->isSuccess=TRUE;
		$result->grd_num=$grd_num;
		
		log_message("info","result:".print_r($result,TRUE));
		
		echo json_encode($result);
		
		// $data['message']="維護上架遊戲成功";->load->view("message",$data);
		
		log_message("info","Manage_action.gid_status_update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
		
	}
	
	public function daily_save_form(){

		$user = $this->session->userdata('user');

		log_message("info","Manage_action.daily_save_form - start usr_num=".$user->usr_num);
		
		
		
		// $data['gids']=$this->manage_service->find_gids_for_list();
		// $data['usr_role']=$user->usr_role ;
		
		
    	$this->load->view("manage/daily_iform",$data);
		
		log_message("info","Manage_action.daily_save_form - end usr_num=".$user->usr_num);
	}
	
	public function daily_save(){
		$user = $this->session->userdata('user');
		
		// if($this->__user_role_check($user->usr_role)){return;}
		
		$input=$this->input->post();
		
		log_message("info","Manage_action.daily_save(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		$this->__save_daily_format_validate();
		if($this->form_validation->run() != TRUE){
			$this->daily_save_form();
			return;
		}
		$ddr_num = $this->manage_service->save_daily_record($input,$user->usr_num);
		
		$data['message']="新增日誌成功";
		
		$this->load->view("message",$data);
		
		log_message("info","Manage_action.daily_save(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
	}
	
	public function daily_update(){
		$user = $this->session->userdata('user');
		
		// if($this->__user_role_check($user->usr_role)){return;}
		
		$input=$this->input->post();
		
		log_message("info","Manage_action.daily_update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		// //step1. 驗證輸入資料格式	
		// $this->__save_daily_format_validate();
		// if($this->form_validation->run() != TRUE){
			// $this->daily_save_form();
			// return;
		// }
		// $ddr_num = $this->manage_service->save_daily_record($input,$user->usr_num);
// 		
		// $data['message']="新增日誌成功";
// 		
		// $this->load->view("message",$data);
		
		log_message("info","Manage_action.daily_update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
	}
	
	public function daily_page_list(){
			
		$user = $this->session->userdata('user');

		log_message("info","Manage_action.daily_page_list - start usr_num=".$user->usr_num);
		
		$data['dailys']=$this->manage_service->find_daily_record_for_list($user->usr_num);
		// $data['usr_role']=$user->usr_role ;
		
		
    	$this->load->view("manage/daily_record_page_list",$data);
		
		log_message("info","Manage_action.daily_page_list - end usr_num=".$user->usr_num);
	}

	private function __save_daily_format_validate(){
		$this->form_validation->set_rules('ddr_content', '日誌內容', 'trim|required|max_length[2048]|xss_clean');
	}
	

	
	private function __list_gid_record_format_validate(){
		$this->form_validation->set_rules('date_from', '查詢起始日期', 'trim|required|max_length[10]|xss_clean');
		$this->form_validation->set_rules('date_to', '查詢結束日期', 'trim|required|max_length[10]|xss_clean');
	}
	
	// private function __save_gid_format_validate(){
		// $this->form_validation->set_rules('gid_status', '遊戲成本價', 'trim|required|integer|xss_clean');
		// $this->form_validation->set_rules('gid_rentable', '遊戲是否可出租', 'trim|required|integer|xss_clean');
	// }
// 	
	// private function __update_gid_format_validate(){
		// $this->form_validation->set_rules('gid_status', '遊戲成本價', 'trim|required|integer|xss_clean');
		// $this->form_validation->set_rules('gid_num', '遊戲是否可出租', 'trim|required|integer|xss_clean');
	// }
	
	
	
    
}



?>