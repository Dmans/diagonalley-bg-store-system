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
	
	
	public function pos_record_list(){
			
		$user = $this->session->userdata('user');

		$input=$this->input->get();
		
		log_message("info","Report_json_action.pos_record_list(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
		
		$start=date( "Y-m-d H:i:s",$input['start']);
		$end=date( "Y-m-d H:i:s",$input['end']);
		
		echo json_encode($this->report_service->find_pos_for_report($start,$end));
			
		log_message("info","Report_json_action.pos_record_list(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
	}

	
	
    
}



?>