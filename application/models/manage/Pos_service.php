<?php
    /**
     *
     */
    class Pos_service extends CI_Model {

        function __construct()
	    {
	        parent::__construct();
			$this->load->model('service/pos_data_service');
			$this->load->model('dao/dia_fast_pos_dao');
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
			$view_pos=new stdClass();
			$view_pos->pos_list=$pos_list;
			$view_pos->cal_result=$cal_result;

			return $view_pos;
		}

		public function find_fast_pos_list(){
			$condition=array();
			$condition['pfs_visible']=1;
			$condition['order_pfs_order']="ASC";
			$fast_pos_list = $this->dia_fast_pos_dao->query_by_condition($condition);

			return $this->__assemble_view_fast_pos_list($fast_pos_list, $this->find_pod_type_tags());
		}

		public function save_pos_fast_button($input){
			$fast_pos=NULL;
			$fast_pos->pod_svalue=$input['pod_svalue'];
			$fast_pos->pod_desc=$input['pod_desc'];
			$fast_pos->tag_num=$input['tag_num'];
			$fast_pos->pod_status=$input['pod_status'];
			$fast_pos->pfs_order=$input['pfs_order'];
			$fast_pos->pfs_visible=1; //預設顯示按鈕
			return $this->dia_fast_pos_dao->insert($fast_pos);
		}

		public function find_pos_fast($pfs_num){
			$fast_pos = $this->dia_fast_pos_dao->query_by_pfs_num($pfs_num);

			return  $this->__assemble_view_fast_pos($fast_pos, $this->find_pod_type_tags());
		}

		public function save_pos_fast($input, $usr_num){
			//step1. 找出對應pos預設資料
			$pfs_nums=$input['pfsNums'];

			$target_pfs_nums=array_unique($pfs_nums);

			$pos_fast_source=array();
			foreach ($target_pfs_nums as $pfs_num) {
				$pos_fast_source[$pfs_num]=$this->find_pos_fast($pfs_num);
			}

			//step2. 轉成save_multiple_pos可吃資料
			$pos_list=array();
			foreach ($pfs_nums as $pfs_num) {

				$pfs_data=$pos_fast_source[$pfs_num];
				$pos=NULL;
				$pos['pod_date']=date('Y-m-d H:i:s');
				$pos['pod_svalue']=$pfs_data->pod_svalue;
				$pos['tag_num']=$pfs_data->tag->tag_num;
				$pos['pod_desc']=$pfs_data->pod_desc;
				$pos['pod_status']=$pfs_data->pod_status;

				$pos_list[]=$pos;
			}

			//step3. 呼叫save_multiple_pos塞入資料
			$this->pos_data_service->save_multiple_pos($pos_list,$usr_num);
		}

		public function update_pos_fast_button($input){
			$pfs=NULL;
			$pfs->pfs_num=$input['pfs_num'];

			$value_conditions=array("pod_svalue","pod_desc","pod_status","pfs_order","pfs_visible");
			foreach ($value_conditions as $field_name) {
				if(isset($input[$field_name])){
					$pfs->$field_name = $input[$field_name];
				}
			}
			return $this->dia_fast_pos_dao->update($pfs);
		}

		public function remove_pos_fast_button($pfs_num){
			$pfs['pfs_num']=$pfs_num;
			$pfs['pfs_visible']=0;
			$this->update_pos_fast_button($pfs);
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

			$cal_result= new stdClass();
			$cal_result->tag_sub_svalue=$tag_sub_svalue;
			$cal_result->total_svalue=$total_svalue;

			return $cal_result;
		}

		private function __assemble_view_fast_pos_list($fast_pos_list, $tags){
			$result = array();

			foreach ($fast_pos_list as $fast_pos) {
				$result[]=$this->__assemble_view_fast_pos($fast_pos, $tags);
			}

			return $result;
		}

		private function __assemble_view_fast_pos($fast_pos, $tags){
			$fast = new stdClass();
			$fast->pfs_num = $fast_pos->pfs_num;
			$fast->pod_svalue = $fast_pos->pod_svalue;
			$fast->pod_desc = $fast_pos->pod_desc;
			$fast->pod_status=$fast_pos->pod_status;
			$fast->pfs_order=$fast_pos->pfs_order;
			$fast->pfs_visible=$fast_pos->pfs_visible;
			$fast->tag=$tags[$fast_pos->tag_num];

			return $fast;
		}

    }

?>