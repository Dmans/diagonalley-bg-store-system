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
            $converted_stores = array();
            foreach ($stores as $store) {
                $converted_stores[$store->sto_num] = $store;
            }

            return $converted_stores;
        }
    }

?>