<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    /**
     * 
     */
    class Game_import_ajax_action extends MY_AjaxController {
    	function __construct()
	    {
	        parent::__construct();
			$this->load->library('form_validation');
			$this->load->model("game/game_import_service");
	    }
		
		public function get_game_info(){
			
			$input=$this->input->get();
			
			if(!$this->__user_login_validate()){
				$data->redirect=TRUE;
				echo json_encode($data);
				return;
			}
			
			$user = $this->session->userdata('user');
			
			log_message("info","Game_import_ajax_action.get_barcode_info(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
			$data->game=$this->game_import_service->find_game_by_barcode($input['bar_code']);
			
			// log_message("info","data=".print_r($data,TRUE));
			
			echo json_encode($data);
			
			log_message("info","Game_import_ajax_action.get_barcode_info(input=".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
			
		}
		
		public function game_import_save(){

			$user = $this->session->userdata('user');

			if(!$this->__user_login_validate()){
				$data->redirect=TRUE;
				echo json_encode($data);
				return;
			}

			$input=$this->input->post();

			log_message("info","Game_import_ajax_action.game_import_save(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
				
			//step1. 驗證輸入資料格式	
			// $this->__save_game_format_validate();
			// if($this->form_validation->run() != TRUE){
				// //$this->load->view("login_form");
				// $this->game_save_form();
				// return;
			// }
				
				
			$gim_num=$this->game_import_service->save_import_game($input["dataArray"], $user);
			
			$data['message']="新增入庫單成功, 入庫單流水號:".$gim_num;
			$data['gim_num']=$gim_num;
			$extend_url=array();
			//$extend_url[]=$this->__generate_url_data("繼續新增入庫資料", "game/game_import/action/game_save_form/");
			//$extend_url[]=$this->__generate_url_data("繼續維護入庫單資料", "game/game_action/game_update_form/",$gam_num);
			//$extend_url[]=$this->__generate_url_data("遊戲資料列表", "game/game_action/game_list_form/");
			$data['extend_url']=$extend_url;
			
			// $this->load->view("message",$data);
			echo json_encode($data);
			
			log_message("info","Game_import_ajax_action.game_import_save() - end usr_num=".$user->usr_num);
				
		}
	}
    
?>