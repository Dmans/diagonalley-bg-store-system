<?php
    /**
     * 
     */
    class Manage_service extends CI_Model {
        
        function __construct()
	    {
	        parent::__construct();
			// $this->load->helper('array');
			$this->load->model('dao/dia_game_id_record_dao');
			$this->load->model('dao/dia_daily_record_dao');
			$this->load->model('service/game_data_service');
			$this->load->model('service/user_data_service');
			$this->load->model("constants/form_constants");
	    }
		
		public function update_gid_status($input,$usr_num){
			//step1.新增上架遊戲使用紀錄
			$new_gid_status=$input['gid_status'];
			$grd_num=NULL;
			switch ($new_gid_status) {
				case 0:
					$this->dia_game_id_record_dao->update(
						$this->__assemble_update_game_id_record($input['grd_num'],$usr_num,$input['grd_memo']));
					break;
				case 1:
					
					//只加入使用紀錄不改變遊戲狀態
					$grd_num = $this->dia_game_id_record_dao->insert(
						$this->__assemble_save_game_id_record($input,$usr_num));
					$input['gid_status']=0;
					break;
				case 2:
					$grd_num = $this->dia_game_id_record_dao->insert(
						$this->__assemble_save_game_id_record($input,$usr_num));
					break;
			}
			
			
			//step2.更新上架遊戲狀態
			$this->game_data_service->update_game_id($input);
			
			return $grd_num;
			
		}
		
		public function find_gids_for_list(){
			
			//step1.找出所有(正在上架)的上架遊戲
			$condition['gid_enabled']=1;
			$gids = $this->game_data_service->find_gids_list($condition);

			if(count($gids)==1){
				$gid=$gids;
				$gids=NULL;
				$gids[]=$gid;
			}
			//step2.組view資料
			$result_set=array();
			foreach ($gids as $gid) {
				
				//step2-1.抓遊戲資料
				$game = $this->game_data_service->find_game($gid->gam_num);
				
				if($game->gam_status==1){
					continue;
				}
				
				//step2-2.依據上架遊戲狀態抓取遊戲使用紀錄
				$grd=NULL;
				if($gid->gid_status!=0){
					
					$condition=NULL;
					$condition['gid_num']=$gid->gid_num;
					$condition['null_grd_end_time']=TRUE;
					$grd= $this->dia_game_id_record_dao->query_by_condition($condition);
					
				}
				$result_set[]=$this->__assemble_view_gid($gid, $game, $grd);
				
			}
			
			//將上架遊戲用英文名稱排列
			$result_set = object_sorter($result_set, "gam_ename");
			
			return $result_set;
		}
		
		public function find_dailys($usr_num=NULL){
			return $this->find_daily_record_for_list(FALSE,$usr_num);
		}
		
		public function find_ontop_dailys(){
			return $this->find_daily_record_for_list(TRUE,NULL);
		}
		
		public function find_daily_record_for_list($is_ontop=FALSE,$usr_num=NULL){
			
			/*
			 * step1. 判斷是否傳入usr_num
			 * 有-撈出該使用者所有公告紀錄
			 * 無-撈出查詢日3個月內公告紀錄
			 */
			$condition=NULL;
			$condition['order_register_date']="DESC";
			
			if($usr_num==NULL){
				$today= date('Y-m-d H:i:s');
				$three_month_ago = date('Y-m-d H:i:s',strtotime("now -1 month"));
				$condition['start_modify_date']=$three_month_ago;
				$condition['end_modify_date']=$today;
				$condition['ddr_status']=1; //只撈顯示的	
				$condition['ddr_type']=($is_ontop)?1:0; //撈取置頂或一般公告
			}else{
				$condition['usr_num']=$usr_num;
				$condition['not_ddr_status']=2; //不撈停用的
			}
			
			$dailys = $this->dia_daily_record_dao->query_by_condition($condition);
			
			if(count($dailys)==1){
				$daily=$dailys;
				$dailys=NULL;
				$dailys[]=$daily;
			}
			
			// step2. 組dailys所需資訊
			$users=array();
			foreach ($dailys as $daily) {
				
				if(count($users)<=0 || !array_key_exists($daily->usr_num, $users)){
					$users[$daily->usr_num]=$this->user_data_service->find_user($daily->usr_num);
				}
				
				$daily = $this->__assemble_view_daily($daily, $users[$daily->usr_num]);
			}
			
			
			return $dailys;
		}
		
		public function find_daily_record($ddr_num){
			return $this->dia_daily_record_dao->query_by_ddr_num($ddr_num);
		}
		
		public function save_daily_record($input,$usr_num){
			
			$data=$this->__assemble_save_daily_record($input, $usr_num);
			return $this->dia_daily_record_dao->insert($data);
		}
		
		public function update_daily_record($input){
			$data=$this->__assemble_update_daily_record($input);
			$this->dia_daily_record_dao->update($data);
		}
		
		private function __assemble_update_game_id($input){
				
			$game_id->gid_num=$input['gid_num'];
			$game_id->gid_status=$input['gid_status'];
			$game_id->grd_num=$input['grd_num'];

			return $game_id;

		}
		
		private function __assemble_save_daily_record($input,$usr_num){
			$ddr->usr_num=$usr_num;
			$ddr->ddr_content=$input['ddr_content'];
			$ddr->ddr_status=$input['ddr_status'];
			$ddr->ddr_type=$input['ddr_type'];
			$ddr->register_date=date('Y-m-d H:i:s');
			
			return $ddr;
		}
		
		private function __assemble_update_daily_record($input){
			
			$ddr->ddr_num=$input['ddr_num'];
			
			if(isset($input['ddr_content'])){
				$ddr->ddr_content=$input['ddr_content'];	
			}
			
			if(isset($input['ddr_status'])){
				$ddr->ddr_status=$input['ddr_status'];	
			}
			
			if(isset($input['ddr_type'])){
				$ddr->ddr_type=$input['ddr_type'];
			}
			
			return $ddr;
		}
		
		private function __assemble_view_gid($gid,$game,$grd=NULL){
				
			$result=(object) array_merge((array)$gid,(array)$game);	
				
			// $result->gam_num=$game->gam_num;
			// $result->gam_cname=$game->gam_cname;
			// $result->gam_ename=$game->gam_ename;
			// $result->gam_svalue=$game->gam_svalue;
			// $result->gam_locate=$game->gam_locate;
			// $result->gid_num=$gid->gid_num;
			// $result->gid_status=$gid->gid_status;
			// $result->gid_rentable=$gid->gid_rentable;
			// $result->grd_num=$gid->grd_num;
			// $result->gid_status_desc=$this->form_constants->transfer_gid_status($gid->gid_status);
			// $result->gid_rentable_desc=$this->form_constants->transfer_gid_rentable($gid->gid_rentable);
			
			if($grd!=NULL){
				$result->grd_num=$grd->grd_num;	
			}
			
			// $result->grd=$grd;
			
			return $result;
		}
		
		private function __assemble_save_game_id_record($input,$usr_num){
				
			$result->gid_num=$input['gid_num'];
			$result->grd_type=$input['gid_status'];
			$result->grd_susr_num=$usr_num;
			$result->grd_start_time=date('Y-m-d H:i:s');
			
			if($input['gid_status']==1){
				$result->grd_end_time=date('Y-m-d H:i:s');
				$result->grd_eusr_num=$usr_num;	
			}
			
			
			if(isset($input['grd_memo'])){
				$result->grd_memo=$input['grd_memo'];
			}
			
			return $result;
		}
		
		private function __assemble_update_game_id_record($grd_num,$usr_num,$grd_memo=NULL){
				
			$result->grd_num=$grd_num;
			
			$result->grd_eusr_num=$usr_num;
			$result->grd_end_time=date('Y-m-d H:i:s');
			
			$result->grd_memo=$grd_memo;
			
			return $result;
		}
		
		private function __assemble_view_daily($daily,$user){
				
			$daily->usr_name=$user->usr_name;
			$daily->ddr_status_desc=$this->form_constants->transfer_ddr_status($daily->ddr_status);
			$daily->ddr_type_desc=$this->form_constants->transfer_ddr_type($daily->ddr_type);
			
			return $daily;
		}
		
    }
    
?>