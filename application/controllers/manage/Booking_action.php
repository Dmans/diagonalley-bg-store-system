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
;    }
	
	public function save_form(){

		$user = $this->session->userdata('user');

		log_message("info","Booking_action.save_form - start usr_num=".$user->usr_num);
		
    	$this->load->view("manage/booking_iform");
		
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
	
	public function list_form($query_result=NULL){
	    $user = $this->session->userdata('user');
	 
	    log_message("info","Tables_action.list_form - start usr_num=".$user->usr_num);
    	$data= array();
	    $data['stores'] = $this->store_data_service->get_real_stores_by_user_num($user->usr_num);
	    log_message("info","Tables_action.lists_form(".print_r($data,TRUE).") - end usr_num=".$user->usr_num);
	    if(!empty($query_result)){
	       $data['query_result']=$query_result;
	    }
	    log_message("info","Tables_action.lists_form2(".print_r($data,TRUE).") - end2 usr_num=".$user->usr_num);
	 
	    $this->load->view("manage/tables_qform",$data);
	}
	
	public function lists(){
	    $user = $this->session->userdata('user');
	    $input=$this->input->post();
	    log_message("info","Tables_action.lists(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
	    $data['bookings']=$this->booking_service->find_enabled_bookings($input);
	    log_message("info","Tables_action.lists(".print_r($query_result,TRUE).") - end usr_num=".$user->usr_num);
	    $this->list_form($query_result);
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
	
	public function booking_page_list(){
			
		$user = $this->session->userdata('user');

		log_message("info","Booking_action.booking_page_list - start usr_num=".$user->usr_num);
		
		$data['bookings']=$this->booking_service->find_enabled_bookings();

    	$this->load->view("manage/booking_page_list",$data);
		
		log_message("info","Booking_action.booking_page_list - end usr_num=".$user->usr_num);
	}
	
	public function booking_message_list(){
	 
	 $user = $this->session->userdata('user');
	 
	 log_message("info","Booking_action.booking_page_list - start usr_num=".$user->usr_num);
	 $data['bookings']=$this->booking_service->find_enabled_bookings(date('Y-m-d H:i:s',strtotime("now +1 week")));
	 log_message("info","Booking_action.booking_message_list(".print_r($data['bookings'],TRUE).") - end");
	 
	 $this->load->view("manage/booking_message_list",$data);
	 
	 log_message("info","Booking_action.booking_page_list - end usr_num=".$user->usr_num);
	}
	
	
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
	
}

?>