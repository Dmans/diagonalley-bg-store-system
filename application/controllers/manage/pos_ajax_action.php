<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Pos_ajax_action extends MY_Controller {
	
	function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("manage/pos_service");
    }
	
	public function pos_list(){
		
		$user = $this->session->userdata('user');
		
		$input=$this->input->post();
		
		log_message("info","Pos_ajax_action.pos_list(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		// $this->__list_format_validate();
		// if($this->form_validation->run() != TRUE){
			// $this->pos_list_form();
			// return;
		// }
			
		$query_result=$this->pos_service->find_view_pos_for_list($input);
		
		$data=NULL;
		$data["query_result"]=$query_result;

		$this->load->view("manage/pos_page_list",$data);
		
		log_message("info","Pos_ajax_action.pos_list(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
		
	}
	
	public function pos_fast_save(){
		
		$user = $this->session->userdata('user');
		
		$input=$this->input->post();
		
		log_message("info","Pos_ajax_action.pos_fast_create(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		// $this->__list_format_validate();
		// if($this->form_validation->run() != TRUE){
			// $this->pos_list_form();
			// return;
		// }
		/*	
		
		
		$data=NULL;
		$data["query_result"]=$query_result;

		$this->load->view("manage/pos_page_list",$data);
		*/
		
		$this->pos_service->save_pos_fast($input, $user->usr_num);
		
		log_message("info","Pos_ajax_action.pos_fast_create(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
		
	}
	
}

?>