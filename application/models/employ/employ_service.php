<?php
    /**
     * 
     */
    class Employ_service extends CI_Model {
        
        function __construct()
	    {
	        parent::__construct();
			$this->load->model('dao/dia_checkin_dao');
			$this->load->model('dao/dia_user_dao');
			$this->load->model("constants/form_constants");
	    }
		
		
		public function check_in($usr_num){
			$chk_num = $this->dia_checkin_dao->insert($this->__assemble_save_checkin($usr_num));
			
			return $this->dia_checkin_dao->query_by_chk_num($chk_num);
		}
		
		public function check_unfinished_checkin($usr_num){
			$chks=$this->find_user_check_list($usr_num);
			
			if(count($chks)==1){
				return (!isset($chks->chk_out_time));
			}
			
			if(count($chks)>1){
				foreach($chks as $row){
					if(!isset($row->chk_out_time)){
						return TRUE;
					}
				}
			}
			
			return FALSE;
		}
		
		public function check_out($chk_num,$usr_num){
			$chk = $this->dia_checkin_dao->query_by_chk_num($chk_num);
			
			if(isset($chk)){
				if($chk->usr_num==$usr_num){
					$this->dia_checkin_dao->update($this->__assemble_update_checkin($chk_num));
					return TRUE;
				}
			}
			
			return FALSE;
			
		}
		
		public function confirm($input,$usr_num){
			
			$chk = $this->dia_checkin_dao->query_by_chk_num($input['chk_num']);
			
			if(isset($chk)){
				if($chk->confirm_date==NULL){
					$this->dia_checkin_dao->update($this->__assemble_update_confirm($input,$usr_num));
					return TRUE;
				}
			}
			
			return FALSE;
			
		}
		
		public function find_uncheck_list(){
			$condition['uncheck']=TRUE;
			$chks = $this->dia_checkin_dao->query_by_condition($condition);
			
			if(count($chks)==1){
				$chk=$chks;
				$chks=NULL;
				$chks[]=$chk;
			}
			
			
			$result_set=array();
			if(count($chks)>0){
				foreach ($chks as $key => $chk) {
					$user = $this->dia_user_dao->query_by_usr_num($chk->usr_num);
					$result_set[]=$this->__assemble_user_checkin($user, $chk);
				}
			}
			
			return $result_set;
		}
		
		
		public function find_user_check_list($usr_num){
			return $this->dia_checkin_dao->query_by_usr_num($usr_num);
		}
		
		public function find_employ_monthly_record($chk_start_time, $chk_end_time){
			
			// step1. 取得所選區間打卡紀錄
			$condition['chk_start_time']=$chk_start_time;
			$condition['chk_end_time']=$chk_end_time;
			$chks = $this->dia_checkin_dao->query_by_condition($condition);
			
			// step2. 計算打卡時數
			if(!empty($chks)){
				foreach ($chks as $chk) {
					$start_time=strtotime($chk->chk_in_time);
					$end_time=strtotime($chk->chk_out_time);
					$chk->interval=$this->__calculate_time_interval($chk->chk_in_time,$chk->chk_out_time);
				}
			}
			
			// step3. 找出打卡使用者，綁定打卡資料
			$checked_users=array();
			if(!empty($chks)){
				foreach ($chks as $chk) {
					if(!array_key_exists($chk->usr_num, $checked_users)){
						$checked_users[$chk->usr_num]=$this->dia_user_dao->query_by_usr_num($chk->usr_num);
					}
					
					$checked_users[$chk->usr_num]->chks[]=$chk;
				}
			}
			
			// step4. 計算總時數
			foreach($checked_users as $chk_user){
				$total_hours=0;
				$total_confirm_hours=0;
				foreach($chk_user->chks as $chk){
					$total_hours += $chk->interval;
					$total_confirm_hours+=$chk->confirm_hours;
				}
				$chk_user->total_hours=$total_hours;
				$chk_user->total_confirm_hours=$total_confirm_hours;
			}
			
			return $checked_users;
			
		}
		
		private function __assemble_save_checkin($usr_num){
				
			$chk->usr_num=$usr_num;
			$chk->chk_in_time=date('Y-m-d H:i:s');
			return $chk;
		}
		
		private function __assemble_update_checkin($chk_num){
				
			$chk->chk_num=$chk_num;
			$chk->chk_out_time=date('Y-m-d H:i:s');
			return $chk;
		}
		
		private function __assemble_update_confirm($input,$usr_num){
				
			$chk->chk_num=$input['chk_num'];
			// $chk->chk_out_time=$input['chk_out_time'];
			$chk->confirm_hours=$input['confirm_hours'];
			$chk->confirm_usr_num=$usr_num;
			$chk->confirm_date=date('Y-m-d H:i:s');
			return $chk;
		}
		
		private function __assemble_user_checkin($user,$chk){
				
			$result->chk_num=$chk->chk_num;
			$result->usr_num=$chk->usr_num;
			$result->usr_name=$user->usr_name;
			$result->chk_in_time=$chk->chk_in_time;
			if(isset($chk->chk_out_time)){
				$result->chk_out_time=$chk->chk_out_time;
				$result->interval=$this->__calculate_time_interval($chk->chk_in_time, $chk->chk_out_time);
			}
			
			return $result;
			
		}
		
		private function __calculate_time_interval($str_start_time,$str_end_time){
			$start_time=strtotime($str_start_time);
			$end_time=strtotime($str_end_time);
			return round((($end_time-$start_time)/3600)*2,0)/2;
		}
		
    }
    
?>