<?php
    /**
     *
     */
    class Game_service extends CI_Model {

        function __construct()
	    {
	        parent::__construct();
			$this->load->model('service/game_data_service');
			$this->load->model('dao/dia_game_tag_dao');
			$this->load->model('dao/dia_barcode_dao');
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

		public function update_game_tag($gam_num,$game_tags){

			// step1. 移除舊的分類
			$this->dia_game_tag_dao->delete_by_gam_num($gam_num);

			// step2. 塞新的分類
			foreach ($game_tags as $key => $game_tag) {
				$dgt= new stdClass();
				$dgt->gam_num=$gam_num;
				$dgt->tag_num=$game_tag;

				$this->dia_game_tag_dao->insert($dgt);

			}
		}

		public function find_games_for_list($input=array()){

			$input['order_gam_ename']=TRUE;

			if(!isset($input['bar_code'])){
				$condition = $input;
			}else{
				$barcode = $this->dia_barcode_dao->query_by_bar_code($input['bar_code']);
				if($barcode == NULL){
					return array();
				}
				$condition['gam_num']=$barcode->bar_value;
			}
			$result_set = $this->game_data_service->find_games_list($condition);

			foreach ($result_set as $key => $game) {

				//排除已刪除遊戲
				if($game->gam_status==1){
					unset($result_set[$key]);
					continue;
				}

				//排除非查詢分類遊戲
				if(isset($input['tag_num']) &&
					$input['tag_num']!=-1 &&
					!array_key_exists($input['tag_num'], $game->game_tags)){

					unset($result_set[$key]);
					continue;
				}


			}

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

		public function modify_game_storage($gam_num, $modify_value, $gam_cvalue){
			$this->game_data_service->modify_game_storage($gam_num, $modify_value, $gam_cvalue);
		}

		public function update_game_barcode($gam_num, $barcode){
			$condition['bar_type']=0;
			$condition['bar_code']=$barcode;
			$old_barcode = $this->dia_barcode_dao->query_by_condition($condition);

			if($old_barcode == NULL){
				//新增
				$submit_barcode=NULL;
				$submit_barcode->bar_code=$barcode;
				$submit_barcode->bar_type=0;
				$submit_barcode->bar_value=$gam_num;
				$this->dia_barcode_dao->insert($submit_barcode);
			}else{
				//修改
				$modify_barcode = $old_barcode[0];
				$modify_barcode->bar_code=$barcode;
				$this->dia_barcode_dao->update($modify_barcode);
			}
		}

		public function check_bar_code_duplicate($bar_code, $gam_num){

			$result=NULL;

			//檢查barcode已存在且並非此遊戲流水號
			$condition['bar_type']=0;
			$condition['bar_code']=$bar_code;
			$barcode = $this->dia_barcode_dao->query_by_condition($condition);
			$result->isDuplicate = ($barcode[0] != NULL && $barcode[0]->bar_value != $gam_num);
			if($barcode != NULL){
				$result->barcode = $barcode[0];
			}

			return $result;
		}

		private function __assemble_view_gid($gid,$game){

			$result=(object) array_merge((array)$gid,(array)$game);

			return $result;
		}


    }

?>