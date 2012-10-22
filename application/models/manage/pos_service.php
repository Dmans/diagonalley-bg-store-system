<?php
    /**
     * 
     */
    class Pos_service extends CI_Model {
        
        function __construct()
	    {
	        parent::__construct();
			$this->load->model('service/pos_data_service');
	    }
		
		public function save_pos($input,$usr_num){
			return $this->pos_data_service->save_pos($input,$usr_num);
		}
		
		public function save_multiple_pos($input,$usr_num){
			
			//取得要新增的項目
			$pos_enableds=$input['pos_enabled'];
			
			$pos_list=array();
			foreach ($pos_enableds as $key => $pos_enabled) {
				$pos=array();
				$pos['pod_date']=$input['pod_date'][$pos_enabled];
				$pos['pod_svalue']=$input['pod_svalue'][$pos_enabled];
				$pos['tag_num']=$input['tag_num'][$pos_enabled];
				$pos['pod_desc']=$input['pod_desc'][$pos_enabled];
				$pos['pod_status']=$input['pod_status'][$pos_enabled];
				$pos_list[]=$pos;
			}
			
			return $this->pos_data_service->save_multiple_pos($pos_list,$usr_num);
		}
		
		public function update_pos($input,$usr_num){
			$this->pos_data_service->update_pos($input,$usr_num);
		}
		
		public function remove_pos($pod_num,$usr_num){
			$this->pos_data_service->remove_pos($pod_num,$usr_num);
		}
		
		public function find_pos($pod_num){
			return $this->pos_data_service->find_pos($pod_num);
		}
		
		public function find_pod_type_tags($is_enabled=TRUE){
			return $this->pos_data_service->find_pod_type_tags();
		}		
		public function find_view_pos_for_list($input){
				
			
			// step1. 找出所選日期銷售紀錄,取日期區間內pos紀錄
			$condition=NULL;
			$condition['start_pod_date']=$input['pod_date'];
			$condition['end_pod_date']=$input['pod_date'];
			$condition['pod_status']=1;
			$pos_list = $this->pos_data_service->find_pos_for_list($condition);

			
			// step2. 計算報表相關資料
			$cal_result=$this->__calculate_view_pos_list_data($pos_list);
			
			
			// step3. 組合
			$view_pos=NULL;
			$view_pos->pos_list=$pos_list;
			$view_pos->cal_result=$cal_result;
			
			return $view_pos;
		}
		
		private function __calculate_view_pos_list_data($pos_list){
			
			$tag_sub_svalue=array();
			$total_svalue=0;
			
			
			foreach($pos_list as $pos){
				// step1.加總營收
				$total_svalue+=$pos->pod_svalue;
				
				// step2.針對銷售類型作加總營收
				if(count($tag_sub_svalue)<=0 || !array_key_exists($pos->tag->tag_num, $tag_sub_svalue)){
					$tag_sub_svalue[$pos->tag->tag_num]->tag_name=$pos->tag->tag_name;
					$tag_sub_svalue[$pos->tag->tag_num]->sub_svalue=0;
				}
				
				$tag_sub_svalue[$pos->tag->tag_num]->sub_svalue += $pos->pod_svalue;
			}
			
			$cal_result=NULL;
			$cal_result->tag_sub_svalue=$tag_sub_svalue;
			$cal_result->total_svalue=$total_svalue;
			
			return $cal_result;
		}
		
    }
    
?>