<?


class Pos_tag_action extends MY_Controller {
		
	function __construct()
    {
        parent::__construct();
		$this->load->model("manage/pos_tag_service");
		$this->load->library('form_validation');
    }
	
	public function save_form(){
        	
    	$user = $this->session->userdata('user');
		
		log_message("info","Pos_tag_action.save_form() - start usr_num=".$user->usr_num);

		$data=NULL;    	
    	$this->load->view("manage/pos_tag_iform",$data);
		
		log_message("info","Pos_tag_action.save_form() - end usr_num=".$user->usr_num);
    }
		
	
	public function save(){
		$user = $this->session->userdata('user');
		
		$input=$this->input->post();
		
		log_message("info","Pos_tag_action.save(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		$this->__save_tag_format_validate();
		if($this->form_validation->run() != TRUE){
			$this->tag_save_form();
			return;
		}
			
		$this->pos_tag_service->save_tag($input);
		
		$data['message']="新增銷售類型成功";
		
		$this->load->view("message",$data);
			// print_r($this->input->post());
			
		log_message("info","Pos_tag_action.save() - end usr_num=".$user->usr_num);
	}
	
	public function update_form($tag_num){
        	
    	$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		log_message("info","Pos_tag_action.update_form(tag_num=$tag_num) - start usr_num=".$user->usr_num);
		
		$update_tag=$this->pos_tag_service->find_pos_tag_for_update($tag_num);
    	
		log_message("info","update_tag=".$update_tag);
		
    	$this->load->view("manage/pos_tag_uform",$update_tag);
		
		log_message("info","Pos_tag_action.update_form(tag_num=$tag_num) - end usr_num=".$user->usr_num);
    }
	
	public function update(){
		
		$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		$input=$this->input->post();
		
		log_message("info","Pos_tag_action.update(input=".print_r($input,TRUE).") - start usr_num=".$user->usr_num);
			
		//step1. 驗證輸入資料格式	
		$this->__update_tag_format_validate();
		if($this->form_validation->run() != TRUE){
			//$this->load->view("login_form");
			$this->update_form($input['tag_num']);
			return;
		}
		
		$this->pos_tag_service->update_tag($input);
		
		$data['message']="維護銷售類型成功";
		
		$this->load->view("message",$data);
		
		log_message("info","Pos_tag_action.update(".print_r($input,TRUE).") - end usr_num=".$user->usr_num);
		
	}
	
	public function pos_list(){
		
		$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		log_message("info","Pos_tag_action.pos_list() - start usr_num=".$user->usr_num);
			
		$data['tags']=$this->pos_tag_service->find_pos_tag_for_list();
		
		$this->load->view("manage/pos_tag_page_list",$data);
		
		log_message("info","Pos_tag_action.pos_list() - end usr_num=".$user->usr_num);
		
	}
	
	public function remove($tag_num){
		$user = $this->session->userdata('user');
		
		if($this->__user_role_check($user->usr_role)){return;}
		
		log_message("info","Pos_tag_action.remove(tag_num=$tag_num) - start usr_num=".$user->usr_num);
			
		$this->pos_tag_service->remove_tag($tag_num);
		
		$data['message']="刪除銷售類型成功";
		
		$this->load->view("message",$data);
		
		log_message("info","Pos_tag_action.remove(tag_num=$tag_num) - end usr_num=".$user->usr_num);
	}
	
	private function __save_tag_format_validate(){
		$this->form_validation->set_rules('tag_name', '銷售類型名稱', 'trim|required|max_length[32]');
		$this->form_validation->set_rules('tag_desc', '銷售類型說明', 'trim|required|max_length[128]');
	}
	
	private function __update_tag_format_validate(){
		$this->form_validation->set_rules('tag_name', '銷售類型名稱', 'trim|required|max_length[32]');
		$this->form_validation->set_rules('tag_desc', '銷售類型說明', 'trim|required|max_length[128]');
	}
	
	
	
}

?>