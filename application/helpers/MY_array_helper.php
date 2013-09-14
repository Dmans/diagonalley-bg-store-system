<?php

function object_sorter($data,$key_name) {
	
	
	foreach ($data as $key => $row) {
	    $key_names[$key]  = $row->$key_name;
	    // $edition[$key] = $row['edition'];
	}
	
	// Sort the data with volume descending, edition ascending
	// Add $data as the last parameter, to sort by the common key
	array_multisort($key_names, SORT_STRING , $data);
	
	return $data;
		
	// log_message("info","key".$key);
// 	
	// return strnatcmp($a->$key, $b->$key);
	
	
	
	// return function ($a, $b) use ($key,$isCaseSencitive) {
    	// if($isCaseSencitive){
    		// return strnatcmp($a->$key, $b->$key);	
    	// }else{
    		// return strcasecmp($a->$key, $b->$key);
    	// }	
//     	
	// };
}

// function array_sorter($key,$isCaseSensitive) {
	// return function ($a, $b) use ($key,$isCaseSencitive) {
		// if($isCaseSencitive){
			// return strnatcmp($a[$key], $b[$key]);	
		// }else{
			// return strcasecmp($a[$key], $b[$key]);
		// }	
// 	
	// };
// }


?>