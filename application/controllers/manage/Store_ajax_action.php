<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Store_ajax_action extends MY_AuthAjaxController{

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model("service/store_data_service");
        $this->load->model("dao/dia_store_dao");
        $this->load->model("constants/form_constants");
    }
    
    public function update(){
        
        $user = $this->session->userdata('user');
        
        $input=$this->input->post();
        
        log_message("info","Store_ajax_action.update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
        $data = new stdClass();
        
        //step1. 驗證輸入資料格式
        $this->__store_format_validate();
        if($this->form_validation->run() != TRUE){
            $data->isSuccess=FALSE;
            $data->errorMessage = validation_errors();
            echo json_encode($data);
            return;
        }
        
        $this->dia_store_dao->update($input);
        
        $data->message="維護店舖成功";
        $data->isSuccess=TRUE;
        
        echo json_encode($data);
        
        log_message("info","Store_ajax_action.update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
        
    }
    
    private function __store_format_validate(){
        $this->form_validation->set_rules('sto_name', '店舖名稱', 'trim|required|max_length[48]');
    }
    
}

?>