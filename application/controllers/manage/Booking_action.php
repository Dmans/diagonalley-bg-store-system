<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Booking_action extends MY_Controller {
	
	function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("manage/booking_service");
		$this->load->model("dao/dia_store_dao");
		$this->load->model("service/store_data_service");
	}
	
	public function save_form($sto_num){

		$user = $this->session->userdata('user');

		log_message("info","Booking_action.save_form - start usr_num=".$user->usr_num);
		$data['stores']=$this->dia_store_dao->query_by_sto_num($sto_num);
		log_message("info","Booking_action.save11111111111111(input=".print_r($data,TRUE).") - start usr_num=".$user->usr_num);
		
    	$this->load->view("manage/booking_iform",$data);
		
		log_message("info","Booking_action.save_form - end usr_num=".$user->usr_num);
	}
	
	public function save(){
		$user = $this->session->userdata('user');
		
		$input=$this->input->post();
		
		log_message("info","Booking_action.save(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		$this->__save_booking_format_validate();
		if($this->form_validation->run() != TRUE){
			$this->save_form();
			return;
		}
		
		$dbk_num = $this->booking_service->save_booking($input,$user->usr_num);
		
		$data['message']="新增定位資料成功";
		
		$extend_url=array();
		$extend_url[]=$this->__generate_url_data("新增其他定位資料", "manage/booking_action/save_form/");
		$extend_url[]=$this->__generate_url_data("維護定位資料", "manage/booking_action/update_form/",$dbk_num);
		$extend_url[]=$this->__generate_url_data("定位資料列表", "manage/booking_action/booking_page_list/");
		$extend_url[]=$this->__generate_url_data("回公告欄", "manage/manage_action/daily_message_list/");
		$data['extend_url']=$extend_url;
		
		$this->load->view("message",$data);
		
		log_message("info","Booking_action.save(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
	}
	
	public function update_form($dbk_num){

		$user = $this->session->userdata('user');

		log_message("info","Booking_action.update_form(dbk_num=$dbk_num) - start usr_num=".$user->usr_num);
		
		$dbk = $this->booking_service->find_booking($dbk_num);
		
    	$this->load->view("manage/booking_uform",$dbk);
		
		log_message("info","Booking_action.update_form(dbk_num=$dbk_num)  - end usr_num=".$user->usr_num);
	}
	
	public function update(){
		$user = $this->session->userdata('user');
		
		$input=$this->input->post();
		
		log_message("info","Booking_action.update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		$this->__update_booking_format_validate();
		if($this->form_validation->run() != TRUE){
			$this->update_form();
			return;
		}
		$this->booking_service->update_booking($input);
		$data['message']="維護定位資料成功";		
		$extend_url=array();
		$extend_url[]=$this->__generate_url_data("繼續維護定位資料", "manage/booking_action/update_form/",$input['dbk_num']);
		$extend_url[]=$this->__generate_url_data("定位資料列表", "manage/booking_action/booking_page_list/");
		$extend_url[]=$this->__generate_url_data("回公告欄", "manage/manage_action/daily_message_list/");
		$data['extend_url']=$extend_url;
		
		$this->load->view("message",$data);
		
		log_message("info","Booking_action.update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
	}

	public function list_form($data=array()){
	    $user = $this->session->userdata('user');
	    
	    log_message("info","booking_action.list_form - start usr_num=".$user->usr_num);
	    $data['stores'] = $this->store_data_service->get_real_stores_by_user_num($user->usr_num);
	    $data['month_options'] = $this->get_month_options();
	    log_message("info","booking_action.lists_form2(".print_r($data,TRUE).") - end usr_num=".$user->usr_num);
	    $this->load->view("manage/booking_qform",$data);
	}
	
	public function lists(){
	    $user = $this->session->userdata('user');
	    $input=$this->input->post();
	    log_message("info","booking_action.lists(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
	    $query_result=$this->booking_service->find_bookings_list($input);
	    log_message("info","booking_action.lists(".print_r($query_result,TRUE).") - end usr_num=".$user->usr_num);
	    $data = array();
	    $data['query_result'] = $query_result;
	    $this->list_form($data);
	}
	public function booking_historical_lists(){
	    $user = $this->session->userdata('user');
	    $input=$this->input->post();
	    // 	    $this->__lists_booking_format_validate();
	    // 	    if($this->form_validation->run() != TRUE){
	    // 	     $this->list_form();
	    // 	     return;
	    // 	    }
	    log_message("info","booking_action.lists(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
	    $query_result=$this->booking_service->find_historical_list($input);
	    log_message("info","booking_action.lists(".print_r($query_result,TRUE).") - end usr_num=".$user->usr_num);
	    $data = array();
	    $data['query_result'] = $query_result;
	    $this->list_form($data);
	}

	public function remove($dbk_num){

		$user = $this->session->userdata('user');
		
		log_message("info","Booking_action.remove(dbk_num=$dbk_num) - start usr_num=".$user->usr_num);
		
		$input=NULL;
		$input['dbk_num']=$dbk_num;
		$input['dbk_status']=2;
		
		$this->booking_service->update_booking($input);

		$data['message']="刪除定位資料成功";
		
		$extend_url=array();
		$extend_url[]=$this->__generate_url_data("新增其他定位資料", "manage/booking_action/save_form/");
		$extend_url[]=$this->__generate_url_data("定位資料列表", "manage/booking_action/booking_page_list/");
		$data['extend_url']=$extend_url;
		
		$this->load->view("message",$data);
		
		log_message("info","Booking_action.remove(dbk_num=$dbk_num) - end usr_num=".$user->usr_num);
	}
	
	public function booking_page_list($dbk_num){
			
		$user = $this->session->userdata('user');

		log_message("info","Booking_action.booking_page_list - start usr_num=".$user->usr_num);
		
		$data['bookings']=$this->booking_service->find_booking($dbk_num);

    	$this->load->view("manage/booking_page_list",$data);
		
		log_message("info","Booking_action.booking_page_list - end usr_num=".$user->usr_num);
	}
	
	public function booking_message_list(){
	 
	    $user = $this->session->userdata('user');
	 
	    log_message("info","Booking_action.booking_page_list - start usr_num=".$user->usr_num);
	
	    $data['bookings']=$this->booking_service->find_enabled_bookings(date('Y-m-d H:i:s',strtotime("now +1 week")));
	    
	    log_message("info","Booking_action.booking_message_list(".print_r($data['bookings'],TRUE).") - end");
	   
	    $data['stores']=$this->store_data_service->get_real_stores();
	   
	    $this->load->view("manage/booking_message_list",$data);
	 
	}
	
// 	public function phone_validate($dbk_phone){
// 	    if(preg_match("/09[0-9]{2}[0-9]{6}/", $dbk_phone)){
// 	        return TRUE;
// 	    }else{
// 	        $this->form_validation->set_message('phone_validate', ' %s 欄位輸入錯誤');
// 	        return FALSE;
// 	    }
// 	}
	
	private function __save_booking_format_validate(){
		$this->form_validation->set_rules('dbk_date', '定位時間', 'trim|required');
		$this->form_validation->set_rules('dbk_memo', '定位資訊', 'trim|required|max_length[2048]');
		$this->form_validation->set_rules('dbk_status', '定位狀態', 'trim|required');
	}
	
	private function __update_booking_format_validate(){
		$this->form_validation->set_rules('dbk_date', '定位時間', 'trim|required');
		$this->form_validation->set_rules('dbk_memo', '定位資訊', 'trim|required|max_length[2048]');
		$this->form_validation->set_rules('dbk_status', '定位狀態', 'trim|required');
	}
	
// 	private function __lists_booking_format_validate(){
// 	 $this->form_validation->set_rules('dbk_phone', '客戶手機', 'callback_phone_validate');
// 	}

	private function get_month_options() {
	    $first_day = date('Y-m-01');
	    return [date('Y-m', strtotime($first_day)),
	            date('Y-m', strtotime("$first_day -1 month")),
	            date('Y-m', strtotime("$first_day -2 month")),
	            date('Y-m', strtotime("$first_day -3 month")),
	            date('Y-m', strtotime("$first_day -4 month")),
	            date('Y-m', strtotime("$first_day -5 month"))
	    ];
	}
	
	
}

?>