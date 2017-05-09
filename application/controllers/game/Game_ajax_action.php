<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    /**
     * 
     */
    class Game_ajax_action extends MY_AjaxController {
    	function __construct()
	    {
	        parent::__construct();
			$this->load->library('form_validation');
			$this->load->model("game/game_service");
	    }
		
		public function check_bar_code(){
			
			$input=$this->input->get();
			
			if(!$this->__user_login_validate()){
				$data->redirect=TRUE;
				echo json_encode($data);
				return;
			}
			
			$user = $this->session->userdata('user');
			
			log_message("info","Game_ajax_action.check_bar_code(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
			$data['checkResult']=$this->game_service->check_bar_code_duplicate($input['bar_code'], $input['gam_num']);
			
			echo json_encode($data);
			
			log_message("info","Game_ajax_action.check_bar_code(input=".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
			
		}
	}
    
?>