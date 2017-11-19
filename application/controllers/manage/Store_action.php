<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Store_action extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model("service/store_data_service");
        $this->load->model("dao/dia_store_dao");
        $this->load->model("constants/form_constants");
    }

    public function save_form(){

        $user = $this->session->userdata('user');

        log_message("info","Store_action.save_form - start usr_num=".$user->usr_num);
        $data = array();
        $data['form_constants'] = $this->form_constants;
        $this->load->view("manage/store_iform", $data);

        log_message("info","Store_action.save_form - end usr_num=".$user->usr_num);
    }

    public function save(){
        $user = $this->session->userdata('user');

        $input=$this->input->post();

        log_message("info","Store_action.save(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);

        //step1. 驗證輸入資料格式
        $this->__store_format_validate();
        if($this->form_validation->run() != TRUE){
            $this->save_form($input);
            return;
        }

        $sto_num = $this->store_data_service->save_store($input);

        $data['message']="新增店舖資料成功";

        $extend_url=array();
        $extend_url[]=$this->__generate_url_data("新增其他店舖資料", "manage/Store_action/save_form/");
        $extend_url[]=$this->__generate_url_data("店舖資料列表", "manage/Store_action/list_form/");
        $data['extend_url']=$extend_url;

        $this->load->view("message",$data);

        log_message("info","Store_action.save(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
    }    
    
    public function update_form($sto_num){
    	$user =$this->session->userdata('user');
    	
    	log_message("info","Store_action.update_form(sto_num=$sto_num) - start usr_num=".$user->usr_num);
    	$data['store'] = $this->dia_store_dao->query_by_pk($sto_num);
    	$data['form_constants'] = $this->form_constants;
    	$this->load->view("manage/store_ajax_uform", $data);
    	
    	log_message("info","Store_action.update_form(sto_num=$sto_num)  - end usr_num=".$user->usr_num);
    	
    }
    
    public function list_form($query_result=NULL){
        $user = $this->session->userdata('user');
        
        log_message("info","Store_action.list_form - start usr_num=".$user->usr_num);
        
        $data= array();
        $data['form_constants'] = $this->form_constants;
        if(!empty($query_result)){
            $data['query_result']=$query_result;
        }
        log_message("info","Store_action.lists_form(".print_r($data,TRUE).") - end usr_num=".$user->usr_num);
        
        $this->load->view("manage/store_qform",$data);
    }
    
    public function lists(){
        $user = $this->session->userdata('user');
        
        $input=$this->input->post();
        
        log_message("info","Store_action.lists(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
        
        $query_result=$this->dia_store_dao->query_by_condition($input);
        log_message("info","Store_action.lists(".print_r($query_result,TRUE).") - end usr_num=".$user->usr_num);
        $this->list_form($query_result);
        
    }
    
    public function update(){
    	$user =$this->session->userdata('user');
    	
    	$input = $this->input->post();
    	
    	log_message("info","Store_action. update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
    	$datas=new stdClass();

    	$datas = $this->dia_tables_dao->query_by_pk($input['dtb_num']);
    	$sto_num =$datas->sto_num;
    	if($input['dtb_name']!=$datas->dtb_name){
        	$this->__update_table_format_validate($sto_num);
        	if($this->form_validation->run() != TRUE){
        		$this->update_form($input['dtb_num']);
        		return;
        	}
    	}
    	$this->tables_service->update_table($input);
    	$data['message']="維護店舖遊戲桌資料成功";
    	
    	$extend_url=array();
    	$extend_url[]=$this->__generate_url_data("繼續維護店舖遊戲桌資料", "manage/Store_action/update_form/",$input['dtb_num']);
    	$extend_url[]=$this->__generate_url_data("查詢店舖遊戲桌資料列表", "manage/Store_action/list_form/");
    	$extend_url[]=$this->__generate_url_data("回公告欄", "manage/manage_action/daily_message_list/");
    	$data['extend_url']=$extend_url;
    	
    	$this->load->view("message",$data);
    	
    	log_message("info","Store_action.tables_update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
    }
     
    private function __store_format_validate(){
    	$this->form_validation->set_rules('sto_name', '店舖名稱', 'trim|required|max_length[48]');
    }
}

?>