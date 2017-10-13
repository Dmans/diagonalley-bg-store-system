<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Salary_default_options_action extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model("salary/Salary_default_options_service");
        $this->load->model("constants/form_constants");
    }
    
    public function save_form($data = array()){
        
        $user = $this->session->userdata('user');
        if($this->__user_role_check($user->usr_role)){return;}
        
        log_message("info","Salary_default_options_action.save_form - start usr_num=".$user->usr_num);
        $data['form_constants'] = $this->form_constants;
        $this->load->view("salary/salary_default_options_iform",$data);
        
        log_message("info","Salary_default_options_action.save_form - end usr_num=".$user->usr_num);
    }
    
    public function save(){
        
        $user = $this->session->userdata('user');
        
        if($this->__user_role_check($user->usr_role)){return;}
        
        $input=$this->input->post();
        
        log_message("info","Salary_default_options_action.save(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
        
        //step1. 驗證輸入資料格式
        $this->__default_options_format_validate();
        if($this->form_validation->run() != TRUE){
            $this->save_form($input);
            return;
        }
        
        $dsdo_num=$this->Salary_default_options_service->save_default_option($input);
        
        $data['message']="新增常用薪資附加項目成功,使用者流水號:".$dsdo_num;
        
        $extend_url=array();
        $extend_url[]=$this->__generate_url_data("繼續新增常用薪資附加項目", "salary/Salary_default_options_action/save_form/");
        $extend_url[]=$this->__generate_url_data("維護常用薪資附加項目", "salary/Salary_default_options_action/update_form/", $dsdo_num);
        $extend_url[]=$this->__generate_url_data("查詢常用薪資附加項目", "salary/Salary_default_options_action/list_form/");
        $data['extend_url']=$extend_url;
        
        
        $this->load->view("message",$data);
        
        log_message("info","Salary_default_options_action.save() - end usr_num=".$user->usr_num);
        
    }
    
    public function update_form($dsdo_num){
        
        $user = $this->session->userdata('user');
        
        log_message("info","Salary_default_options_action.update_form(dsdo_num=".$dsdo_num.") - start usr_num=".$user->usr_num);
        
        $data = (array) $this->Salary_default_options_service->find_default_option_for_update($dsdo_num);
        $data['form_constants'] = $this->form_constants;
        
        $this->load->view("salary/salary_default_options_uform",$data);
        
        log_message("info","Salary_default_options_action.update_form(dsdo_num=".$dsdo_num.") - end usr_num=".$user->usr_num);
    }
    
    public function update(){
        
        $user = $this->session->userdata('user');
        
        $input=$this->input->post();
        
        log_message("info","Salary_default_options_action.update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
        
        //step1. 驗證輸入資料格式
        $this->__default_options_format_validate();
        if($this->form_validation->run() != TRUE){
            $this->update_form($input['dsdo_num']);
            return;
        }
        
        $this->Salary_default_options_service->update_default_option($input);
        
        $data['message']="維護常用薪資附加項目成功";
        
        $extend_url=array();
        $extend_url[]=$this->__generate_url_data("繼續新增常用薪資附加項目", "salary/Salary_default_options_action/save_form/");
        $extend_url[]=$this->__generate_url_data("維護常用薪資附加項目", "salary/Salary_default_options_action/update_form/", $input['dsdo_num']);
        $extend_url[]=$this->__generate_url_data("查詢常用薪資附加項目", "salary/Salary_default_options_action/list_form/");
        $data['extend_url']=$extend_url;
        
        $this->load->view("message",$data);
        
        log_message("info","Salary_default_options_action.update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
        
    }
    
    public function list_form($data = array()){
        
        $user = $this->session->userdata('user');
        
        $input=$this->input->post();
        
        log_message("info","Salary_default_options_action.list_form - start usr_num=".$user->usr_num);
        
        $data['form_constants'] = $this->form_constants;
        $this->load->view("salary/salary_default_options_qform",$data);
        
        log_message("info","Salary_default_options_action.list_form - end usr_num=".$user->usr_num);
    }
    
    public function lists(){
        
        $user = $this->session->userdata('user');
        
        $input=$this->input->post();
        
        log_message("info","Salary_default_options_action.list(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
        
        $data = $input;
        $data['query_result'] = $this->Salary_default_options_service->find_default_options($input);
        
        $this->list_form($data);
        
        log_message("info","Salary_default_options_action.list - end usr_num=".$user->usr_num);
    }
    
    public function remove($dsdo_num) {
        $user = $this->session->userdata('user');
        
        
        log_message("info","Salary_default_options_action.remove(dsdo_num=".$dsdo_num.") - start usr_num=".$user->usr_num);
        
        $this->Salary_default_options_service->remove_default_option($dsdo_num);
        
        $data['message']="刪除常用薪資附加項目成功";
        
        $extend_url=array();
        $extend_url[]=$this->__generate_url_data("新增常用薪資附加項目", "salary/Salary_default_options_action/save_form/");
        $extend_url[]=$this->__generate_url_data("查詢常用薪資附加項目", "salary/Salary_default_options_action/list_form/");
        $data['extend_url']=$extend_url;
        
        $this->load->view("message",$data);
        
        log_message("info","Salary_default_options_action.remove(dsdo_num=".$dsdo_num.") - end usr_num=".$user->usr_num);
        
    }
    
    private function __default_options_format_validate(){
        $this->form_validation->set_rules('dsdo_desc', '項目說明', 'trim|required|max_length[32]');
        $this->form_validation->set_rules('dsdo_value', '項目金額', 'trim|required|integer');
    }
 
}
?>