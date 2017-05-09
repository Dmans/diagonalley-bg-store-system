<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_pos_action extends CI_Controller {
		
	function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("order/order_service");
    }
	
	public function save_form(){
        	
    	$user = $this->session->userdata('user');
		
		log_message("info","Order_action.save_form() - start usr_num=".$user->usr_num);
		
		$data['usr_role'] =$user->usr_role;
    	$data['ord_date']=date('Y-m-d H:i:s');
		$data['default_usr_num']=$this->order_service->find_default_usr_num();
    	$this->load->view("order/order_iform",$data);
		
		log_message("info","Order_action.save_form() - end usr_num=".$user->usr_num);
	}}

?>