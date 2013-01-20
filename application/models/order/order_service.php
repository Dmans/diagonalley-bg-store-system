<?php
    /**
     * 
     */
    class Order_service extends CI_Model {
        
        function __construct()
	    {
	        parent::__construct();
			$this->load->library('encrypt');
			$this->load->model("service/game_data_service");
			$this->load->model("service/user_data_service");
			$this->load->model("service/pos_data_service");
			$this->load->model("dao/dia_order_dao");
			$this->load->model("dao/dia_local_value_dao");
			$this->load->model("constants/form_constants");
	    }
		
		public function save_order($input){
			
			$order = $this->__assemble_save_order($input);
			
			//step1. 新增銷售資料並取得銷售資料流水號
			$pos_data=NULL;
			$pos_data['pod_date'] = $order['ord_date'];
			$pos_data['pod_svalue'] = $order['ord_svalue'];
			$pos_data['pod_status']=1; //表示成立狀態
			$pos_data['tag_num']=$this->__get_order_tag_num();
			
			
			$game = $this->game_data_service->find_game($order['gam_num']);
			
			$pos_data['pod_desc'] ="遊戲銷售:".$game->gam_ename."-".$game->gam_cname;
			
			$pod_num = $this->pos_data_service->save_pos($pos_data, $order['ord_usr_num']);
			
			
			//step2. 新增訂單資料
			$order['pod_num']=$pod_num;
			$ord_num = $this->dia_order_dao->insert($order);
			
			//step3. 扣庫存
			$this->game_data_service->modify_game_storage($input['gam_num'],-1);
			
			return $ord_num;
		}
		
		public function update_order($input){
			log_message("info","update_order start");
			$this->dia_order_dao->update($this->__assemble_update_order($input));
			log_message("info","update_order end");
		}
		
		public function find_orders_for_list($input){
			
			// step1. 取得輸入條件撈出的原始訂單資訊	
			$orders = $this->dia_order_dao->query_by_condition($this->__assemble_order_query_condition($input));
			
			if($orders==NULL){
				return NULL;
			}
			
			if(count($orders)==1){
				$temp=$orders;
				$orders=NULL;	
				$orders[0]=$temp;
			}
			
			// step2. 針對訂單撈出需要的使用者資訊
			$users=array();
			foreach ($orders as $key => $order) {
				if(!array_key_exists($order->usr_num, $users)){
					$users[$order->usr_num]=$this->user_data_service->find_user($order->usr_num);
				}
				
				if(!array_key_exists($order->ord_usr_num, $users)){
					$users[$order->ord_usr_num]=$this->user_data_service->find_user($order->ord_usr_num);
				}
			}
			
			// step2. 針對訂單撈出需要的使用者資訊
			$games=array();
			foreach ($orders as $key => $order) {
				if(!array_key_exists($order->gam_num, $users)){
					$games[$order->gam_num]=$this->game_data_service->find_game($order->gam_num);
				}
			}
			
			$orders = $this->__assemble_view_orders_for_list($orders, $users, $games);
			
			return $orders;
		}
		
		public function find_order_for_update($ord_num){
			$order=$this->dia_order_dao->query_by_ord_num($ord_num);
			$user=$this->user_data_service->find_user($order->usr_num);
			$ord_user=$this->user_data_service->find_user($order->ord_usr_num);
			$game=$this->game_data_service->find_game($order->gam_num);
			
			return $this->__assemble_view_order($order, $user, $game, $ord_user); 
		}
		
		private function __assemble_save_order($input){
			$order=NULL;
				
			$order['usr_num']=$input['usr_num'];
			$order['gam_num']=$input['gam_num'];
			$order['ord_type']=$input['ord_type'];
			
			if($input['ord_type']=="0"){
				$order['ord_svalue']=$input['gam_svalue'];
			}
			
			if($input['ord_type']=="1"){
				$order['ord_svalue']=$input['gam_svalue_rebate'];
			}
			
			$order['ord_date'] = $input['ord_date'];
			$order['ord_status']=$input['ord_status'];
			$order['ord_usr_num']=$input['ord_usr_num'];
			
			if(isset($input['pod_num'])){
				$order['pod_num']=$input['pod_num'];
			}
			
			return $order;
		}
		
		private function __assemble_update_order($input){
			$order=NULL;
			
			$value_conditions=array("ord_num","ord_status");
			foreach ($value_conditions as $field_name) {
				if(isset($input[$field_name]) && $input[$field_name]!=""){
					$order->$field_name = $input[$field_name];
				}
			}
				log_message("info","__assemble_update_order:".print_r($order,TRUE));
			return $order;
		}
		
		private function __assemble_order_query_condition($input){
			$condition=NULL;
			$value_conditions=array("ord_num","gam_num","start_order_date","end_order_date",
									"ord_status");
			foreach ($value_conditions as $field_name) {
				if(isset($input[$field_name]) && $input[$field_name]!=""){
					$condition[$field_name] = $input[$field_name];
				}
			}
			return $condition;
			
		}
		
		private function __assemble_view_orders_for_list($orders,$users,$games){
			$new_orders=array();
			
			foreach ($orders as $key => $order) {
				$new_orders[]=$this->__assemble_view_order(
					$order, $users[$order->usr_num], $games[$order->gam_num], $users[$order->ord_usr_num]);
			}
			
			return $new_orders;
		}
		
		private function __assemble_view_order($order,$user,$game,$ord_user){
			$order->usr_id=$user->usr_id;
			$order->gam_cname=$game->gam_cname;
			$order->gam_ename=$game->gam_ename;
			$order->ord_usr_name=$ord_user->usr_name;
			$order->ord_type_desc=$this->form_constants->transfer_ord_type($order->ord_type);
			$order->ord_status_desc=$this->form_constants->transfer_ord_status($order->ord_status);
			
			return $order;
		}
		
		private function __get_order_tag_num(){
			$dlv_data = $this->dia_local_value_dao->query_by_dlv_id("order_tag_num");
			
			return $dlv_data->dlv_value;
			
		}
    }
    
?>