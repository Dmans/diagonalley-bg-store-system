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

        private function convert_store_array($stores) {
            $converted_stores = array();
            foreach ($stores as $store) {
                $converted_stores[$store->sto_num] = $store;
            }

            return $converted_stores;
        }
    }

?>