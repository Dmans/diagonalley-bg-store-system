<?php
    /**
     * 
     */
    class Pos_service extends CI_Model {
        
        function __construct()
	    {
	        parent::__construct();
			$this->load->model("dao/dia_pos_order_dao");
			$this->load->model('service/tag_data_service');
	    }
		
		public function save_pos($input,$usr_num){
			return $this->dia_pos_order_dao->insert($this->__assemble_save_pod($input,$usr_num));
		}
		
		public function update_pos($input,$usr_num){
			$this->dia_pos_order_dao->update($this->__assemble_update_pod($input,$usr_num));
		}
		
		public function remove_pos($pod_num,$usr_num){
			$input['pod_num']=$pod_num;
			$input['pod_status']=2; //取消狀態
			// $input['pod_usr_num']=$usr_num;
			$this->update_pos($input, $usr_num);
		}
		
		public function find_pos($pod_num){
			$pos=$this->dia_pos_order_dao->query_by_pod_num($pod_num);
			$tag=$this->tag_data_service->find_tag($pos->tag_num);
			
			return $this->__assemble_view_update_pod($pos,$tag);
		}
		
		public function find_pod_type_tags($is_enabled=TRUE){
			$condition=NULL;
			$condition['tag_type']=1; //POS類型
			
			if($is_enabled){
				$condition['tag_status']=1; //啟用標籤	
			}
			
			return $this->tag_data_service->find_tags_list($condition);
		}
		
		public function find_view_pos_for_list($input){
				
			
			// step1. 找出所選日期銷售紀錄
			$condition=NULL;
			$condition['start_pod_date']=$input['pod_date'];
			$condition['end_pod_date']=$input['pod_date'];
			$condition['pod_status']=1;
			
			// 取日期區間內pos紀錄
			$query_result = $this->dia_pos_order_dao->query_by_condition($condition);
			
			// 取所有的tag
			$tags=$this->find_pod_type_tags(FALSE);
			$pos_list = $this->__assemble_view_pos_list($query_result,$tags);
			
			
			// step2. 計算報表相關資料
			$cal_result=$this->__calculate_view_pos_list_data($pos_list);
			
			$view_pos=NULL;
			$view_pos->pos_list=$pos_list;
			$view_pos->cal_result=$cal_result;
			
			return $view_pos;
		}
		
		private function __assemble_save_pod($input,$usr_num){
			
			$pod->pod_date=$input['pod_date'];	
			$pod->pod_svalue=$input['pod_svalue'];
			$pod->tag_num=$input['tag_num'];
			
			if(isset($input['pod_desc'])){
				$pod->pod_desc=$input['pod_desc'];
			}
			
			$pod->pod_status=$input['pod_status'];
			$pod->pod_usr_num=$usr_num;
			
			return $pod;
		}
		
		private function __assemble_update_pod($input,$usr_num){
			
			$pod->pod_num=$input['pod_num'];	
			
			if(isset($input['pod_svalue'])){
				$pod->pod_svalue=$input['pod_svalue'];
			}
			
			if(isset($input['pod_desc'])){
				$pod->pod_desc=$input['pod_desc'];
			}
			
			if(isset($input['pod_status'])){
				$pod->pod_status=$input['pod_status'];
			}
			
			$pod->pod_usr_num=$usr_num;
			
			return $pod;
		}
		
		private function __assemble_view_update_pod($pos,$tag){
			$pos->tag_name=$tag->tag_name;
			return $pos;
		}
		
		private function __assemble_view_pos_list($query_result, $tags){
			$output = array();
			if(!empty($query_result)){
				
				if(count($query_result)==1){
					$output[]=$this->__assemble_view_pos($query_result,$tags);
				}
				
				if(count($query_result)>1){
					foreach ($query_result as $row) {
						$output[]=$this->__assemble_view_pos($row,$tags);
					}
				}
			}
			
			return $output;
		}
		
		private function __assemble_view_pos($row,$tags){
				
			$result=NULL;
			$result->pod_num=$row->pod_num;
			$result->pod_svalue=$row->pod_svalue;
			$result->tag=$tags[$row->tag_num];
			
			$result->pod_date=$row->pod_date;
			$result->pod_status=$row->pod_status;
			$result->pod_usr_num=$row->pod_usr_num;

			if(isset($row->pod_desc)){
				$result->pod_desc=$row->pod_desc;
			}

			return $result;
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