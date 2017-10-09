<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Booking_ajax_action extends MY_AjaxController {
	
	function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("manage/booking_service");
		$this->load->model("dao/dia_tables_dao");
		$this->load->model("dao/dia_booking_dao");
    }
	
	public function get_available_tables(){
		
		$user = $this->session->userdata('user');
		
		$input=$this->input->get();
		
		log_message("info","Booking_ajax_action.get_available_tables(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		$result = new stdClass();
		$result->isSuccess=TRUE;
		$result->test="Kai";
		$result->pp = array('a','b','c');
		
		log_message("info","result:".print_r($result,TRUE));
		
		echo json_encode($result);
		
		log_message("info","Booking_ajax_action.get_available_tables(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
		
	}
	
	public function get_count_tables(){
	    $input=$this->input->get();
	    $data = new stdClass();
	    $data = $this->booking_service->find_unbooking_tables($this->date_time_merge($input));
	    echo json_encode($data);
	}
	
	public function booking_list(){
	    $input=$this->input->get();
	    $data = new stdClass();
	    $data = $this->dia_booking_dao->query_by_condition($input);
	    log_message("debug","Booking_ajax_action.booking_list(".print_r($data,TRUE).") - end");
	    echo json_encode($data);
	}
	
	public function checkin_booking(){
	    $input=$this->input->get();
	    $data = $this->booking_service->update_checkin($input);
	    echo json_encode($data);
	}
// 	public function cancel_booking(){
// 	    $input=$this->input->get();
// 	    $this->booking_service->update_cancel($input);
// 	}
	
	private function date_time_merge($input){
	    
	    $date = new DateTime($input["dbk_date"]);
	    $time = new DateTime($input["dbk_time"]);
	    $merge= new DateTime($date->format('Y-m-d') .' ' .$time->format('H:i:s'));
	    $input["dbk_date"]= $merge->format('Y-m-d H:i:s');
	    log_message("debug","Booking_ajax_action.date_time_merge(".print_r($input,TRUE).") - end");
	    return $input;
	}
	
	
	
	
	
	
	
}

?>