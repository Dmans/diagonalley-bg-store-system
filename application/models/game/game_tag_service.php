<?php
    /**
     * 
     */
    class Game_tag_service extends CI_Model {
        
        function __construct()
	    {
	        parent::__construct();
			$this->load->model('service/tag_data_service');
			$this->load->model('dao/dia_game_tag_dao');
			$this->load->model("constants/form_constants");
	    }
		
		public function save_tag($input){
			$input['tag_type']=0;
			$this->tag_data_service->save_tag($input);
		}
		
		public function update_tag($input){
			$this->tag_data_service->update_tag($input);
		}
		
    }
    
?>