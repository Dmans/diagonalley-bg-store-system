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

        private function __assemble_save_table($input){

            $dtb->dtb_name=$input['dtb_name'];
            $dtb->dtb_status=$input['dtb_status'];
            $dtb->dtb_max_cap=$input['dtb_max_cap'];
            $dtb->sto_num=$input['sto_num'];

            return $dtb;
        }

        public function find_table($dtb_num){
            $table = $this->dia_tables_dao->query_by_dtb_num($dtb_num);
            $table->store = $this->dia_store_dao->query_by_sto_num($$table->sto_num);
            return $table;
        }

        private function __assemble_update_table($input){

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