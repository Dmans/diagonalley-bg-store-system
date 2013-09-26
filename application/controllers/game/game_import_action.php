<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Game_import_action extends MY_Controller {
	
	function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("game/game_import_service");
    }
	
	public function game_import_save_form(){
        	
    	$user = $this->session->userdata('user');
		
		// if($this->__user_role_check($user->usr_role)){return;}
		
		log_message("info","Game_import_action.game_import_save_form() - start usr_num=".$user->usr_num);
		
		$data['usr_role'] =$user->usr_role ;
    	
    	$this->load->view("game/import/game_import_iform",$data);
		
		log_message("info","Game_import_action.game_import_save_form() - end usr_num=".$user->usr_num);
    }
	
	public function game_import_list_form($query_data=NULL){

		$user = $this->session->userdata('user');

		log_message("info","Game_import_action.game_import_list_form - start usr_num=".$user->usr_num);
		$data=array();
		
		if($query_data!=NULL){
			$data['query_result']=$query_data['query_result'];
		}
		
    	$this->load->view("game/import/game_import_qform", $data);
		
		log_message("info","Game_import_action.game_import_list_form - end usr_num=".$user->usr_num);
	}
	
	public function game_import_list(){

		$user = $this->session->userdata('user');
		
		$input=$this->input->post();
		
		log_message("info","Game_import_action.game_import_list(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
		
		$query_data=array();
		$query_data['query_result']=$this->game_import_service->find_game_import_list($input['start_gim_date'],$input['end_gim_date']);

		$this->game_import_list_form($query_data);
		
		log_message("info","Game_import_action.game_import_list(input=".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
	}
	
	public function game_import_page_detail($gim_num){
			
		$user = $this->session->userdata('user');

		log_message("info","Game_import_action.game_import_page_detail(gim_num=$gim_num) - start usr_num=".$user->usr_num);
		
		
		$data['gim_detail']=$this->game_import_service->find_game_import_detail($gim_num);
		
    	$this->load->view("game/import/game_import_page_detail",$data);
		
		log_message("info","Game_import_action.game_import_page_detail(gim_num=$gim_num) - end usr_num=".$user->usr_num);
	}
    
}



?>