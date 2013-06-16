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
			$this->load->helper('date');
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

		public function find_pos_for_report($start, $end){
			
			//step1. 取得pos原始資料
			$pos_base_list=$this->__find_origin_pos_record_list($start, $end);
			
			
			//step2. 利用pos的日期作分類 並加總各類別銷售數字
			$pos_date_list = array();
			$tags = $this->pos_data_service->find_pod_type_tags();
			foreach ($pos_base_list as $key => $pos) {
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
				
				$pos_date_list[$date_key][$pos->tag->tag_num]->total_svalue+=$pos->pod_svalue;
			}
			
			return $pos_date_list;
		}
		
		public function find_pos_record_for_calendar($start_date, $end_date){
			
			$pos_date_list=$this->find_pos_for_report($start_date, $end_date);
				
			$view_pos=array();
			foreach ($pos_date_list as $key => $pos_datas) {
				foreach ($pos_datas as $key2 => $pos_data) {
					$view_pos[]=$this->__assemble_view_pos_for_calendar($pos_data);
				}
			}
			
			return $view_pos;
		}
		
		public function find_pos_record_for_table($query_year, $query_month){
				
			$month_data=$this->__get_month_start_and_end_date($query_year, $query_month);
			
			$end_day =$month_data->end_day;
			$start=$month_data->start_date;
			$end=$month_data->end_date;		
				
			$pos_list=$this->find_pos_for_report($start, $end);
			$tags = $this->pos_data_service->find_pod_type_tags();
				
			$view_pos=array();
			for ($day=1; $day <= $end_day ; $day++) {
				$data=NULL;	 
				$target_date= sprintf("%4d-%02d-%02d", $query_year, $query_month, $day);
				$data['pos_date']=$target_date;
				foreach ($tags as $tag) {
					$tag_data=NULL;
					if(isset($pos_list[$target_date][$tag->tag_num])){
						$tag_data->total_svalue=$pos_list[$target_date][$tag->tag_num]->total_svalue;
					}else{
						$tag_data->total_svalue=0;
					}
					$data[$tag->tag_num]=$tag_data;
				}
				
				$view_pos[$target_date]=$data;
			}
			
			return $view_pos;
		}
		
		public function find_pos_record_fot_graph($query_year, $query_month){
			
			$month_data=$this->__get_month_start_and_end_date($query_year, $query_month);
			
			$end_day =$month_data->end_day;
			$start=$month_data->start_date;
			$end=$month_data->end_date;
			
			$pos_list=$this->find_pos_for_report($start, $end);
			$tags=$this->pos_data_service->find_pod_type_tags();	
			
			$series=array();
			foreach ($tags as $tag) {
				$cate_series=NULL;
				for ($day=1; $day <= $end_day ; $day++) {
						
					$target_date= sprintf("%4d-%02d-%02d", $query_year, $query_month, $day);
										
					$cate_series->name=$tag->tag_name;

					if(isset($pos_list[$target_date][$tag->tag_num])){
						$cate_series->data[]=$pos_list[$target_date][$tag->tag_num]->total_svalue;
					}else{
						$cate_series->data[]=0;
					}
				}
				$series[]=$cate_series;
			}
			
			$categories=array();
			for ($day=1; $day <= $end_day ; $day++) {
						
				// $target_date= sprintf("%4d-%02d-%02d", $query_year, $query_month, $day);
				$categories[]=$day;
			}
			
			$data->categories=$categories;
			$data->series=$series;
			
			return $data;
		}

		

		public function find_pos_for_summary($pos_list){
			
		}
		
		private function __find_pos_record_for_calendar($pos_date_list){
				
			$view_pos=array();
			foreach ($pos_date_list as $key => $pos_datas) {
				foreach ($pos_datas as $key2 => $pos_data) {
					$view_pos[]=$this->__assemble_view_pos_for_calendar($pos_data);
				}
			}
			
			return $view_pos;
		}
		
		private function __find_origin_pos_record_list($star_date, $end_date){
			$condition=NULL;
			$condition['start_pod_date']=$star_date;
			$condition['end_pod_date']=$end_date;
			$condition['pod_status']=1;
			$pos_list = $this->pos_data_service->find_pos_for_list($condition);
			
			return $pos_list;
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
			// $result->name=$pos_data->tag->tag_name;
			// $result->total_svalue=$pos_data->total_svalue;
			// $result->tag_num=$pos_data->tag->tag_num;
			return $result;
		}
		
		private function __get_month_start_and_end_date($query_year, $query_month){
			
			$end_day =days_in_month($query_month, $query_year);
			
			$month_data=NULL;
			$month_data->year=$query_year;
			$month_data->month=$query_month;
			$month_data->start_date=$query_year.'-'.$query_month.'-01';
			$month_data->end_date=$query_year.'-'.$query_month.'-'.$end_day;
			$month_data->end_day=$end_day;
			
			return $month_data;
		}
		
    }
    
?>