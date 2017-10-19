<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Calendar_action extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model("manage/Calendar_service");
        $this->load->model("constants/form_constants");
    }
    
    public function save_form($data = array()){
        
        $user = $this->session->userdata('user');
        if($this->__user_role_check($user->usr_role)){return;}
        
        log_message("info","Calendar_action.save_form - start usr_num=".$user->usr_num);
        $data['form_constants'] = $this->form_constants;
        $this->load->view("manage/calendar_iform",$data);
        
        log_message("info","Calendar_action.save_form - end usr_num=".$user->usr_num);
    }
    
    public function save(){
        
        $user = $this->session->userdata('user');
        
        if($this->__user_role_check($user->usr_role)){return;}
        
        $input=$this->input->post();
        
        log_message("info","Calendar_action.save(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
        
        //step1. 驗證輸入資料格式
        $this->__calendar_format_validate();
        if($this->form_validation->run() != TRUE){
            $this->save_form($input);
            return;
        }
        
        $cal_num=$this->Calendar_service->save_calendar($input);
        
        $data['message']="新增行事曆成功";
        
        $extend_url=array();
        $extend_url[]=$this->__generate_url_data("繼續新增行事曆", "manage/Calendar_action/save_form/");
        $extend_url[]=$this->__generate_url_data("查詢行事曆", "manage/Calendar_action/list_form/");
        $data['extend_url']=$extend_url;
        
        
        $this->load->view("message",$data);
        
        log_message("info","Calendar_action.save() - end usr_num=".$user->usr_num);
        
    }
    
    public function update_form($cal_num){
        
        $user = $this->session->userdata('user');
        
        log_message("info","Calendar_action.update_form(cal_num=".$cal_num.") - start usr_num=".$user->usr_num);
        
        $data = (array) $this->Calendar_service->find_calendar_for_update($cal_num);
        $data['form_constants'] = $this->form_constants;
        
        $this->load->view("manage/calendar_uform",$data);
        
        log_message("info","Calendar_action.update_form(cal_num=".$cal_num.") - end usr_num=".$user->usr_num);
    }
    
    public function update(){
        
        $user = $this->session->userdata('user');
        
        $input=$this->input->post();
        
        log_message("info","Calendar_action.update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
        
        //step1. 驗證輸入資料格式
        $this->__calendar_format_validate();
        if($this->form_validation->run() != TRUE){
            $this->update_form($input['cal_num']);
            return;
        }
        
        $this->Calendar_service->update_calendar($input);
        
        $data['message']="維護行事曆成功";
        
        $extend_url=array();
        $extend_url[]=$this->__generate_url_data("繼續新增行事曆", "manage/Calendar_action/save_form/");
        $extend_url[]=$this->__generate_url_data("繼續維護行事曆", "manage/Calendar_action/update_form/".$input["cal_num"]);
        $extend_url[]=$this->__generate_url_data("查詢行事曆", "manage/Calendar_action/list_form/");
        $data['extend_url']=$extend_url;
        
        $this->load->view("message",$data);
        
        log_message("info","Calendar_action.update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
        
    }
    
    public function list_form($data = array()){
        
        $user = $this->session->userdata('user');
        
        $input=$this->input->post();
        
        log_message("info","Calendar_action.list_form - start usr_num=".$user->usr_num);
        
        $data['form_constants'] = $this->form_constants;
        $this->load->view("manage/calendar_qform",$data);
        
        log_message("info","Calendar_action.list_form - end usr_num=".$user->usr_num);
    }
    
    public function lists(){
        
        $user = $this->session->userdata('user');
        
        $input=$this->input->post();
        
        log_message("info","Calendar_action.list(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
        
        $data = $input;
        $data['query_result'] = $this->Calendar_service->find_calendar($input);
        
        $this->list_form($data);
        
        log_message("info","Calendar_action.list - end usr_num=".$user->usr_num);
    }
    
    public function remove($cal_num) {
        $user = $this->session->userdata('user');
        
        log_message("info","Calendar_action.remove(cal_num=".$cal_num.") - start usr_num=".$user->usr_num);
        
        $this->Calendar_service->remove_calendar($cal_num);
        
        $data['message']="刪除常用薪資附加項目成功";
        
        $extend_url=array();
        $extend_url[]=$this->__generate_url_data("繼續新增行事曆", "manage/Calendar_action/save_form/");
        $extend_url[]=$this->__generate_url_data("查詢行事曆", "manage/Calendar_action/list_form/");
        $data['extend_url']=$extend_url;
        
        $this->load->view("message",$data);
        
        log_message("info","Calendar_action.remove(cal_num=".$cal_num.") - end usr_num=".$user->usr_num);
        
    }
    
    private function __calendar_format_validate(){
        $this->form_validation->set_rules('cal_desc', '日期說明', 'trim|max_length[256]');
        $this->form_validation->set_rules('cal_date', '日期', 'trim|required');
    }
 
}
?>