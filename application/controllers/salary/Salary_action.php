<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Salary_action extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model("salary/salary_service");
        $this->load->model("service/store_data_service");
        $this->load->model("constants/form_constants");
    }
    
    public function part_time_monthly_list_form($data = array()){
        
        $user = $this->session->userdata('user');
        
        $input=$this->input->post();
        
        log_message("info","Salary_action.part_time_monthly_list_form - start usr_num=".$user->usr_num);
        
        $data['month_options'] = $this->get_month_options();
        $data['form_constants'] = $this->form_constants;
        $this->load->view("salary/part_time_monthly_page_list",$data);
        
        log_message("info","Salary_action.part_time_monthly_list_form - end usr_num=".$user->usr_num);
    }
    
    public function part_time_monthly_list(){
        
        $user = $this->session->userdata('user');
        
        $input=$this->input->post();
        
        log_message("info","Salary_action.part_time_monthly_list(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
        
        $data = array();
        $data['query_result'] = $this->salary_service->get_part_time_checkin_data($input['year_month'], $user->usr_num);
        $data['year_month'] = $input['year_month'];
        
        $this->part_time_monthly_list_form($data);
        
        log_message("info","Salary_action.part_time_monthly_list - end usr_num=".$user->usr_num);
    }
    
    public function part_time_salary_confirm(){
        
        $user = $this->session->userdata('user');
        
        $input=$this->input->post();
        
        log_message("info","Salary_action.part_time_salary_confirm(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
        
//         print_r($input);
        $confirm_hours = $input['confirm_hours'];
        
        $extra_options = array();
        if(isset($input['dso_desc'])) {
            $extra_options['dso_desc'] = $input['dso_desc'];
            $extra_options['dso_type'] = $input['dso_type'];
            $extra_options['dso_value'] = $input['dso_value'];
        }
        
        $this->salary_service->confirm_part_time_checkin_data($input['confirm_hours'], $extra_options, $input['year_month'], $user->usr_num);
        $data= array();
        $data['message'] = "確認工讀生薪資成功";
        
        $extend_url=array();
        $extend_url[]=$this->__generate_url_data("前往每月工讀生總表", "salary/salary_action/part_time_monthly_summary_list_form/");
        $data['extend_url']=$extend_url;
        
        $this->load->view("message",$data);
        
        log_message("info","Salary_action.part_time_salary_confirm - end usr_num=".$user->usr_num);
    }
    
    public function part_time_monthly_summary_list_form($data = array()){
        
        $user = $this->session->userdata('user');
        
        $input=$this->input->post();
        
        log_message("info","Salary_action.part_time_monthly_summary_list_form - start usr_num=".$user->usr_num);
        
        $data['month_options'] = $this->get_month_options();
        $data['form_constants'] = $this->form_constants;
        $this->load->view("salary/part_time_monthly_summary_list",$data);
        
        log_message("info","Salary_action.part_time_monthly_summary_list_form - end usr_num=".$user->usr_num);
    }
    
    public function part_time_monthly_summary_list(){
        
        $user = $this->session->userdata('user');
        
        $input=$this->input->post();
        
        log_message("info","Salary_action.part_time_monthly_summary_list(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
        
        $query_result=$this->salary_service->get_part_time_checkin_data($input['year_month'], $user->usr_num);
        
        $data = array();
        $data['query_result'] = $this->salary_service->get_part_time_summary_data($input['year_month']);
        $data['year_month'] = $input['year_month'];
        $data['stores'] = $this->store_data_service->get_stores();
        
        $this->part_time_monthly_summary_list_form($data);
        log_message("info","Salary_action.part_time_monthly_summary_list - end usr_num=".$user->usr_num);
    }
    
    public function part_time_sendmail() {
        $user = $this->session->userdata('user');
        
        $input=$this->input->post();
        
        log_message("info","Salary_action.part_time_sendmail(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
        $is_send = ($input['is_send']=="true")? TRUE:FALSE;
        $query_result=$this->salary_service->send_part_time_mail($input['year_month'], $is_send);
        
        if($is_send) {
            $data['message'] = "每月工讀生薪資單已經寄出";
            $this->load->view("message",$data);
        }
        
        log_message("info","Salary_action.part_time_sendmail - end usr_num=".$user->usr_num);
    }
    
    public function employ_monthly_list_form($data = array()){
        
        $user = $this->session->userdata('user');
        
        $input=$this->input->post();
        
        log_message("info","Salary_action.employ_monthly_list_form - start usr_num=".$user->usr_num);
        
        $data['month_options'] = $this->get_month_options();
        $this->load->view("salary/test",$data);
        
        log_message("info","Salary_action.employ_monthly_list_form - end usr_num=".$user->usr_num);
    }
    
    public function employ_monthly_list(){
        
        $user = $this->session->userdata('user');
        
        $input=$this->input->post();
        
        log_message("info","Salary_action.employ_monthly_list(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
        
        $query_result=$this->salary_service->get_part_time_checkin_data($input['year_month'], $user->usr_num);
        
        $data = array();
        $data['query_result'] = $this->salary_service->get_part_time_checkin_data($input['year_month'], $user->usr_num);
        $data['year_month'] = $input['year_month'];
        
        $this->employ_monthly_list_form($data);
        
        log_message("info","Salary_action.employ_monthly_list - end usr_num=".$user->usr_num);
    }
    
    private function get_month_options() {
        $first_day = date('Y-m-01');
        return [date('Y-m', strtotime("$first_day -1 month")),
                date('Y-m', strtotime($first_day))];
    }
}
?>