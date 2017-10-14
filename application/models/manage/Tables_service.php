<?php
    /**
     *
     */
    class Tables_service extends CI_Model {

        function __construct()
        {
            parent::__construct();
            $this->load->model('dao/dia_tables_dao');
            $this->load->model('dao/dia_store_dao');
            $this->load->model('service/tables_data_service');
            $this->load->model("constants/form_constants");
        }

        public function save_table($input){

            $data=$this->__assemble_save_table($input);
            return $this->dia_tables_dao->insert($data);
        }

        public function update_table($input){
            $data=$this->__assemble_update_table($input);
            $this->dia_tables_dao->update($data);
        }
        
        public function find_tables_for_list($input){
        	
        	log_message("info","find_tables_for_list(input=".print_r($input,TRUE).") - start");
        	return $this->tables_data_service->find_tables_list($input);
        }

        private function __assemble_save_table($input){

        	$dtb = New stdClass();
            $dtb->dtb_name=$input['dtb_name'];
            $dtb->dtb_status=$input['dtb_status'];
            $dtb->dtb_max_cap=$input['dtb_max_cap'];
            $dtb->sto_num=$input['sto_num'];

            return $dtb;
        }

        public function find_table($dtb_num){
            $table = $this->dia_tables_dao->query_by_pk($dtb_num);
            $table->store = $this->dia_store_dao->query_by_pk($table->sto_num);
            return $table;
        }

        private function __assemble_update_table($input){
        	$dtb = New stdClass();
            $dtb->dtb_num=$input['dtb_num'];

            if(isset($input['dtb_name'])){
                $dtb->dtb_name=$input['dtb_name'];
            }

            if(isset($input['dtb_status'])){
                $dtb->dtb_status=$input['dtb_status'];
            }

            return $dtb;
        }
    }

?>