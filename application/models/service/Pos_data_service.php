<?php
    /**
     * 
     */
    class Pos_data_service extends CI_Model {
        
        function __construct()
	    {
	        parent::__construct();
			$this->load->model("dao/dia_pos_order_dao");
			$this->load->model('service/tag_data_service');
	    }
		
		public function save_pos($input,$usr_num){
			return $this->dia_pos_order_dao->insert($this->__assemble_save_pod($input,$usr_num));
		}
		
		public function save_multiple_pos($pos_list,$usr_num){
			$pod_nums=array();
			
			foreach ($pos_list as $key => $pos) {
				$pod_nums[]=$this->save_pos($pos,$usr_num);
			}
			
			return $pod_nums;
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
			$pos=$this->dia_pos_order_dao->query_by_pk($pod_num);
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
		
		public function find_pos_for_list($condition){
				
			$query_result = $this->dia_pos_order_dao->query_by_condition($condition);
			
			// 取所有的tag
			$tags=$this->find_pod_type_tags(FALSE);
			$pos_list = $this->__assemble_view_pos_list($query_result,$tags);
			
			
			return $pos_list;
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
			
			$value_conditions=array("pod_date","pod_svalue","pod_desc","pod_status");
			foreach ($value_conditions as $field_name) {
				if(isset($input[$field_name])){
					$pod->$field_name = $input[$field_name];
				}
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
				foreach ($query_result as $row) {
					$output[]=$this->__assemble_view_pos($row,$tags);
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
		
    }
    
?>