<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Tables_action extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model("manage/tables_service");
        $this->load->model("service/store_data_service");

    }

    public function save_form(){

        $user = $this->session->userdata('user');

        log_message("info","Tables_action.save_form - start usr_num=".$user->usr_num);
        $data = new stdClass();
        $data->stores = $this->store_data_service->get_stores();
        $this->load->view("manage/tables_iform", $data);

        log_message("info","Tables_action.save_form - end usr_num=".$user->usr_num);
    }

    public function save(){
        $user = $this->session->userdata('user');

        $input=$this->input->post();

        log_message("info","Tables_action.save(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);

        //step1. 驗證輸入資料格式
        $this->__save_table_format_validate();
        if($this->form_validation->run() != TRUE){
            $this->save_form($input);
            return;
        }

        $dtb_num = $this->tables_service->save_table($input);

        $data['message']="新增店舖遊戲桌資料成功";

        $extend_url=array();
        $extend_url[]=$this->__generate_url_data("新增其他店舖遊戲桌資料", "manage/tables_action/save_form/");
        $extend_url[]=$this->__generate_url_data("維護店舖遊戲桌資料", "manage/tables_action/update_form/",$dtb_num);
//        $extend_url[]=$this->__generate_url_data("店舖遊戲桌資料列表", "manage/tables_action/booking_page_list/");
        $extend_url[]=$this->__generate_url_data("回公告欄", "manage/manage_action/daily_message_list/");
        $data['extend_url']=$extend_url;

        $this->load->view("message",$data);

        log_message("info","Tables_action.save(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
    }

    public function update_form($dtb_num){

        $user = $this->session->userdata('user');

        log_message("info","Tables_action.update_form(dtb_num=$dtb_num) - start usr_num=".$user->usr_num);

        $dtb = $this->tables_service->find_table($dtb_num);

        $this->load->view("manage/booking_uform",$dtb);

        log_message("info","Tables_action.update_form(dtb_num=$dtb_num)  - end usr_num=".$user->usr_num);
    }

    public function update(){
        $user = $this->session->userdata('user');

        $input=$this->input->post();

        log_message("info","Tables_action.update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);

        //step1. 驗證輸入資料格式
        $this->__update_table_format_validate();
        if($this->form_validation->run() != TRUE){
            $this->update_form();
            return;
        }
        $this->tables_service->update_table($input);
        $data['message']="維護店舖遊戲桌資料成功";

        $extend_url=array();
        $extend_url[]=$this->__generate_url_data("繼續維護店舖遊戲桌資料", "manage/tables_action/update_form/",$input['dtb_num']);
        $extend_url[]=$this->__generate_url_data("店舖遊戲桌資料列表", "manage/tables_action/booking_page_list/");
        $extend_url[]=$this->__generate_url_data("回公告欄", "manage/manage_action/daily_message_list/");
        $data['extend_url']=$extend_url;

        $this->load->view("message",$data);

        log_message("info","Tables_action.update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
    }

    public function remove($dtb_num){

        $user = $this->session->userdata('user');

        log_message("info","Tables_action.remove(dtb_num=$dtb_num) - start usr_num=".$user->usr_num);

        $input=NULL;
        $input['dtb_num']=$dtb_num;
        $input['dtb_status']=2;

        $this->booking_service->update_booking($input);

        $data['message']="刪除定位資料成功";

        $extend_url=array();
        $extend_url[]=$this->__generate_url_data("新增其他定位資料", "manage/booking_action/save_form/");
        $extend_url[]=$this->__generate_url_data("定位資料列表", "manage/booking_action/booking_page_list/");
        $data['extend_url']=$extend_url;

        $this->load->view("message",$data);

        log_message("info","Tables_action.remove(dtb_num=$dtb_num) - end usr_num=".$user->usr_num);
    }

    public function booking_page_list(){

        $user = $this->session->userdata('user');

        log_message("info","Tables_action.booking_page_list - start usr_num=".$user->usr_num);

        $data['bookings']=$this->booking_service->find_enabled_bookings();

        $this->load->view("manage/booking_page_list",$data);

        log_message("info","Tables_action.booking_page_list - end usr_num=".$user->usr_num);
    }

    public function booking_message_list(){

        $user = $this->session->userdata('user');

        log_message("info","Tables_action.booking_page_list - start usr_num=".$user->usr_num);

        $data['bookings']=$this->booking_service->find_enabled_bookings(date('Y-m-d H:i:s',strtotime("now +1 week")));

        $this->load->view("manage/booking_message_list",$data);

        log_message("info","Tables_action.booking_page_list - end usr_num=".$user->usr_num);
    }


    private function __save_table_format_validate(){
        $this->form_validation->set_rules('dtb_name', '遊戲桌名稱', 'trim|required|max_length[48]');
    }

    private function __update_table_format_validate(){
        $this->form_validation->set_rules('dtb_name', '遊戲桌名稱', 'trim|required|max_length[48]');
    }

}

?>