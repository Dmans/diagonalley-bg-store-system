<?php
    /**
     * 
     */
    class Game_service extends CI_Model {
        
        function __construct()
	    {
	        parent::__construct();
			$this->load->model('service/game_data_service');
			$this->load->model("constants/form_constants");
	    }
		
		
		public function save_game($input){
			return $this->game_data_service->save_game($input);
		}
		
		public function save_game_id($input){
			return $this->game_data_service->save_game_id($input);
		}
		
		public function update_game($input){
			$this->game_data_service->update_game($input);
		}
		
		public function update_game_id($input){
			$this->game_data_service->update_game_id($input);
		}
		
		public function find_games_for_list(){
			// $result_set = $this->dia_game_dao->query_all();
			$input=array();
			$result_set = $this->game_data_service->find_games_list($input);
			
			foreach ($result_set as $key => $game) {
				if($game->gam_status==1){
					unset($result_set[$key]);
				}
			}
			
			//將上架遊戲用英文名稱排列
			$result_set = object_sorter($result_set, "gam_ename");
			
			return $result_set;
		}
		
		public function find_gids_for_list(){
			
			//step1.找出所有上架遊戲
			$input=array();
			$gids=$this->game_data_service->find_gids_list($input);
			
			$result_set=array();
			foreach ($gids as $gid) {
				$game = $this->game_data_service->find_game($gid->gam_num);
				if($game->gam_status==0){
					$result_set[]=$this->__assemble_view_gid($gid, $game);
				}
			}
			
			//將上架遊戲用英文名稱排列
			$result_set = object_sorter($result_set, "gam_ename");

			return $result_set;
		}
		
		public function find_game_for_update($gam_num){
			return $this->game_data_service->find_game($gam_num);
		}
		
		public function find_game_id_for_update($gid_num){
			$gid = $this->game_data_service->find_game_id($gid_num);
			$game = $this->game_data_service->find_game($gid->gam_num);
			return $this->__assemble_view_gid($gid, $game);
		}
		
		public function modify_game_storage($gam_num, $modify_value){ 
			$this->game_data_service->modify_game_storage($gam_num, $modify_value);
		}
		
		private function __assemble_view_gid($gid,$game){
			
			$result=(object) array_merge((array)$gid,(array)$game);	
				
			return $result;
		}
		
		
    }
    
?>