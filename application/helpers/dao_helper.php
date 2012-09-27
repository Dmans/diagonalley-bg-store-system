<?

function generate_result_set($query_result){
	$result_set = array();
	if($query_result->num_rows()>0){
		foreach ($query_result->result() as $row) {
			$result_set[] = $row;
		}
	}
	if(count($result_set)==0){
		return NULL;
	}
	
	if(count($result_set)==1){
		return $result_set[0];
	}
	
	return $result_set;
}

?>