<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Report_action extends MY_Controller {
	
	function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("report/report_service");
		$this->load->model('service/pos_data_service');
		
    }
	
	public function gid_record_list_form($query_result=NULL){

		$user = $this->session->userdata('user');

		log_message("info","Report_action.gid_list_form - start usr_num=".$user->usr_num);
		
		if($query_result!=NULL){
			$data['query_result']=$query_result;
		}
		
    	$this->load->view("report/gid_record_qform",$data);
		
		log_message("info","Report_action.gid_list_form - end usr_num=".$user->usr_num);
	}
	
	public function gid_record_list(){
			
		$user = $this->session->userdata('user');

		$input=$this->input->post();
		
		log_message("info","Report_action.gid_record_list(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
		
		
		//step1. 驗證輸入資料格式	
		$this->__list_gid_record_format_validate();
		if($this->form_validation->run() != TRUE){
			$this->gid_record_list_form();
			return;
		}
		
		$query_result=$this->report_service->find_gid_record_for_list($input);
		
		$this->gid_record_list_form($query_result);
		
		log_message("info","Report_action.gid_record_list(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
	}
	
	public function gid_record_page_list(){

		$user = $this->session->userdata('user');

		log_message("info","Report_action.gid_record_page_list - start usr_num=".$user->usr_num);
		
    	$this->load->view("report/gid_record_page_list");
		
		log_message("info","Report_action.gid_record_page_list - end usr_num=".$user->usr_num);
	}
	
	public function pos_record_page_list(){

		$user = $this->session->userdata('user');

		log_message("info","Report_action.pos_record_page_list - start usr_num=".$user->usr_num);
		
    	$this->load->view("report/pos_record_page_list");
		
		log_message("info","Report_action.pos_record_page_list - end usr_num=".$user->usr_num);
	}
	
	public function pos_record_page_table_list_form($query_result=NULL){

		$user = $this->session->userdata('user');

		log_message("info","Report_action.pos_record_page_table_list_form - start usr_num=".$user->usr_num);
		
		$data['now_year']=date('Y');
		$data['now_month']=date('m');
		$data['current_select']=sprintf("%d-%02d", $data['now_year'], $data['now_month']);
		if($query_result!=NULL){
			$data['pos_list']=$query_result['pos_list'];
			$data['tags']=$this->pos_data_service->find_pod_type_tags();
			$data['year']=$query_result['year'];
			$data['month']=$query_result['month'];
			$data['current_select']=$query_result['current_select'];
		}
		
		// print_r($data);
		
    	$this->load->view("report/pos_record_page_table_list",$data);
		
		log_message("info","Report_action.pos_record_page_table_list_form - end usr_num=".$user->usr_num);
	}
	
	public function pos_record_page_table_list(){

		$user = $this->session->userdata('user');
		
		$input=$this->input->post();
		
		log_message("info","Report_action.pos_record_page_table_list(".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
		
		$data['now_year']=date('Y');
		$data['now_month']=date('m');
		$current_select= sprintf("%4d-%02d", date('Y'), date('m'));
		if(isset($input['current_select_date'])){
			$current_select=$input['current_select_date'];
		}
		
		
		$data['current_select']=$current_select;
		$year_and_month=explode('-', $data['current_select']);
		$data['year']=$year_and_month[0];
		$data['month']=$year_and_month[1];
		$data['pos_list'] = 
			$this->report_service->find_pos_record_for_table($data['year'], $data['month']);
		
    	$this->pos_record_page_table_list_form($data);
    	
		log_message("info","Report_action.pos_record_page_table_list(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
	}
	
	private function __list_gid_record_format_validate(){
		$this->form_validation->set_rules('date_from', '查詢起始日期', 'trim|required|max_length[10]');
		$this->form_validation->set_rules('date_to', '查詢結束日期', 'trim|required|max_length[10]');
	}
	
}



?>