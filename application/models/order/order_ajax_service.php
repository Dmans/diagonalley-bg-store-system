<?php
    /**
     * 
     */
    class order_ajax_service extends CI_Model {
        
        function __construct()
	    {
	        parent::__construct();
			$this->load->model('service/user_data_service');
			$this->load->model('service/game_data_service');
			$this->load->model("constants/form_constants");
	    }
		
		public function find_users_for_autocomplete($input){
			$input['usr_role']="3"; //只查詢會員
				
			$users = $this->user_data_service->find_users_list($input);
			
			$query_result=array();
			if(count($users)!=0){
				
				foreach($users as $user){
					$query_result[]=$this->__assemble_users_for_autocomplete($user);
				}
			}
			
			return $query_result;
		}
		
		public function find_games_for_autocomplete($input){
			
			$temp_query_result=array();
			
			//step1. 抓英文名字
			$condition=NULL;
			$condition['gam_ename']=$input['gam_name'];
			$condition['gam_sale']="1";
				
			$eng_games = $this->game_data_service->find_games_list($condition);
			
			if(count($eng_games)!=0){
				
				foreach($eng_games as $eng_game){
					if($eng_game->gam_status==0 && !array_key_exists($eng_game->gam_num, $temp_query_result)){
						$temp_query_result[$eng_game->gam_num]=$this->__assemble_games_for_autocomplete($eng_game);
					}
				}
			}
			
			
			//step2. 抓中文名字
			$condition=NULL;
			$condition['gam_cname']=$input['gam_name'];
			$condition['gam_sale']="1";
				
			$ch_games = $this->game_data_service->find_games_list($condition);
			
			if(count($ch_games)!=0){
				
				foreach($ch_games as $ch_game){
					if($ch_game->gam_status==0 && !array_key_exists($ch_game->gam_num, $temp_query_result)){
						$temp_query_result[$ch_game->gam_num]=$this->__assemble_games_for_autocomplete($ch_game);
					}
				}
			}
			
			
			$query_result = array();
			if(count($temp_query_result)!=0){
				
				foreach($temp_query_result as $result){
					$query_result[]=$result;
				}
			}
			
			return $query_result;
		}
		
		private function __assemble_users_for_autocomplete($user){
			$result=NULL;
			$result->label=$user->usr_id."(".$user->usr_num." ".$user->usr_name.")";
			$result->value=$user->usr_id."(".$user->usr_num." ".$user->usr_name.")";
			$result->usr_num=$user->usr_num;
			
			return $result;
		}
		
		private function __assemble_games_for_autocomplete($gam){
			$result=NULL;
			$result->label=$gam->gam_cname."(".$gam->gam_ename.")";
			$result->value=$gam->gam_cname."(".$gam->gam_ename.")";
			$result->gam_num=$gam->gam_num;
			$result->gam_storage=$gam->gam_storage;
			$result->gam_locate=$gam->gam_locate;
			$result->gam_cardsize=$gam->gam_cardsize;
			$result->gam_svalue=$gam->gam_svalue;
			
			return $result;
		}
		
    }
    
?>