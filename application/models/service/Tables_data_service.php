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
		log_message("debug","find_tables_list(input=".print_r($input,TRUE).") - start");
		
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
	    $result=$row;
	    
		$store=$this->dia_store_dao->query_by_pk($row->sto_num);
		$result->sto_name=$store->sto_name;
		
		
		
		
		
		
		
		$condition['start_dbk_date']=date('Y-m-d');
// 		$condition['dtb_num']=$row->dtb_num;
		$condition['dbk_status']=1;
		$status=$this->dia_booking_dao->query_by_condition($condition);
		log_message("info","__assemble_query_result(status=".print_r($status,TRUE).") - end");
		if(count($status)>0){
		    $result->dbk_status=1;
		}
		else {
		    $result->dbk_status=NULL;
		}
		
		
		
		log_message("info","__assemble_query_result(input=".print_r($result,TRUE).") - end");
		return $result;
	}
}


?>