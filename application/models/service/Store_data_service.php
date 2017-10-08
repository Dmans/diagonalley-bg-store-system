<?php
    /**
     *
     */
    class store_data_service extends MY_Model {

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
        	$stores = array();
        	foreach ($usr_permission as $row){
        		// 取得store
        		$store = $this->dia_store_dao->query_by_pk($row->sto_num);
        		if($store->sto_type==0){
        		$stores[]=$store;
        		}
        	}
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