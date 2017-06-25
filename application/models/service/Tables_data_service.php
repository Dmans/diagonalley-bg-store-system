<?php

class tables_data_service extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model("dao/dia_store_dao");
		$this->load->model("dao/dia_tables_dao");
		$this->load->model("constants/form_constants");
		$this->load->model("dao/dia_booking_dao");
	}
	
	public function find_tables_list($input){
		log_message("info","find_tables_list(input=".print_r($input,TRUE).") - start");
		
		$result = $this->dia_tables_dao->query_by_condition($input);
		
		log_message("info","tables_data_service.find_tables_list(input=".print_r($result,TRUE).") - start");
		
		return $this->__assemble_query_result_list($result);
	}
	
	private function __assemble_query_result_list($query_result){
		
		log_message("info","__assemble_query_result_list(input=".print_r($query_result,TRUE).") - start");
		$output = array();
		if(!empty($query_result)){
			foreach ($query_result as $row) {
				$output[]=$this->__assemble_query_result($row);
			}
		}
		log_message("info","__assemble_query_result_list(input=".print_r($output,TRUE).") - end");
		
		return $output;
	}
	
	private function __assemble_query_result($row){
		$result=new stdClass();
		$storts=array();
		$stort=$this->dia_store_dao->query_by_sto_num($row->sto_num);
		$storts=$stort->sto_name;
		
		$status=array();
		$statu=$this->dia_booking_dao->query_by_dtb_num($row->dtb_num);
		if(isset($statu)){
		   $status=$statu->dbk_status;
		}
		$result->dtb_num=$row->dtb_num;
		$result->sto_name=$storts;
		$result->dtb_name=$row->dtb_name;
		$result->dtb_status=$row->dtb_status;
		$result->dtb_max_cap=$row->dtb_max_cap;
		$result->dbk_status=$status;
		
		
		
		// Assemble user store permission
// 		$usps = $this->dia_user_store_permission_dao->query_by_usr_num($row->usr_num);
// 		$tmpusps = array();
// 		if(!empty($usps)) {
// 			foreach ($usps as $key => $usp) {
// 				$tmpusps[] = $usp->sto_num;
// 			}
// 		}
		
		
// 		$result->user_store_permission = $tmpusps;
		
		log_message("info","__assemble_query_result(input=".print_r($result,TRUE).") - end");
		return $result;
	}
}


?>