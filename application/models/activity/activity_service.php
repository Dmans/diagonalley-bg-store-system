<?php
    /**
     * 
     */
    class Activity_service extends CI_Model {
        
        function __construct()
	    {
	        parent::__construct();
			$this->load->model('dao/dia_activity_dao');
			$this->load->model("constants/form_constants");
	    }
		
		public function save_activity($input){
			$this->dia_activity_dao->insert($this->__assemble_save_activity($input));
		}
		
		public function update_activity($input){
			$this->dia_activity_dao->update($this->__assemble_update_activity($input));
		}
		
		public function find_activity_for_update($act_num){
			return $this->__assemble_activity_query_result($this->dia_activity_dao->query_by_act_num($act_num));
		}
		
		public function find_activitys_for_list($input){
			return $this->__assemble_query_result_list($this->dia_activity_dao->query_by_condition($input));
		}
		
		public function find_gids_for_list(){
			
			//step1.找出所有上架遊戲
			$gids = $this->dia_game_id_dao->query_all();
			
			if(count($gids)==1){
				$gid=$gids;
				$gids=NULL;
				$gids[]=$gid;
			}
			
			$result_set=array();
			foreach ($gids as $gid) {
				$game = $this->dia_game_dao->query_by_gam_num($gid->gam_num);
				$result_set[]=$this->__assemble_view_gid($gid, $game);
			}
			
			//將上架遊戲用英文名稱排列
			$result_set = object_sorter($result_set, "gam_ename");

			return $result_set;
		}
		
		
		
		public function find_game_id_for_update($gid_num){
			$gid = $this->dia_game_id_dao->query_by_gid_num($gid_num);
			$game = $this->dia_game_dao->query_by_gam_num($gid->gam_num);
			return $this->__assemble_view_gid($gid, $game);
		}
		
		private function __assemble_save_activity($input){
				
			$act->act_name=$input['act_name'];
			$act->act_type=$input['act_type'];
			$act->act_desc=$input['act_desc'];
			$act->act_status=$input['act_status'];
			$act->act_value=$input['act_value'];
			$act->register_date = date('Y-m-d H:i:s');

			return $act;
		}
		
		private function __assemble_update_activity($input){
				
			$act->act_num=$input['act_num'];	
			$act->act_name=$input['act_name'];
			$act->act_type=$input['act_type'];
			$act->act_desc=$input['act_desc'];
			$act->act_status=$input['act_status'];
			$act->act_value=$input['act_value'];

			return $act;
		}
		
		
		private function __assemble_query_result_list($query_result){
			$output = array();
			if(!empty($query_result)){
				
				if(count($query_result)==1){
					$act=$query_result;
					$query_result=NULL;
					$query_result[]=$act;
				}
				
				foreach ($query_result as $row) {
					$output[]=$this->__assemble_activity_query_result($row);
				}
			}
			
			return $output;
		}
		
		private function __assemble_activity_query_result($row){
				
			$result=NULL;
			$result->act_num=$row->act_num;
			$result->act_name=$row->act_name;
			$result->act_desc=$row->act_desc;
			$result->act_value=$row->act_value;
			$result->act_type=$row->act_type;
			$result->act_status=$row->act_status;
			$result->act_type_desc=$this->form_constants->transfer_act_type($row->act_type);
			$result->act_status_desc=$this->form_constants->transfer_act_status($row->act_status);
			$result->register_date=$row->register_date;
			
			return $result;
		}
		
		private function __assemble_view_gid($gid,$game){
			$result->gam_num=$game->gam_num;
			$result->gam_cname=$game->gam_cname;
			$result->gam_ename=$game->gam_ename;
			$result->gid_num=$gid->gid_num;
			$result->gid_status=$gid->gid_status;
			$result->gid_rentable=$gid->gid_rentable;
			$result->gid_enabled=$gid->gid_enabled;
			$result->gid_status_desc=$this->form_constants->transfer_gid_status($gid->gid_status);
			$result->gid_rentable_desc=$this->form_constants->transfer_gid_rentable($gid->gid_rentable);
			$result->gid_enabled_desc=$this->form_constants->transfer_gid_enabled($gid->gid_enabled);
			return $result;
		}
		
    }
    
?>