<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    /**
     * 
     */
    class Order_ajax_action extends MY_AjaxController {
    	function __construct()
	    {
	        parent::__construct();
			$this->load->library('form_validation');
			$this->load->model("order/order_ajax_service");
	    }
		
		public function users_autocomplete(){
			
			$input=$this->input->get();
			
			if(!$this->__user_login_validate()){
				$data->redirect=TRUE;
				echo $input['callback']."(".json_encode($data).");";
				return;
			}
			
			$user = $this->session->userdata('user');
			
			log_message("info","Order_ajax_action.users_autocomplete(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
			$data->users=$this->order_ajax_service->find_users_for_autocomplete($input);
			
			log_message("info","data=".print_r($data,TRUE));
			
			echo $input['callback']."(".json_encode($data).");";
			
			log_message("info","Order_ajax_action.users_autocomplete(input=".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
			
		}
		
		public function games_autocomplete(){
			
			$input=$this->input->get();
			
			if(!$this->__user_login_validate()){
				$data->redirect=TRUE;
				echo $input['callback']."(".json_encode($data).");";
				return;
			}
			
			$user = $this->session->userdata('user');
			
			log_message("info","Order_ajax_action.games_autocomplete(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
			$data->games=$this->order_ajax_service->find_games_for_autocomplete($input);
			
			log_message("info","data=".print_r($data,TRUE));
			
			echo $input['callback']."(".json_encode($data).");";
			
			log_message("info","Order_ajax_action.games_autocomplete(input=".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
			
		}

		public function update(){
			
			if(!$this->__user_login_validate()){
				$data->redirect=TRUE;
				echo json_encode($data);
				return;
			}
			
			$user = $this->session->userdata('user');
			
			$input=$this->input->post();
			
			log_message("info","Order_ajax_action.update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
				
			//step1. 驗證輸入資料格式	
			$this->__update_employ_format_validate();
			if($this->form_validation->run() != TRUE){
				$data->isSuccess=FALSE;
				echo json_encode($data);
				return;
			}
			$chk_num=$input['chk_num'];
			$data->isSuccess=$this->employ_service->check_out($chk_num,$user->usr_num);
			$data->chk_out_time=date('Y-m-d H:i:s');
			
			echo json_encode($data);
			
			log_message("info","Order_ajax_action.update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
			
		}
		
		public function update_confirm(){
			
			if(!$this->__user_login_validate()){
				$data->redirect=TRUE;
				echo json_encode($data);
				return;
			}
			
			$user = $this->session->userdata('user');
			
			$input=$this->input->post();
			
			log_message("info","Order_ajax_action.update_confirm(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
				
			//step1. 驗證輸入資料格式	
			$this->__update_employ_format_validate();
			if($this->form_validation->run() != TRUE){
				$data->isSuccess=FALSE;
				echo json_encode($data);
				return;
			}
			$chk_num=$input['chk_num'];
			$data->isSuccess=$this->employ_service->confirm($chk_num,$user->usr_num);
			$data->confirm_date=date('Y-m-d H:i:s');
			
			echo json_encode($data);
			
			log_message("info","Order_ajax_action.update_confirm(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
			
		}
		
		private function __update_employ_format_validate(){
			$this->form_validation->set_rules('chk_num', '打卡流水號', 'trim|required|integer');
		}
		
		private function __list_user_format_validate(){
			$this->form_validation->set_rules('usr_id', '帳號', 'trim|max_length[32]');
			$this->form_validation->set_rules('usr_name', '名稱', 'trim|max_length[32]');
			$this->form_validation->set_rules('usr_role', '使用者角色', 'trim');
			$this->form_validation->set_rules('usr_status', '啟用狀態', 'trim');
		}
		
	}
    
?>