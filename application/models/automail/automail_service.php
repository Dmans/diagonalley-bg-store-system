<?php
    /**
     *
     */
    class Automail_service extends CI_Model {

        function __construct()
	    {
	        parent::__construct();
			$this->load->model('dao/dia_checkin_dao');
			$this->load->model('dao/dia_user_dao');
            $this->load->model('dao/dia_user_store_permission_dao');
            $this->load->model('service/store_data_service');
			$this->load->model("constants/form_constants");
	    }

        public function find_in_progress_checkin() {

            $condition['chkin_start_time']=date('Y-m-t');

            $chks = $this->dia_checkin_dao->query_by_condition($condition);
            log_message("info","CHECK!:".print_r($chks,TRUE));
            $result_set=array();
            if(count($chks)>0){

                $stores = $this->get_stores();

                foreach ($chks as $key => $chk) {
                    $user = $this->dia_user_dao->query_by_usr_num($chk->usr_num);
                    $result_set[]=$this->__assemble_user_checkin($user, $chk, $stores[$chk->sto_num]);
                }
            }

            return $result_set;
        }

        public function find_uncheckin_store($chks) {
            if ($chks == NULL) {
                $chks = $this->find_in_progress_checkin();
            }

            $stores = $this->get_stores();
            foreach ($chks as $key => $chk) {
                // log_message("info","store:".print_r($stores,TRUE));
                unset($stores[$chk->sto_num]);
            }
            print_r($stores,TRUE);
            return $stores;
        }

        public function get_stores() {
            return $this->store_data_service->get_real_stores();
        }

        private function __assemble_user_checkin($user,$chk, $store){

            $result->chk_num=$chk->chk_num;
            $result->usr_num=$chk->usr_num;
            $result->usr_name=$user->usr_name;
            $result->chk_in_time=$chk->chk_in_time;
            $result->sto_name=$store->sto_name;
            $result->sto_num=$store->sto_num;

            return $result;
        }
    }

?>