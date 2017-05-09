<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    /**
     *
     */
    class Employ_json_action extends MY_AjaxController {
    	function __construct()
	    {
	        parent::__construct();
			$this->load->library('form_validation');
			$this->load->model("employ/employ_service");

	    }

		public function save(){

            $data = new stdClass();

			if(!$this->__user_login_validate()){
				$data->redirect=TRUE;
				echo json_encode($data);
				return;
			}

			$user = $this->session->userdata('user');

            $input=$this->input->post();

            $sto_num = $input["sto_num"];

			log_message("info","Employ_json_action.save() - start usr_num=".$user->usr_num.", sto_num=".$sto_num);

			$has_unfinished=$this->employ_service->check_unfinished_checkin($user->usr_num);

			if($has_unfinished){
				$data->isSuccess=FALSE;
			}else{
				$chk = $this->employ_service->check_in($user->usr_num, $sto_num);

				$data->chk=$chk;
				$data->isSuccess=TRUE;

			}

			echo json_encode($data);

			log_message("info","Employ_json_action.save() - end usr_num=".$user->usr_num.", sto_num=".$sto_num);

		}

		public function update(){

            $data = new stdClass();

			if(!$this->__user_login_validate()){
				$data->redirect=TRUE;
				echo json_encode($data);
				return;
			}

			$user = $this->session->userdata('user');

			$input=$this->input->post();

			log_message("info","Employ_json_action.update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);

			//step1. 驗證輸入資料格式
			$this->__update_employ_format_validate();
			if($this->form_validation->run() != TRUE){
				$data->isSuccess=FALSE;
				echo json_encode($data);
				return;
			}
			$chk_num=$input['chk_num'];
            $chk_note=$input['chk_note'];
			$data->isSuccess=$this->employ_service->check_out($chk_num, $user->usr_num, $chk_note);
			$data->chk_out_time=date('Y-m-d H:i:s');

			echo json_encode($data);

			log_message("info","Employ_json_action.update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);

		}

		public function update_confirm(){

			if(!$this->__user_login_validate()){
				$data->redirect=TRUE;
				echo json_encode($data);
				return;
			}

			$user = $this->session->userdata('user');

			$input=$this->input->post();

			log_message("info","Employ_json_action.update_confirm(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);

			//step1. 驗證輸入資料格式
			$this->__update_employ_format_validate();
			if($this->form_validation->run() != TRUE){
				$data->isSuccess=FALSE;
				echo json_encode($data);
				return;
			}

			$data->isSuccess=$this->employ_service->confirm($input, $user->usr_num);
			$data->confirm_date=date('Y-m-d H:i:s');

			echo json_encode($data);

			log_message("info","Employ_json_action.update_confirm(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);

		}

        public function getlist($sto_num) {

            $user = $this->session->userdata('user');

            $current_month_start = date('Y-m-01');
            $current_month_end = date('Y-m-t');

            $previous_month_start = date( "Y-m-01", strtotime( "-1 month" ) );
            $previous_month_end = date( "Y-m-t", strtotime( "-1 month" ) );

            $current_check = $this->employ_service->find_user_check_interval($current_month_start, $current_month_end, $user->usr_num, $sto_num);
            $previous_check = $this->employ_service->find_user_check_interval($previous_month_start, $previous_month_end, $user->usr_num, $sto_num);

            $data['current_check']=$current_check;
            $data['previous_check']=$previous_check;
            $data['usr_name']=$user->usr_name;
            $stores = $this->employ_service->get_stores();
            $data['store']=$stores[$sto_num];

            echo json_encode($data);


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