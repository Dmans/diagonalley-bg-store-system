<?


class Game_tag_action extends MY_Controller {
		
	function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("game/game_tag_service");
    }
	
	public function tag_save_form(){
        	
    	$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		log_message("info","Game_tag_action.tag_save_form() - start usr_num=".$user->usr_num);
		
		$data['usr_role'] =$user->usr_role ;
    	
    	$this->load->view("game/tag_iform",$data);
		
		log_message("info","Game_tag_action.tag_save_form() - end usr_num=".$user->usr_num);
    }
		
	
	public function tag_save(){
		$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		$input=$this->input->post();
		
		log_message("info","Game_tag_action.tag_save(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		$this->__save_tag_format_validate();
		if($this->form_validation->run() != TRUE){
			$this->tag_save_form();
			return;
		}
			
			
		$tag_num=$this->game_tag_service->save_tag($input);
		
		$data['message']="新增遊戲類型成功";
		$extend_url=array();
		$extend_url[]=$this->__generate_url_data("繼續新增遊戲類型", "game/game_tag_action/tag_save_form/");
		$extend_url[]=$this->__generate_url_data("繼續維護遊戲類型", "game/game_tag_action/tag_update_form/",$tag_num);
		$extend_url[]=$this->__generate_url_data("遊戲類型列表", "game/game_tag_action/game_tag_list/");
		$data['extend_url']=$extend_url;
		
		$this->load->view("message",$data);
			
		log_message("info","Game_tag_action.tag_save() - end usr_num=".$user->usr_num);
	}
	
	public function tag_update_form($tag_num){
        	
    	$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		log_message("info","Game_tag_action.tag_update_form(tag_num=$tag_num) - start usr_num=".$user->usr_num);
		
		$update_tag=$this->game_tag_service->find_tag_for_update($tag_num);
    	
    	$this->load->view("game/tag_uform",$update_tag);
		
		log_message("info","Game_tag_action.tag_update_form(tag_num=$tag_num) - end usr_num=".$user->usr_num);
    }
	
	public function tag_update(){
		
		$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		$input=$this->input->post();
		
		log_message("info","Game_tag_action.tag_update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		$this->__update_tag_format_validate();
		if($this->form_validation->run() != TRUE){
			$this->tag_update_form($input['tag_num']);
			return;
		}
		
		$this->game_tag_service->update_tag($input);
		
		$data['message']="維護遊戲類型成功";
		
		$extend_url=array();
		$extend_url[]=$this->__generate_url_data("繼續維護遊戲類型", "game/game_tag_action/tag_update_form/",$input['tag_num']);
		$extend_url[]=$this->__generate_url_data("遊戲類型列表", "game/game_tag_action/game_tag_list/");
		$data['extend_url']=$extend_url;
		
		$this->load->view("message",$data);
		
		log_message("info","Game_tag_action.tag_update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
		
	}

	public function game_tag_list(){
		
		$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		log_message("info","Game_tag_action.game_tag_list() - start usr_num=".$user->usr_num);
			
		$data['tags']=$this->game_tag_service->find_tag_for_list();
		
		$this->load->view("game/tag_page_list",$data);
		
		log_message("info","Game_tag_action.game_tag_list() - end usr_num=".$user->usr_num);
		
	}
	
	public function remove($tag_num){
		$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		log_message("info","Game_tag_action.remove(tag_num=$tag_num) - start usr_num=".$user->usr_num);
			
		$this->game_tag_service->remove_tag($tag_num);
		
		$data['message']="刪除遊戲類型成功";
		$extend_url=array();
		$extend_url[]=$this->__generate_url_data("遊戲類型列表", "game/game_tag_action/game_tag_list/");
		$data['extend_url']=$extend_url;
		
		$this->load->view("message",$data);
		
		log_message("info","Game_tag_action.remove(tag_num=$tag_num) - end usr_num=".$user->usr_num);
	}
	
	private function __save_tag_format_validate(){
		$this->form_validation->set_rules('tag_name', '標籤名稱', 'trim|required|max_length[32]|xss_clean');
		$this->form_validation->set_rules('tag_desc', '標籤說明', 'trim|required|max_length[128]|xss_clean');
	}
	
	private function __update_tag_format_validate(){
		$this->form_validation->set_rules('tag_name', '標籤名稱', 'trim|required|max_length[32]|xss_clean');
		$this->form_validation->set_rules('tag_desc', '標籤說明', 'trim|required|max_length[128]|xss_clean');
	}
	
	
	
}

?>