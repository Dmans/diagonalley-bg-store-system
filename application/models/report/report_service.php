<?php
    /**
     * 
     */
    class Report_service extends CI_Model {
        
        function __construct()
	    {
	        parent::__construct();
			// $this->load->helper('array');
			$this->load->model('dao/dia_game_dao');
			$this->load->model('dao/dia_game_id_dao');
			$this->load->model('dao/dia_game_id_record_dao');
			$this->load->model('dao/dia_daily_record_dao');
			$this->load->model("constants/form_constants");
	    }
		
		public function find_gid_record_for_calendar($start,$end){
			$condition['grd_start_time']=$start;
			$condition['grd_end_time']=$end;
			$grds = $this->dia_game_id_record_dao->query_by_condition($condition);

			if(count($grds)==1){
				$grd=$grds;
				$grds=NULL;
				$grds[]=$grd;
			}
			//step2.組view資料
			$result_set=array();
			$already_gids=array();
			$already_games=array();
			foreach ($grds as $grd) {
				
				//step2-1.抓遊戲資料
				if(isset($already_gids[$grd->gid_num])){
					$gid=$already_gids[$grd->gid_num];
					$game=$already_games[$gid->gam_num];
				}else{
					$gid = $this->dia_game_id_dao->query_by_gid_num($grd->gid_num);
					$already_gids[$grd->gid_num]=$gid;
					$game = $this->dia_game_dao->query_by_gam_num($gid->gam_num);
					$already_games[$gid->gam_num]=$game;
				}
				
				$result_set[]=$this->__assemble_view_grd_for_calendar($gid, $game, $grd);
				
			}
			
			return $result_set;
		}
		
		
		private function __assemble_view_grd_for_calendar($gid,$game,$grd){
			$result=NULL;
			$result->id=$grd->grd_num;
			
			$grd_type_desc=$this->form_constants->transfer_grd_type($grd->grd_type);
			$result->title=$game->gam_cname."(".$grd_type_desc.")";
			
			if($grd->grd_type=='2'){
				$result->color="green";
				$result->textColor="white";
				$result->allDay=TRUE;
			}
			
			if($grd->grd_type=='1'){
				$result->color="#0066cc";
				$result->textColor="white";
				$result->allDay=FALSE;
			}
			
			$result->start=$grd->grd_start_time;
			$result->end=$grd->grd_end_time;
			
			
			return $result;
		}
		
    }
    
?>