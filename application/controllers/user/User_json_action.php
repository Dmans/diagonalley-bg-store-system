<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    /**
     *
     */
class User_json_action extends MY_AuthAjaxController{
    	function __construct()
	    {
	        parent::__construct();
	        $this->load->library('form_validation');
	        $this->load->model("user/user_service");
	        $this->load->model('service/store_data_service');
	        $this->load->model('constants/form_constants');

	    }
	    
	    public function update(){
	        
	        $user = $this->session->userdata('user');
	        
	        $input=$this->input->post();
	        
// 	        if ($user->usr_num != $input['usr_num'] and $this->__user_role_check($user->usr_role)) {
// 	            return;
// 	        }
	        
	        log_message("info","User_json_action.update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
	        $data = new stdClass();
	        //step1. 驗證輸入資料格式
	        //step1. 驗證輸入資料格式
	        $this->__update_user_format_validate();
	        if($this->form_validation->run() != TRUE){
	            $data->isSuccess=FALSE;
	            $data->errorMessage = validation_errors();
	            echo json_encode($data);
	            return;
	        }
	        
	        if ($user->usr_role != 0) {
	            unset($input['sto_nums']);
	        }
	        
	        $this->user_service->update_user($input);
	        
	        $data->message="維護使用者成功";
	        $data->isSuccess=TRUE;
	        
	        echo json_encode($data);
	        
	        log_message("info","User_json_action.update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
	        
	    }
		
		private function __update_user_format_validate(){
		    $this->form_validation->set_rules('usr_name', '名稱', 'trim|required|max_length[32]');
		    $this->form_validation->set_rules('usr_role', '使用者角色', 'trim');
		    $this->form_validation->set_rules('usr_status', '啟用狀態', 'trim');
		    $this->form_validation->set_rules('usr_memo', '備註', 'trim|max_length[1024]');
		    $this->form_validation->set_rules('usr_mail', '信箱', 'trim|valid_email');
		}

	}

?>