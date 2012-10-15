<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Pos_action extends MY_Controller {
	
	function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("manage/pos_service");
    }
	
	public function save_form(){

		$user = $this->session->userdata('user');

		log_message("info","Pos_action.save_form - start usr_num=".$user->usr_num);
		
		$data['tags']=$this->pos_service->find_pod_type_tags();
		$data['pod_date']=date('Y-m-d H:i:s');
		
    	$this->load->view("manage/pos_iform",$data);
		
		log_message("info","Pos_action.save_form - end usr_num=".$user->usr_num);
	}
	
	public function save(){
		$user = $this->session->userdata('user');
		
		$input=$this->input->post();
		
		log_message("info","Pos_action.save(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		$this->__save_format_validate();
		if($this->form_validation->run() != TRUE){
			$this->save_form();
			return;
		}
			
		$pod_num = $this->pos_service->save_pos($input, $user->usr_num);
		
		$data['message']="新增銷售資料成功 銷售單號:".$pod_num;
		
		$extend_url=array();
		$extend_url[]=$this->__generate_url_data("繼續新增銷售資料", "manage/pos_action/save_form/");
		$extend_url[]=$this->__generate_url_data("維護銷售資料", "manage/pos_action/update_form/",$pod_num);
		$extend_url[]=$this->__generate_url_data("查詢銷售資料", "manage/pos_action/pos_list_form/");
		$data['extend_url']=$extend_url;
		
		$this->load->view("message",$data);
			
		log_message("info","Pos_action.save() - end usr_num=".$user->usr_num);
	}

	public function multiple_save(){
		$user = $this->session->userdata('user');
		
		$input=$this->input->post();
		
		log_message("info","Pos_action.multiple_save(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		// $this->__save_format_validate();
		// if($this->form_validation->run() != TRUE){
			// $this->save_form();
			// return;
		// }
		print_r($input);
			
		$pod_nums = $this->pos_service->save_multiple_pos($input, $user->usr_num);
		$data=array();
		$data['message']="新增銷售資料成功 銷售單號:".join($pod_nums,",");
		
		$extend_url=array();
		$extend_url[]=$this->__generate_url_data("繼續新增銷售資料", "manage/pos_action/save_form/");
		$extend_url[]=$this->__generate_url_data("查詢銷售資料", "manage/pos_action/pos_list_form/");
		$data['extend_url']=$extend_url;
		$this->load->view("message",$data);
			
		log_message("info","Pos_action.multiple_save(input=".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
	}
	
	public function update_form($pod_num){

		$user = $this->session->userdata('user');

		log_message("info","Pos_action.update_form(pod_num=$pod_num) - start usr_num=".$user->usr_num);
		
		$pos=$this->pos_service->find_pos($pod_num);
		
    	$this->load->view("manage/pos_uform",$pos);
		
		log_message("info","Pos_action.update_form(pod_num=$pod_num) - end usr_num=".$user->usr_num);
	}
	
	public function update(){
		
		$user = $this->session->userdata('user');
		
		$input=$this->input->post();
		
		log_message("info","Pos_action.update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		$this->__update_format_validate();
		if($this->form_validation->run() != TRUE){
			$this->update_form();
			return;
		}
			
		$this->pos_service->update_pos($input, $user->usr_num);
		
		$data['message']="維護銷售資料成功 銷售單號:".$input['pod_num'];
		
		$extend_url=array();
		$extend_url[]=$this->__generate_url_data("回維護銷售資料", "manage/pos_action/update_form/",$input['pod_num']);
		$extend_url[]=$this->__generate_url_data("查詢銷售資料", "manage/pos_action/pos_list_form/");
		$data['extend_url']=$extend_url;
		
		$this->load->view("message",$data);
			
		log_message("info","Pos_action.update() - end usr_num=".$user->usr_num);
	}
	
	public function remove($pod_num){
		
		$user = $this->session->userdata('user');
		
		log_message("info","Pos_action.remove(pod_num=$pod_num) - start usr_num=".$user->usr_num);
			
		$this->pos_service->remove_pos($pod_num, $user->usr_num);
		
		$data['message']="刪除銷售資料成功 銷售單號:".$pod_num;
		
		$extend_url=array();
		$extend_url[]=$this->__generate_url_data("查詢銷售資料", "manage/pos_action/pos_list_form/");
		$data['extend_url']=$extend_url;
		
		$this->load->view("message",$data);
			
		log_message("info","Pos_action.remove(pod_num=$pod_num) - end usr_num=".$user->usr_num);
	}
	
	public function pos_list_form($query_result=NULL){
		
		$user = $this->session->userdata('user');
		
		log_message("info","Pos_action.pos_list() - start usr_num=".$user->usr_num);
		
		$data=NULL;
		if($query_result!=NULL){
			$data['query_result']=$query_result;	
		}
		
		$this->load->view("manage/pos_qform",$data);
		
		log_message("info","Pos_action.pos_list() - end usr_num=".$user->usr_num);
		
	}
	
	public function pos_list(){
		
		$user = $this->session->userdata('user');
		
		// if($this->__user_role_check($user->usr_role)){return;}		
		$input=$this->input->post();
		
		log_message("info","Pos_action.pos_list(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
		
		//step1. 驗證輸入資料格式	
		$this->__list_format_validate();
		if($this->form_validation->run() != TRUE){
			$this->pos_list_form();
			return;
		}
			
		$query_result=$this->pos_service->find_view_pos_for_list($input);
		$this->pos_list_form($query_result);
		
		log_message("info","Pos_action.pos_list(input=".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
		
	}
	
	private function __save_format_validate(){
		$this->form_validation->set_rules('pod_desc', '銷售說明', 'trim|max_length[256]|xss_clean');
		$this->form_validation->set_rules('pod_svalue', '銷售金額', 'trim|required|integer|max_length[12]|xss_clean');
	}
	
	private function __update_format_validate(){
		
		$this->form_validation->set_rules('pod_desc', '銷售說明', 'trim|max_length[256]|xss_clean');
		$this->form_validation->set_rules('pod_svalue', '銷售金額', 'trim|required|integer|max_length[12]|xss_clean');
	}
	
	private function __list_format_validate(){
		
		$this->form_validation->set_rules('pod_date', '查詢日期', 'trim|required|xss_clean');
	}
	
	
	
}

?>