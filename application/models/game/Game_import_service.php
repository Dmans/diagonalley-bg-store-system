<?php
    /**
     * 
     */
    class Game_import_service extends CI_Model {
        
        function __construct()
	    {
	        parent::__construct();
			$this->load->model('service/game_data_service');
			$this->load->model('service/user_data_service');
			$this->load->model('dao/dia_game_import_dao');
			$this->load->model('dao/dia_game_import_item_dao');
			$this->load->model('dao/dia_barcode_dao');
			$this->load->model("constants/form_constants");
	    }
		
		public function find_game_by_barcode($bar_code){
				
			// step1.找出對應barcode資料	
			$barcode = $this->dia_barcode_dao->query_by_bar_code($bar_code);

			if($barcode == NULL || $barcode->bar_type != 0){
				return NULL;
			}			
			
			// step2.找出對應遊戲資料
			$game = $this->game_data_service->find_game($barcode->bar_value);
			
			return $game;
		}
		
		
		
		public function save_import_game($input, $user){
				
			//step1. 組入庫單
			$import_form = NULL;
			$import_form->gim_date = date('Y-m-d H:i:s');
			$import_form->usr_num = $user->usr_num;
			$import_form->gim_status = 1; //啟用
			
			$gim_num = $this->dia_game_import_dao->insert($import_form);
			
			//step2. 組入庫子件
			foreach ($input as $key => $value) {
					
				$game = $this->game_data_service->find_game($value["gam_num"]);
					
				
				$gii = NULL;	
				$gii->gim_num=$gim_num;
				$gii->gam_num=$value["gam_num"];
				$gii->gii_ivalue=$value["gii_ivalue"];
				$gii->gii_imp_cvalue=$value["gii_import_value"];
				$gii->gii_old_cvalue=$game->gam_cvalue;
				$gii->gii_new_cvalue=
					($value["gii_import_value"]*$value["gii_ivalue"] + $game->gam_cvalue*$game->gam_storage) / 
					($value["gii_ivalue"]+$game->gam_storage);
				$gii->gii_source=$value["gii_source"];
				
				//新增入庫子件
				$this->dia_game_import_item_dao->insert($gii);
				
				//異動遊戲資料庫存
				$this->game_data_service->modify_game_storage($value["gam_num"], $value["gii_ivalue"], $value["gii_import_value"]);
			}
		
			return $gim_num;
		}

		public function find_game_import_list($start_gim_date, $end_gim_date){
			
			$condition=array();
			$condition['start_gim_date']=$start_gim_date;
			$condition['end_gim_date']=$end_gim_date;
			
			$gim_list = $this->dia_game_import_dao->query_by_condition($condition);
			
			return $gim_list;
		}
		
		public function find_game_import_detail($gim_num){
			
			//step1. 找出主單	
			$gim = $this->dia_game_import_dao->query_by_pk($gim_num);
			
			
			//step2. 找出使用者資料
			$user = $this->user_data_service->find_user($gim->usr_num);
			$gim->usr_name=$user->usr_name;
			
			
			//step3. 找出子件
			$gii_list = $this->dia_game_import_item_dao->query_by_gim_num($gim_num);

			foreach ($gii_list as $key => $gii) {
				$game = $this->game_data_service->find_game($gii->gam_num);
				$gii->game = $game;
				$gii_list[$key]=$gii;
			}
			
			$gim->gii_list=$gii_list;
			
			
			return $gim;
			
		}
		
    }
    
?>