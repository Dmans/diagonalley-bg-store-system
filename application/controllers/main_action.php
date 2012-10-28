<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Main_action extends MY_Controller{
		
	function __construct()
	{
	    parent::__construct();
		$this->load->helper(array('form','url'));
	}
		
	public function index(){
		$this->load->view("main_frameset");
	}
	
	public function menu(){
		
		$user = $this->session->userdata('user');
		$usr_role = $user->usr_role;
		
		$data['usr_name']=$user->usr_name;
		$data['usr_role']=$user->usr_role;
		
		$this->load->view("main_list", $data);
		$this->load->view("logout");
		if($user->usr_role==0 or $user->usr_role==1){
			$this->load->view("menu/game_module");
			// $this->load->view("menu/activity_module");
			$this->load->view("menu/user_module");
		}
		
		$this->load->view("menu/report_module");
		$this->load->view("menu/manage_module");
		$this->load->view("menu/employ_module", $data);
		if($user->usr_role==2){
			
		}
		
	}
	
	public function page(){
		$this->load->view("main_page");		
	}
}



?>