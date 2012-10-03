<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Game_action extends MY_Controller {
	
	function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("game/game_service");
		$this->load->model("game/game_tag_service");
    }
	
    public function game_save_form(){
        	
    	$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		log_message("info","Game_action.game_save_form() - start usr_num=".$user->usr_num);
		
		$data['usr_role'] =$user->usr_role ;
    	
    	$this->load->view("game/game_iform",$data);
		
		log_message("info","Game_action.game_save_form() - end usr_num=".$user->usr_num);
    }
		
	public function game_save(){
		
		$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		$input=$this->input->post();
		
		log_message("info","Game_action.game_save(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		$this->__save_game_format_validate();
		if($this->form_validation->run() != TRUE){
			//$this->load->view("login_form");
			$this->game_save_form();
			return;
		}
			
			
		$gam_num=$this->game_service->save_game($input);
		
		$data['message']="新增遊戲成功, 遊戲流水號:".$gam_num;
		
		$extend_url=array();
		$extend_url[]=$this->__generate_url_data("繼續新增遊戲資料", "game/game_action/game_save_form/");
		$extend_url[]=$this->__generate_url_data("繼續維護遊戲資料", "game/game_action/game_update_form/",$gam_num);
		$extend_url[]=$this->__generate_url_data("遊戲資料列表", "game/game_action/game_list_form/");
		$data['extend_url']=$extend_url;
		
		$this->load->view("message",$data);
			
		log_message("info","Game_action.game_save() - end usr_num=".$user->usr_num);
			
	}
	
	public function game_update_form($gam_num){
        	
    	$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		log_message("info","Game_action.game_update_form(gam_num=$gam_num) - start usr_num=".$user->usr_num);
		
		$update_game=$this->game_service->find_game_for_update($gam_num);
    	
    	$this->load->view("game/game_uform",$update_game);
		
		log_message("info","Game_action.game_update_form(gam_num=$gam_num) - end usr_num=".$user->usr_num);
    }
	
	public function game_update(){
		
		$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		$input=$this->input->post();
		
		log_message("info","Game_action.game_update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		$this->__update_game_format_validate();
		if($this->form_validation->run() != TRUE){
			$this->game_update_form($input['gam_num']);
			return;
		}
		
		$this->game_service->update_game($input);
		
		$data['message']="維護遊戲成功";
		
		$extend_url=array();
		$extend_url[]=$this->__generate_url_data("繼續維護遊戲資料", "game/game_action/game_update_form/",$input['gam_num']);
		$extend_url[]=$this->__generate_url_data("遊戲資料列表", "game/game_action/game_list_form/");
		$data['extend_url']=$extend_url;
		
		$this->load->view("message",$data);
		
		log_message("info","Game_action.game_update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
		
	}
	
	public function game_storage_update(){
		
		$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		$input=$this->input->post();
		
		log_message("info","Game_action.game_storage_update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		$this->__update_game_storage_format_validate();
		if($this->form_validation->run() != TRUE){
			$this->game_update_form($input['gam_num']);
			return;
		}
		
		$this->game_service->modify_game_storage($input['gam_num'],$input['modify_gam_storage']);
		
		$data['message']="維護遊戲庫存成功";
		
		$extend_url=array();
		$extend_url[]=$this->__generate_url_data("繼續維護遊戲資料", "game/game_action/game_update_form/",$input['gam_num']);
		$extend_url[]=$this->__generate_url_data("遊戲資料列表", "game/game_action/game_list_form/");
		$data['extend_url']=$extend_url;
		
		$this->load->view("message",$data);
		
		log_message("info","Game_action.game_storage_update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
		
	}
	
	public function game_remove($gam_num){
		
		$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		log_message("info","Game_action.game_remove(gam_num=$gam_num) - start usr_num=".$user->usr_num);
		
		$input=array();
		$input['gam_num']=$gam_num;
		$input['gam_status']=1; //停用狀態	
		$this->game_service->update_game($input);
		
		$data['message']="刪除遊戲成功";
		
		$extend_url=array();
		$extend_url[]=$this->__generate_url_data("遊戲資料列表", "game/game_action/game_list_form/");
		$data['extend_url']=$extend_url;
		
		$this->load->view("message",$data);
		
		log_message("info","Game_action.game_remove(gam_num=$gam_num) - end usr_num=".$user->usr_num);
		
	}
    
	public function game_list_form($query_result=NULL){

		$user = $this->session->userdata('user');

		log_message("info","Game_action.game_list_form - start usr_num=".$user->usr_num);
		$data=array();
		
		if($query_result!=NULL){
			$data['query_result']=$query_result;
		}
		
		// $data['games']=$this->game_service->find_games_for_list();
		$data['usr_role']=$user->usr_role ;
		$data['tags']=$this->game_tag_service->find_tag_for_list();
		
    	$this->load->view("game/game_qform",$data);
		
		log_message("info","Game_action.game_list_form - end usr_num=".$user->usr_num);
	}
	
	public function game_list(){

		$user = $this->session->userdata('user');
		
		$input=$this->input->post();
		
		log_message("info","Game_action.game_list(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
		
		$data=array();
		
		$query_result=$this->game_service->find_games_for_list($input);

		$this->game_list_form($query_result);

		// $data['usr_role']=$user->usr_role ;
		
		
    	// $this->load->view("game/game_page_list",$data);
		
		log_message("info","Game_action.game_list(input=".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
	}
	
	public function game_page_detail($gam_num){
		$user = $this->session->userdata('user');

		log_message("info","Game_action.game_page_detail(gam_num=$gam_num) - start usr_num=".$user->usr_num);
		
		
		$data['game']=$this->game_service->find_game_for_update($gam_num);
		// $data['usr_role']=$user->usr_role ;
		
    	$this->load->view("game/game_page_detail",$data);
		
		log_message("info","Game_action.game_page_detail(gam_num=$gam_num) - end usr_num=".$user->usr_num);
	}
	
	public function gid_save_form($gam_num){
        	
    	$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		log_message("info","Game_action.gid_save_form() - start usr_num=".$user->usr_num);
		// log_message("info","user_role:".$user->usr_role);
		
		$update_game=$this->game_service->find_game_for_update($gam_num);
		
		// $data['usr_role'] =$user->usr_role ;
		
		$update_game->usr_role=$user->usr_role ;
    	
    	$this->load->view("game/gid_iform",$update_game);
		
		log_message("info","Game_action.gid_save_form() - end usr_num=".$user->usr_num);
    }
		
	public function gid_save(){
		
		$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		$input=$this->input->post();
		
		log_message("info","Game_action.gid_save(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		$this->__save_gid_format_validate();
		if($this->form_validation->run() != TRUE){
			//$this->load->view("login_form");
			$this->gid_save_form($input['gam_num']);
			return;
		}
			
			
		$gid_num=$this->game_service->save_game_id($input);
		
		$data['message']="新增上架遊戲成功";
		
		$extend_url=array();
		$extend_url[]=$this->__generate_url_data("新增上架遊戲資料", "game/game_action/gid_save_form/");
		$extend_url[]=$this->__generate_url_data("維護上架遊戲資料", "game/game_action/gid_update_form/",$gid_num);
		$extend_url[]=$this->__generate_url_data("上架遊戲列表", "game/game_action/gid_list_form/");
		$data['extend_url']=$extend_url;
		
		$this->load->view("message",$data);
			
		log_message("info","Game_action.gid_save() - end usr_num=".$user->usr_num);
			
	}
	
	public function gid_update_form($gid_num){
        	
    	$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		log_message("info","Game_action.gid_update_form(gid_num=$gid_num) - start usr_num=".$user->usr_num);
		
		
		$update_gid=$this->game_service->find_game_id_for_update($gid_num);
    	
    	$this->load->view("game/gid_uform",$update_gid);
		
		log_message("info","Game_action.gid_update_form(gid_num=$gid_num) - end usr_num=".$user->usr_num);
    }
	
	public function gid_update(){
		
		$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		$input=$this->input->post();
		
		log_message("info","Game_action.gid_update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		$this->__update_gid_format_validate();
		if($this->form_validation->run() != TRUE){
			$this->gid_update_form($input['gid_num']);
			return;
		}
		
		$this->game_service->update_game_id($input);
		
		$data['message']="維護上架遊戲成功";
		
		$extend_url=array();
		$extend_url[]=$this->__generate_url_data("維護上架遊戲資料", "game/game_action/gid_update_form/",$input['gid_num']);
		$extend_url[]=$this->__generate_url_data("上架遊戲列表", "game/game_action/gid_list_form/");
		$data['extend_url']=$extend_url;
		
		$this->load->view("message",$data);
		
		log_message("info","Game_action.gid_update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
		
	}
    
	public function gid_list_form(){

		$user = $this->session->userdata('user');

		log_message("info","Game_action.gid_list_form - start usr_num=".$user->usr_num);
		
		$gids = $this->game_service->find_gids_for_list();
		
		$data['gids']=$gids;
		$data['usr_role']=$user->usr_role ;
		
		
    	$this->load->view("game/gid_page_list",$data);
		
		log_message("info","Game_action.gid_list_form - end usr_num=".$user->usr_num);
	}
	
	public function gid_page_detail($gid_num){
		$user = $this->session->userdata('user');

		log_message("info","Game_action.gid_page_detail(gid_num=$gid_num) - start usr_num=".$user->usr_num);
		
		
		$data['gid']=$this->game_service->find_game_id_for_update($gid_num);
		
    	$this->load->view("game/gid_page_detail",$data);
		
		log_message("info","Game_action.gid_page_detail(gid_num=$gid_num) - end usr_num=".$user->usr_num);
	}
	
	public function game_tag_update_form($gam_num){
        	
    	$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		log_message("info","Game_action.game_tag_update_form(gam_num=$gam_num) - start usr_num=".$user->usr_num);
		
		$data=NULL;
		$condition=NULL;
		$condition['order_tag_name']=TRUE;
		$data['tags']=$this->game_tag_service->find_tag_for_list($condition);
		$data['game']=$this->game_service->find_game_for_update($gam_num);
print_r($data['game']);
    	$this->load->view("game/game_tag_uform",$data);
		
		log_message("info","Game_action.game_tag_update_form(gam_num=$gam_num) - end usr_num=".$user->usr_num);
    }
	
	public function game_tag_update(){
		
		$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		$input=$this->input->post();
		
		log_message("info","Game_action.game_tag_update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
		// print_r($input);
		//step1. 驗證輸入資料格式	
		// $this->__update_tag_format_validate();
		// if($this->form_validation->run() != TRUE){
			// $this->tag_update_form($input['tag_num']);
			// return;
		// }
		// $this->game_tag_service->update_tag($input);
		$this->game_service->update_game_tag($input['gam_num'],$input['game_tags']);
		
		$data['message']="維護遊戲分類成功";
		
		$extend_url=array();
		$extend_url[]=$this->__generate_url_data("繼續維護遊戲分類", "game/game_action/game_tag_update_form/",$input['gam_num']);
		$extend_url[]=$this->__generate_url_data("遊戲資料列表", "game/game_action/game_list_form/");
		$data['extend_url']=$extend_url;
		
		$this->load->view("message",$data);
		
		log_message("info","Game_action.game_tag_update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
		
	}
	
	private function __save_game_format_validate(){
		$this->form_validation->set_rules('gam_cname', '遊戲中文名稱', 'trim|required|max_length[32]|xss_clean');
		$this->form_validation->set_rules('gam_ename', '遊戲英文名稱', 'trim|required|max_length[64]|xss_clean');
		$this->form_validation->set_rules('gam_storage', '遊戲庫存', 'trim|required|greater_than[-1]|xss_clean');
		$this->form_validation->set_rules('gam_locate', '遊戲庫位', 'trim|max_length[64]|xss_clean');
		$this->form_validation->set_rules('gam_cardsize', '遊戲牌套尺寸', 'trim|max_length[64]|xss_clean');
		$this->form_validation->set_rules('gam_cardcount', '遊戲牌數量', 'trim|integer|max_length[12]|xss_clean');
		$this->form_validation->set_rules('gam_svalue', '遊戲售價', 'trim|required|greater_than[-1]|xss_clean');
		$this->form_validation->set_rules('gam_cvalue', '遊戲成本價', 'trim|required|greater_than[-1]|xss_clean');
		$this->form_validation->set_rules('gam_sale', '遊戲是否可販售', 'trim|required|greater_than[-1]|xss_clean');
		$this->form_validation->set_rules('gam_memo', '遊戲備註', 'trim|max_length[256]|xss_clean');
	}
	
	private function __update_game_format_validate(){
		$this->form_validation->set_rules('gam_cname', '遊戲中文名稱', 'trim|required|max_length[32]|xss_clean');
		$this->form_validation->set_rules('gam_ename', '遊戲英文名稱', 'trim|required|max_length[64]|xss_clean');
		$this->form_validation->set_rules('gam_locate', '遊戲庫位', 'trim|max_length[64]|xss_clean');
		$this->form_validation->set_rules('gam_cardsize', '遊戲牌套尺寸', 'trim|max_length[64]|xss_clean');
		$this->form_validation->set_rules('gam_cardcount', '遊戲牌數量', 'trim|integer|max_length[12]|xss_clean');
		$this->form_validation->set_rules('gam_svalue', '遊戲售價', 'trim|required|greater_than[-1]|xss_clean');
		$this->form_validation->set_rules('gam_cvalue', '遊戲成本價', 'trim|required|greater_than[-1]|xss_clean');
		$this->form_validation->set_rules('gam_sale', '遊戲是否可販售', 'trim|required|greater_than[-1]|xss_clean');
		$this->form_validation->set_rules('gam_memo', '遊戲備註', 'trim|max_length[256]|xss_clean');
	}

	private function __update_game_storage_format_validate(){
		$this->form_validation->set_rules('modify_gam_storage', '異動庫存量', 'trim|required|integer|xss_clean');
	} 
	
	private function __save_gid_format_validate(){
		$this->form_validation->set_rules('gid_rentable', '遊戲是否可出租', 'trim|required|integer|xss_clean');
	}
	
	private function __update_gid_format_validate(){
		$this->form_validation->set_rules('gid_enabled', '遊戲上架狀態', 'trim|required|integer|xss_clean');
		$this->form_validation->set_rules('gid_rentable', '遊戲是否可出租', 'trim|required|integer|xss_clean');
	}
    
}



?>