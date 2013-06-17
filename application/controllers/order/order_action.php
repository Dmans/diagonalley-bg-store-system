<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Order_action extends MY_Controller {
	
	function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("order/order_service");    }
	
    public function save_form(){
        	
    	$user = $this->session->userdata('user');
		
		log_message("info","Order_action.save_form() - start usr_num=".$user->usr_num);
		
		$data['usr_role'] =$user->usr_role;
    	$data['ord_date']=date('Y-m-d H:i:s');
		$data['default_usr_num']=$this->order_service->find_default_usr_num();
    	$this->load->view("order/order_iform",$data);
		
		log_message("info","Order_action.save_form() - end usr_num=".$user->usr_num);
    }
		
	public function save(){
		
		$user = $this->session->userdata('user');
		
		// if($this->__user_role_check($user->usr_role)){return;}
		
		$input=$this->input->post();
		
		log_message("info","Order_action.save(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		$this->__save_order_format_validate();
		if($this->form_validation->run() != TRUE){
			$this->save_form();
			return;
		}
		
		
		$input['ord_usr_num']=$user->usr_num;
		$ord_num=$this->order_service->save_order($input);
		
		$data['message']="新增訂單成功 訂單編號:".$ord_num;
		
		$extend_url=array();
		$extend_url[]=$this->__generate_url_data("繼續新增訂單", "order/order_action/save_form/");
		$extend_url[]=$this->__generate_url_data("回查詢訂單資料", "order/order_action/list_form/");
		$data['extend_url']=$extend_url;
		
		$this->load->view("message",$data);
			
		log_message("info","Order_action.save() - end usr_num=".$user->usr_num);
			
	}
	
	public function update_form($ord_num){
        	
    	$user = $this->session->userdata('user');
		
		log_message("info","Order_action.update_form(ord_num=$ord_num) - start usr_num=".$user->usr_num);
		
		$order =$this->order_service->find_order_for_update($ord_num);
		
		log_message("info","update_act:".print_r($update_act,TRUE));

    	$this->load->view("order/order_uform",$order);
		
		log_message("info","Order_action.update_form(ord_num=$ord_num) - end usr_num=".$user->usr_num);
    }
	
	public function update(){
		
		$user = $this->session->userdata('user');
		
		$input=$this->input->post();
		
		log_message("info","Order_action.update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		$this->__update_order_format_validate();
		if($this->form_validation->run() != TRUE){
			$this->load->view("order/order_uform");
			return;
		}
		
		$this->order_service->update_order($input);
		
		$data['message']="維護訂單成功";
		
		// $extend_url=array();
		// $extend_url[]=$this->__generate_url_data("為", "order/order_action/update_form/");
		// $extend_url[]=$this->__generate_url_data("回公告欄", "manage/manage_action/daily_message_list/");
		// $data['extend_url']=$extend_url;
// 		
		$this->load->view("message",$data);
		
		log_message("info","Order_action.update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
		
	}

	public function cancel($ord_num){
		
		$user = $this->session->userdata('user');
		
		log_message("info","Order_action.cancel(ord_num=$ord_num) - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		// $this->__update_order_format_validate();
		// if($this->form_validation->run() != TRUE){
			// $this->load->view("order/order_uform");
			// return;
		// }
		
		$input=NULL;
		$input['ord_num']=$ord_num;
		$input['ord_status']=2; //取消狀態
		$this->order_service->update_order($input);
		
		$data['message']="取消訂單成功";
		
		$extend_url=array();
		$extend_url[]=$this->__generate_url_data("回查詢訂單資料", "order/order_action/list_form/");
		$data['extend_url']=$extend_url;
		$this->load->view("message",$data);
		
		log_message("info","Order_action.cancel(ord_num=$ord_num) - end usr_num=".$user->usr_num);
		
	}
	
	public function list_form($query_result=NULL){
        	
    	$user = $this->session->userdata('user');
		
		log_message("info","Order_action.list_form - start usr_num=".$user->usr_num);
		
		$data=NULL;
		if(!empty($query_result)){
			$data['query_result']=$query_result;
		}
		
		$data['usr_role']=$user->usr_role;
    	
    	$this->load->view("order/order_qform",$data);
		
		log_message("info","Order_action.list_form - end usr_num=".$user->usr_num);
    }
	
	public function order_list(){
		
		$user = $this->session->userdata('user');
		
		$input=$this->input->post();
		
		log_message("info","Order_action.order_list(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		$this->__list_order_format_validate();
		if($this->form_validation->run() != TRUE){
			$this->list_form();
			return;
		}
		
		$query_result=$this->order_service->find_orders_for_list($input);
		
		$this->list_form($query_result);
		
		log_message("info","Order_action.order_list() - end usr_num=".$user->usr_num);
		
	}
	
	public function page_detail($ord_num){
    	
    	$user = $this->session->userdata('user');
		
		log_message("info","Order_action.page_detail(ord_num=$ord_num) - start usr_num=".$user->usr_num);
		
		$order =$this->order_service->find_order_for_update($ord_num);
    	
    	$this->load->view("order/order_page_detail",$order);
		
		log_message("info","Order_action.page_detail(ord_num=$ord_num) - end usr_num=".$user->usr_num);
    }
	
	
    
	private function __save_order_format_validate(){
		$this->form_validation->set_rules('usr_num', '訂購會員帳號', 'trim|required|integer|max_length[32]|xss_clean');
		$this->form_validation->set_rules('gam_num', '訂購遊戲', 'trim|required|integer|max_length[32]|xss_clean');
		$this->form_validation->set_rules('gam_svalue', '遊戲售價', 'trim|required|integer|xss_clean');
	}
	
	// private function __update_activity_format_validate(){
		// $this->form_validation->set_rules('act_name', '活動名稱', 'trim|required|max_length[32]|xss_clean');
		// $this->form_validation->set_rules('act_desc', '活動說明', 'trim|required|max_length[128]|xss_clean');
		// $this->form_validation->set_rules('act_value', '活動數值', 'trim|required|greater_than[-1]|integer|xss_clean');
		// $this->form_validation->set_rules('act_type', '活動類型', 'trim|xss_clean');
		// $this->form_validation->set_rules('act_status', '活動啟用狀態', 'trim|xss_clean');
	// }
// 	
	private function __list_order_format_validate(){
		$this->form_validation->set_rules('ord_num', '訂單流水號', 'trim|integer|max_length[32]|xss_clean');
		$this->form_validation->set_rules('gam_name', '遊戲名稱', 'trim|max_length[128]|xss_clean');
		$this->form_validation->set_rules('gam_num', '遊戲流水號', 'trim||integer|max_length[32]|xss_clean');
		$this->form_validation->set_rules('start_order_date', '訂購日期區間開始日', 'trim|xss_clean');
		$this->form_validation->set_rules('end_order_date', '訂購日期區間結束日', 'trim|xss_clean');
	}
	
	
}



?>