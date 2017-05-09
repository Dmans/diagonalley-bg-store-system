<?php
    /**
     * 
     */
    class Pos_tag_service extends CI_Model {
        
        function __construct()
	    {
	        parent::__construct();
			$this->load->model('service/tag_data_service');
			$this->load->model('dao/dia_fast_pos_dao');
	    }
		
		public function save_tag($input){
			$input['tag_type']=1;
			$this->tag_data_service->save_tag($input);
		}
		
		public function update_tag($input){
			$this->tag_data_service->update_tag($input);
		}
		
		public function find_pos_tag_for_update($tag_num){
			return $this->tag_data_service->find_tag($tag_num);
		}
		
		public function find_pos_tag_for_list(){
			$condition=NULL;
			$condition['tag_type']=1; //查pos類型tag
			$condition['tag_status']=1; //只撈出啟用標籤
			return $this->tag_data_service->find_tags_list($condition);
		}
		
		public function remove_tag($tag_num){
			$condition=NULL;
			$condition['tag_num']=$tag_num;
			$condition['tag_status']=0;
			$this->tag_data_service->update_tag($condition);
			
			//連動移除快速介面該類別按鈕
			$fast_pos_list = $this->dia_fast_pos_dao->query_by_tag_num($tag_num);
			
			if($fast_pos_list!=NULL){
				foreach ($fast_pos_list as $fast_pos) {
					$fast_pos->pfs_visible=2; //停用
					$this->dia_fast_pos_dao->update($fast_pos);
				}
			}
			
			
			
			
			
			
		}
		
    }
    
?>