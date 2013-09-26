<?php
    /**
     * 
     */
    class tag_data_service extends CI_Model {
        
        function __construct()
	    {
	        parent::__construct();
			$this->load->model('dao/dia_tag_dao');
			$this->load->model("constants/form_constants");
	    }
		
		public function save_tag($input){
			return $this->dia_tag_dao->insert($this->__assemble_save_tag($input));
		}
		
		public function update_tag($input){
			$this->dia_tag_dao->update($this->__assemble_update_tag($input));
		}
		
		public function find_tag($tag_num){
			return $this->__assemble_tag_query_result($this->dia_tag_dao->query_by_tag_num($tag_num));
		}
		
		public function find_tags_list($input){
			$result_set = $this->dia_tag_dao->query_by_condition($input);
			
			return $this->__assemble_tag_query_result_list($result_set);
		}
		
		private function __assemble_save_tag($input){
			$tag->tag_name=$input['tag_name'];
			$tag->tag_type=$input['tag_type'];
			$tag->tag_desc=$input['tag_desc'];
			
			if(isset($input['tag_color'])){
				$tag->tag_color=$input['tag_color'];	
			}
			
			if(isset($input['tag_bgcolor'])){
				$tag->tag_bgcolor=$input['tag_bgcolor'];
			}
			
			$tag->tag_status=1; //預設啟用
			$tag->register_date = date('Y-m-d H:i:s');

			return $tag;
		}
		
		private function __assemble_update_tag($input){
				
			$tag->tag_num=$input['tag_num'];
			
			if(isset($input['tag_name'])){
				$tag->tag_name = $input['tag_name'];
			}
			
			if(isset($input['tag_desc'])){
				$tag->tag_desc = $input['tag_desc'];
			}
			
			if(isset($input['tag_color'])){
				$tag->tag_color = $input['tag_color'];
			}
			
			if(isset($input['tag_bgcolor'])){
				$tag->tag_bgcolor = $input['tag_bgcolor'];
			}
			
			if(isset($input['tag_status'])){
				$tag->tag_status = $input['tag_status'];
			}
			
			return $tag;
		}
		
		private function __assemble_tag_query_result_list($query_result){
			$output = array();
			if(!empty($query_result)){
				foreach ($query_result as $row) {
					$output[$row->tag_num]=$this->__assemble_tag_query_result($row);
				}
			}
			
			return $output;
		}
		
		private function __assemble_tag_query_result($query_result){
			$tag=NULL;
			$tag->tag_num=$query_result->tag_num;
			$tag->tag_name=$query_result->tag_name;
			$tag->tag_type=$query_result->tag_type;
			$tag->tag_desc=$query_result->tag_desc;
			$tag->tag_color=$query_result->tag_color;
			$tag->tag_bgcolor=$query_result->tag_bgcolor;
			
			return $tag;
			
		}
		
		
    }
    
?>