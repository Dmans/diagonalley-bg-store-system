<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Manage_action extends MY_Controller {
	
	function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("manage/manage_service");
    }
	
	public function gid_list_form(){

		$user = $this->session->userdata('user');

		log_message("info","Manage_action.gid_list_form - start usr_num=".$user->usr_num);
		
		$data['gids']=$this->manage_service->find_gids_for_list();
		
    	$this->load->view("manage/mang_gid_page_list",$data);
		
		log_message("info","Manage_action.gid_list_form - end usr_num=".$user->usr_num);
	}
	
	public function daily_save_form(){

		$user = $this->session->userdata('user');

		log_message("info","Manage_action.daily_save_form - start usr_num=".$user->usr_num);
		
    	$this->load->view("manage/daily_iform");
		
		log_message("info","Manage_action.daily_save_form - end usr_num=".$user->usr_num);
	}
	
	public function daily_save(){
		$user = $this->session->userdata('user');
		
		$input=$this->input->post();
		
		log_message("info","Manage_action.daily_save(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		$this->__save_daily_format_validate();
		if($this->form_validation->run() != TRUE){
			$this->daily_save_form();
			return;
		}
		
		$ddr_num = $this->manage_service->save_daily_record($input,$user->usr_num);
		
		$data['message']="新增公告成功";
		
		$extend_url=array();
		$extend_url[]=$this->__generate_url_data("繼續新增公告", "manage/manage_action/daily_save_form/");
		$extend_url[]=$this->__generate_url_data("維護公告", "manage/manage_action/daily_update_form/",$ddr_num);
		$extend_url[]=$this->__generate_url_data("公告欄資料列表", "manage/manage_action/daily_page_list/");
		$extend_url[]=$this->__generate_url_data("回公告欄", "manage/manage_action/daily_message_list/");
		$data['extend_url']=$extend_url;
		
		$this->load->view("message",$data);
		
		log_message("info","Manage_action.daily_save(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
	}
	
	public function daily_update_form($ddr_num){

		$user = $this->session->userdata('user');

		log_message("info","Manage_action.daily_update_form(ddr_num=$ddr_num) - start usr_num=".$user->usr_num);
		
		$ddr = $this->manage_service->find_daily_record($ddr_num);
		
    	$this->load->view("manage/daily_uform",$ddr);
		
		log_message("info","Manage_action.daily_update_form(ddr_num=$ddr_num)  - end usr_num=".$user->usr_num);
	}
	
	public function daily_update(){
		$user = $this->session->userdata('user');
		
		$input=$this->input->post();
		
		log_message("info","Manage_action.daily_update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		$this->__update_daily_format_validate();
		if($this->form_validation->run() != TRUE){
			$this->daily_update_form();
			return;
		}
		$this->manage_service->update_daily_record($input);
		$data['message']="維護公告成功";		
		$extend_url=array();
		$extend_url[]=$this->__generate_url_data("繼續維護公告", "manage/manage_action/daily_update_form/",$input['ddr_num']);
		$extend_url[]=$this->__generate_url_data("公告欄資料列表", "manage/manage_action/daily_page_list/");
		$extend_url[]=$this->__generate_url_data("回公告欄", "manage/manage_action/daily_message_list/");
		$data['extend_url']=$extend_url;
		
		$this->load->view("message",$data);
		
		log_message("info","Manage_action.daily_update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
	}

	public function daily_remove($ddr_num){

		$user = $this->session->userdata('user');
		
		$input=$this->input->post();
		
		log_message("info","Manage_action.daily_remove(ddr_num=$ddr_num) - start usr_num=".$user->usr_num);
		
		$input=NULL;
		$input['ddr_num']=$ddr_num;
		$input['ddr_status']=2;
		
		$this->manage_service->update_daily_record($input);

		$data['message']="刪除公告成功";
		
		$extend_url=array();
		$extend_url[]=$this->__generate_url_data("公告欄資料列表", "manage/manage_action/daily_page_list/");
		$extend_url[]=$this->__generate_url_data("回公告欄", "manage/manage_action/daily_message_list/");
		$data['extend_url']=$extend_url;
		
		$this->load->view("message",$data);
		
		log_message("info","Manage_action.daily_remove(ddr_num=$ddr_num) - end usr_num=".$user->usr_num);
	}
	
	public function daily_page_list(){
			
		$user = $this->session->userdata('user');

		log_message("info","Manage_action.daily_page_list - start usr_num=".$user->usr_num);
		
		$data['dailys']=$this->manage_service->find_dailys($user->usr_num);
		
    	$this->load->view("manage/daily_record_page_list",$data);
		
		log_message("info","Manage_action.daily_page_list - end usr_num=".$user->usr_num);
	}
	
	public function daily_message_list(){
		$user = $this->session->userdata('user');

		log_message("info","Manage_action.daily_message_list - start usr_num=".$user->usr_num);
		
		$data['dailys']=$this->manage_service->find_dailys();
		$data['top_dailys']=$this->manage_service->find_ontop_dailys();
    	$this->load->view("manage/daily_message_list",$data);
		
		log_message("info","Manage_action.daily_message_list - end usr_num=".$user->usr_num);
	}

	private function __save_daily_format_validate(){
		$this->form_validation->set_rules('ddr_content', '公告內容', 'trim|required|max_length[2048]');
		$this->form_validation->set_rules('ddr_status', '公告狀態', 'trim|required');
	}
	
	private function __update_daily_format_validate(){
		$this->form_validation->set_rules('ddr_content', '公告內容', 'trim|required|max_length[2048]');
		$this->form_validation->set_rules('ddr_status', '公告狀態', 'trim|required');
	}
	
}

?>