<?php
    /**
     * 
     */
    class Report_service extends CI_Model {
        
        function __construct()
	    {
	        parent::__construct();
			$this->load->model('dao/dia_game_dao');
			$this->load->model('dao/dia_game_id_dao');
			$this->load->model('dao/dia_game_id_record_dao');
			$this->load->model('dao/dia_daily_record_dao');
			$this->load->model('service/pos_data_service');
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

		public function find_pos_for_report($start,$end){
			$condition=NULL;
			$condition['start_pod_date']=$start;
			$condition['end_pod_date']=$end;
			$condition['pod_status']=1;
			$pos_list = $this->pos_data_service->find_pos_for_list($condition);
			
			// $result->view=$this->find_pos_record_for_calendar($pos_list);
			// $result->summary=$this->find_pos_for_summary($pos_list);
			return $this->find_pos_record_for_calendar($pos_list);
		}

		public function find_pos_record_for_calendar($pos_list){
				
				
			//step1. 找出條件之pos資料
			// $condition=NULL;
			// $condition['start_pod_date']=$start;
			// $condition['end_pod_date']=$end;
			// $condition['pod_status']=1;
			// $pos_list = $this->pos_data_service->find_pos_for_list($condition);
			// log_message("info", gettype( $pos_list[0]->pod_date));
			// log_message("info", $pos_list[0]->pod_date);
			// log_message("info", date('Y-m-d',strtotime($pos_list[0]->pod_date)));
			// log_message("info",print_r($pos_list,TRUE));
			// $grouped_pos=$this->__group_pos_by_tag($pos_list);
			// log_message("info",print_r($grouped_pos,TRUE));
// 			
			// foreach ($grouped_pos as $key => $gpos) {
				// $grouped_pos[$key]->total_svalue=$this->__calculate_total_value($grouped_pos[$key]->pos_list);
			// }
			
			//step2. 利用pos的日期作分類
			$pos_date_list = array();
			$tags = $this->pos_data_service->find_pod_type_tags();
			foreach ($pos_list as $key => $pos) {
				$date_key=date('Y-m-d',strtotime($pos->pod_date));
				if(!array_key_exists($date_key, $pos_date_list)){
					$day_pos=array();
					foreach ($tags as $key2 => $tag) {
						$pos_data = NULL;
						$pos_data->tag=$tag;
						$pos_data->total_svalue=0;
						$pos_data->pod_date=$date_key." 00:00:".$tag->tag_num;
						$day_pos[$tag->tag_num]=$pos_data;
					}
					$pos_date_list[$date_key]=$day_pos;
				}
				
				// if(!array_key_exists($pos->tag->tag_num, $pos_date_list[$date_key])){
					// $pos_data = NULL;
					// $pos_data->tag=$pos->tag;
					// $pos_data->total_svalue=0;
					// $pos_data->pod_date=$date_key;
					// $pos_date_list[$date_key][$pos->tag->tag_num]=$pos_data;
				// }
				$pos_date_list[$date_key][$pos->tag->tag_num]->total_svalue+=$pos->pod_svalue;
			}
			 // log_message("info",print_r($pos_date_list,TRUE));			
			
			$view_pos=array();
			foreach ($pos_date_list as $key => $pos_datas) {
				foreach ($pos_datas as $key2 => $pos_data) {
					$view_pos[]=$this->__assemble_view_pos_for_calendar($pos_data);
				}
			}
			
			return $view_pos;
		}

		public function find_pos_for_summary($pos_list){
			
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
		
		private function __group_pos_by_tag($query_pos_list){
			$grouped_pos=array();
			foreach ($query_pos_list as $key => $pos) {
				if(!array_key_exists($pos->tag->tag_num, $grouped_pos)){
					$grouped_pos[$pos->tag->tag_num]->total_svalue=0;
					$grouped_pos[$pos->tag->tag_num]->pos_list=array();
				}
				
				$grouped_pos[$pos->tag->tag_num]->pos_list[$pos->pod_num]=$pos;
			}
			
			return $grouped_pos;
		}
		
		private function __calculate_total_value($pos_list){
			$result=0;
			foreach ($pos_list as $key => $pos) {
				$result+=$pos->pod_svalue;
			}
			
			return $result;
		}
		
		private function __assemble_view_pos_for_calendar($pos_data){
			$result=NULL;
			// $result->id=$pos_data->tag->tag_num;
			
			// $grd_type_desc=$this->form_constants->transfer_grd_type($grd->grd_type);
			 $result->title=$pos_data->tag->tag_name."($".$pos_data->total_svalue.")";
			
			
			$result->color="#0066cc";
			$result->textColor="white";
			
			$result->start=$pos_data->pod_date;
			// $result->end=$pos_data->pod_date;
			$result->allDay=TRUE;
			
			return $result;
		}
		
    }
    
?>