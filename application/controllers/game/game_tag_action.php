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
			
			
		$this->game_tag_service->save_tag($input);
		
		$data['message']="新增標籤成功";
		
		$this->load->view("message",$data);
			// print_r($this->input->post());
			
		log_message("info","Game_tag_action.tag_save() - end usr_num=".$user->usr_num);
	}
	
	public function tag_update_form($gam_num){
        	
    	$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		log_message("info","Game_tag_action.tag_update_form(gam_num=$gam_num) - start usr_num=".$user->usr_num);
		
		// $data['usr_role'] =$user->usr_role ;
		
		$update_tag=$this->game_tag_service->find_tag_for_update($tag_num);
		//$data['update_game'] =$update_game;

    	
    	$this->load->view("game/tag_uform",$update_game);
		
		log_message("info","Game_tag_action.tag_update_form(gam_num=$gam_num) - end usr_num=".$user->usr_num);
    }
	
	public function tag_update(){
		
		$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		$input=$this->input->post();
		
		log_message("info","Game_tag_action.game_update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		$this->__update_game_format_validate();
		if($this->form_validation->run() != TRUE){
			//$this->load->view("login_form");
			$this->game_update_form($input['gam_num']);
			return;
		}
		
		$this->game_service->update_game($input);
		
		$data['message']="維護標籤成功";
		
		$this->load->view("message",$data);
		
		log_message("info","Game_tag_action.game_update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
		
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