<?php
    /**
     * 
     */
    class game_data_service extends CI_Model {
        
        function __construct()
	    {
	        parent::__construct();
			$this->load->model('dao/dia_game_dao');
			$this->load->model('dao/dia_game_id_dao');
			$this->load->model('dao/dia_game_tag_dao');
			$this->load->model('service/tag_data_service');
			$this->load->model("constants/form_constants");
	    }
		
		public function save_game($input){
			return $this->dia_game_dao->insert($this->__assemble_save_game($input));
		}
		
		public function save_game_id($input){
			$this->dia_game_id_dao->insert($this->__assemble_save_game_id($input));
		}
		
		public function update_game($input){
			$this->dia_game_dao->update($this->__assemble_update_game($input));
		}
		
		public function update_game_id($input){
			$this->dia_game_id_dao->update($this->__assemble_update_game_id($input));
		}
		
		public function modify_game_storage($gam_num, $modify_value){
			$game = $this->dia_game_dao->query_by_gam_num($gam_num);
			$input['gam_num']=$gam_num;
			$input['gam_storage']=($game->gam_storage+$modify_value);
			$this->update_game($input);
		}
		
		public function find_game($gam_num){
			
			$game=$this->dia_game_dao->query_by_gam_num($gam_num);
			$game_tags=$this->dia_game_tag_dao->query_by_gam_num($gam_num);
			
			if(count($game_tags)==1){
				$temp=$game_tags;
				$game_tags=NULL;
				$game_tags[0]=$temp;
			}
			
			
			return $this->__assemble_game_query_result($game,$game_tags);
		}
		
		public function find_game_id($gid_num){
			return $this->__assemble_gid_query_result($this->dia_game_id_dao->query_by_gid_num($gid_num));
		}
		
		public function find_games_list($input){
			$result_set = $this->dia_game_dao->query_by_condition($input);
			return $this->__assemble_game_query_result_list($result_set);
		}
		
		public function find_gids_list($input){
			$result_set = $this->dia_game_id_dao->query_by_condition($input);
			
			return $this->__assemble_gid_query_result_list($result_set);
		}
		
		private function __assemble_save_game($input){
				
			$game->gam_cname=$input['gam_cname'];
			$game->gam_ename=$input['gam_ename'];
			$game->gam_storage=$input['gam_storage'];
			$game->gam_locate=$input['gam_locate'];
			$game->gam_cardsize=$input['gam_cardsize'];
			$game->gam_cardcount=$input['gam_cardcount'];
			$game->gam_type=0; //暫時塞數字 待分類出來
			$game->gam_sale=$input['gam_sale'];
			$game->gam_memo=$input['gam_memo'];
			$game->gam_cvalue=$input['gam_cvalue'];
			$game->gam_svalue=$input['gam_svalue'];
			$game->register_date = date('Y-m-d H:i:s');

			return $game;
		}
		
		private function __assemble_update_game($input){
			$game=NULL;
			$game->gam_num=$input['gam_num'];
			
			$value_conditions=array("gam_cname","gam_ename","gam_storage","gam_locate","gam_cardsize",
									"gam_cardcount","gam_sale","gam_memo","gam_cvalue","gam_svalue","gam_status");
			foreach ($value_conditions as $field_name) {
				if(isset($input[$field_name])){
					$game->$field_name = $input[$field_name];
				}
			}
			return $game;
		}
		
		private function __assemble_save_game_id($input){
				
			$game_id->gam_num=$input['gam_num'];
			$game_id->gid_enabled=1; //預設給上架
			$game_id->gid_status=0; //預設給店內(未使用)
			$game_id->gid_rentable=$input['gid_rentable'];
			$game_id->register_date = date('Y-m-d H:i:s');

			return $game_id;
		}
		
		private function __assemble_update_game_id($input){
			$game_id=NULL;
			$game_id->gid_num=$input['gid_num'];
			
			if(isset($input['gid_enabled'])){
				$game_id->gid_enabled=$input['gid_enabled'];	
			}
			
			if(isset($input['gid_status'])){
				$game_id->gid_status=$input['gid_status'];	
			}
			
			if(isset($input['gid_rentable'])){
				$game_id->gid_rentable=$input['gid_rentable'];	
			}
			
			return $game_id;

		}
		
		private function __assemble_game_query_result_list($query_result){
			$output = array();
			if(!empty($query_result)){
				if(count($query_result)==1){
					// $output[]=$this->__assemble_game_query_result($query_result);					$temp=$query_result;
					$query_result=NULL;
					$query_result[0]=$temp;
				}
				
				foreach ($query_result as $row) {
					
					$game_tags=$this->dia_game_tag_dao->query_by_gam_num($row->gam_num);
		
					if(count($game_tags)==1){
						$temp=$game_tags;
						$game_tags=NULL;
						$game_tags[0]=$temp;
					}
					
					$output[]=$this->__assemble_game_query_result($row,$game_tags);
				}
			}
			
			return $output;
		}
		
		private function __assemble_game_query_result($game,$game_tags){
				
			$result=NULL;
			$result->gam_num=$game->gam_num;
			$result->gam_cname=$game->gam_cname;
			$result->gam_ename=$game->gam_ename;
			$result->gam_storage=$game->gam_storage;
			$result->gam_locate=$game->gam_locate;
			$result->gam_cardsize=$game->gam_cardsize;
			$result->gam_cardcount=$game->gam_cardcount;
			$result->gam_type=$game->gam_type;
			$result->gam_sale=$game->gam_sale;
			$result->gam_memo=$game->gam_memo;
			$result->gam_cvalue=$game->gam_cvalue;
			$result->gam_svalue=$game->gam_svalue;
			$result->gam_status=$game->gam_status;
			$result->gam_sale_desc=$this->form_constants->transfer_gam_sale($game->gam_sale);
			
			$result->game_tags=$this->__decrate_gmae_tags_list($game_tags);
			
			
			return $result;
		}
		
		private function __assemble_gid_query_result_list($query_result){
			$output = array();
			if(!empty($query_result)){
				
				if(count($query_result)==1){
					$output[]=$this->__assemble_gid_query_result($query_result);
				}
				
				if(count($query_result)>1){
					foreach ($query_result as $row) {
						$output[]=$this->__assemble_gid_query_result($row);
					}
				}
			}
			
			return $output;
		}
		
		private function __assemble_gid_query_result($gid){
			$result->gam_num=$gid->gam_num;
			$result->gid_num=$gid->gid_num;
			$result->gid_status=$gid->gid_status;
			$result->gid_rentable=$gid->gid_rentable;
			$result->gid_enabled=$gid->gid_enabled;
			$result->gid_status_desc=$this->form_constants->transfer_gid_status($gid->gid_status);
			$result->gid_rentable_desc=$this->form_constants->transfer_gid_rentable($gid->gid_rentable);
			$result->gid_enabled_desc=$this->form_constants->transfer_gid_enabled($gid->gid_enabled);
			return $result;
		}
		
		private function __decrate_gmae_tags_list($game_tags){
			$result=array();
			if(count($game_tags)>0){
				foreach ($game_tags as $key => $game_tag) {
					$tag=$this->tag_data_service->find_tag($game_tag->tag_num);
					$result[$game_tag->tag_num]=$tag;
				}
			}
			
			return $result;
		}
    }
    
?>