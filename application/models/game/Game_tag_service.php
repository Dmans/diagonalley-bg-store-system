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
			return $this->tag_data_service->save_tag($input);
		}
		
		public function update_tag($input){
			$this->tag_data_service->update_tag($input);
		}
		
		public function find_tag_for_update($tag_num){
			return $this->tag_data_service->find_tag($tag_num);
		}
		
		public function find_tag_for_list($condition=NULL){
			$condition['tag_type']=0; //查遊戲類型tag
			$condition['tag_status']=1; //只撈出啟用標籤
			return $this->tag_data_service->find_tags_list($condition);
		}
		
		public function find_game_tag_for_list($condition){
			return $this->dia_game_tag_dao->query_by_condition($condition);
		}
		
		public function remove_tag($tag_num){
			$condition=NULL;
			$condition['tag_num']=$tag_num;
			$condition['tag_status']=0;
			$this->tag_data_service->update_tag($condition);
		}
		
    }
    
?>