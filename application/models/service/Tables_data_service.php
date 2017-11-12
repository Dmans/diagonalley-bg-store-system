<?php

class tables_data_service extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model("dao/dia_store_dao");
		$this->load->model("dao/dia_tables_dao");
		$this->load->model("constants/form_constants");
		$this->load->model("dao/dia_booking_dao");
		$this->load->model("dao/dia_booking_tables_dao");
		
	}
	
	public function find_tables_list($input){
	   if(isset($input['dtb_max_cap'])){
    	    $input['dtb_cap']=$input['dtb_max_cap'];
    	    unset($input['dtb_max_cap']);
	    }
		$result = $this->dia_tables_dao->query_by_condition($input);
		return $this->__assemble_query_result_list($result);
	}
	
	private function __assemble_query_result_list($query_result){
		
		$output = array();
		if(!empty($query_result)){
			foreach ($query_result as $row) {
				$output[]=$this->__assemble_query_result($row);
			}
		}
		
		return $output;
	}
	
	private function __assemble_query_result($row){
	  log_message("debug","tables_data_service.__assemble_query_result(input=".print_r($row,TRUE).")");
	    
	  $result=$row;
		$store=$this->dia_store_dao->query_by_pk($row->sto_num);
		$result->sto_name=$store->sto_name;
		$result->dbk_status=0;
		
		$condition['sto_num'] = $row->sto_num;
		$condition['start_dbk_date']=date('Y-m-d');

		$condition['dbk_status']=1;
		$dbks=$this->dia_booking_dao->query_by_condition($condition);
		
		
 		foreach ($dbks as $dbk){
 		    $dtbs = $this->dia_booking_tables_dao->query_by_dbk_num($dbk->dbk_num);
 		    foreach($dtbs as $dtb){
 		        if($dtb->dtb_num == $row->dtb_num){
 		            $result->dbk_status=1;
  		            break;
 		        }
 		    }
 		}
		return $result;
	}
	
}


?>