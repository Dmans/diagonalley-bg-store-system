<?php
    /**
     *
     */
    class store_data_service extends CI_Model {

        function __construct()
	    {
	        parent::__construct();
			$this->load->model("dao/dia_store_dao");
			$this->load->model("constants/form_constants");
			$this->load->model("dao/dia_user_store_permission_dao");
	    }

        public function get_stores() {
            $stores = $this->dia_store_dao->query_all();
            return $this->convert_store_array($stores);
        }
        
        public function get_real_stores() {
            $condition['sto_type'] = 0;
            $stores = $this->dia_store_dao->query_by_condition($condition);
            return $this->convert_store_array($stores);
        }
        
        public function get_real_stores_by_user_num($usr_num){
        	$usr_permission = $this->dia_user_store_permission_dao->query_by_usr_num($usr_num);
        	//log_message("info","Tables_action.lists_form(".print_r($usr_permission,TRUE).") - end ");
        	$stores = array();
        	foreach ($usr_permission as $row){
        		log_message("info","get_real_stores_by_user_num".print_r($row,TRUE));
        		// 取得store
        		$store = $this->dia_store_dao->query_by_sto_num($row->sto_num);
        		log_message("info","get_real_stores_by_user_num2".print_r($store,TRUE));
        		$stores[]=$store;
//         		$converted_sto_num['sto_num']= $row;
        	}
        	log_message("info","get_real_stores_by_user_num3".print_r($stores,TRUE));
        	
        	
        	return $stores;
        	
        	
        		
        }

        private function convert_store_array($stores) {
            $converted_stores = array();
            foreach ($stores as $store) {
                $converted_stores[$store->sto_num] = $store;
            }

            return $converted_stores;
        }
    }

?>