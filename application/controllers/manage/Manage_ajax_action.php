<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Manage_ajax_action extends MY_AjaxController {
	
	function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("manage/manage_service");
    }
	
	public function gid_status_update(){
		
		$user = $this->session->userdata('user');
		
		$input=$this->input->post();
		
		log_message("info","Manage_ajax_action.gid_status_update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		$grd_num = $this->manage_service->update_gid_status($input,$user->usr_num);
		
		
		$result->isSuccess=TRUE;
		$result->grd_num=$grd_num;
		
		log_message("info","result:".print_r($result,TRUE));
		
		echo json_encode($result);
		
		log_message("info","Manage_ajax_action.gid_status_update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
		
	}
	
}

?>