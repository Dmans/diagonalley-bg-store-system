<?php
/**
 *
 */
class user_data_service extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model("dao/dia_user_dao");
		$this->load->model("dao/dia_user_store_permission_dao");
		$this->load->model("constants/form_constants");
	}
	
	public function save_user($input){
		$usr_num = $this->dia_user_dao->insert($this->__assemble_save_user($input));
		
		if(!empty($input['sto_nums'])) {
			$this->save_user_store_permission($usr_num, $input['sto_nums']);
		}
		
		return $usr_num;
	}
	
	public function update_user($input){
		
		$this->dia_user_dao->update($this->__assemble_update_user($input));
		
		if(!empty($input['sto_nums'])) {
			$this->save_user_store_permission($input['usr_num'], $input['sto_nums']);
		}
		
		//Update user session if update data have the same usr_num
		$user = $this->session->user;
		if (!empty($user) and $user->usr_num == $input['usr_num']) {
			$this->session->user = $this->dia_user_dao->query_by_usr_num($user->usr_num);
		}
	}
	
	public function find_users_list($input){
		return $this->__assemble_query_result_list($this->dia_user_dao->query_by_condition($input));
	}
	
	public function find_user($usr_num){
		return $this->__assemble_query_result($this->dia_user_dao->query_by_usr_num($usr_num));
	}
	
	public function save_user_store_permission($usr_num, $sto_nums) {
		$this->dia_user_store_permission_dao->delete_by_usr_num($usr_num);
		
		foreach ($sto_nums as $sto_num) {
			$usp = array();
			$usp['usr_num'] = $usr_num;
			$usp['sto_num'] = $sto_num;
			$this->dia_user_store_permission_dao->insert($usp);
		}
	}
	
	private function __assemble_save_user($input){
		$user = new stdClass();
		$user->usr_id=$input['usr_id'];
		$user->usr_passwd = sha1($input['usr_passwd']);
		$user->usr_name = $input['usr_name'];
		$user->usr_role = $input['usr_role'];
		$user->usr_status = 1; //預設:啟用(1)
		$user->usr_error_login=0; //預設:登入錯誤0次
		$user->register_date = date('Y-m-d H:i:s');
		$user->usr_mail = $input['usr_mail'];
		
		if(isset($input['usr_memo'])){
			$user->usr_memo = $input['usr_memo'];
		}
		
		
		return $user;
	}
	
	private function __assemble_update_user($input){
		
		$session_user = $this->session->userdata('user');
		
		$user = new stdClass();
		$user->usr_num=$input['usr_num'];
		
		if(isset($input['usr_name'])){
			$user->usr_name = $input['usr_name'];
		}
		
		if(isset($input['usr_role']) and $session_user->usr_role == 0){
			$user->usr_role = $input['usr_role'];
		}
		
		if(isset($input['usr_status'])){
			$user->usr_status = $input['usr_status'];
		}
		
		if(isset($input['usr_passwd'])){
			$user->usr_passwd = $input['usr_passwd'];
		}
		
		if(isset($input['usr_error_login'])){
			$user->usr_error_login = $input['usr_error_login'];
		}
		
		if(isset($input['usr_memo'])){
			$user->usr_memo = $input['usr_memo'];
		}
		if(isset($input['usr_mail'])){
			$user->usr_mail = $input['usr_mail'];
		}
		
		if(isset($input['usr_salary']) and $session_user->usr_role <= 1){
		    $user->usr_salary= $input['usr_salary'];
		}
		
		
		return $user;
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
		
		$new_result = $row;
		$new_result->usr_role_desc=$this->form_constants->transfer_usr_role($new_result->usr_role);
		$new_result->usr_status_desc=$this->form_constants->transfer_usr_status($new_result->usr_status);
		$new_result->usr_memo=(isset($new_result->usr_memo))?$new_result->usr_memo:"";
		
		// For security remove password
		unset($new_result->usr_passwd);
		
		// Assemble user store permission
		$usps = $this->dia_user_store_permission_dao->query_by_usr_num($row->usr_num);
		$tmpusps = array();
		if(!empty($usps)) {
			foreach ($usps as $key => $usp) {
				$tmpusps[] = $usp->sto_num;
			}
		}
		
		$new_result->user_store_permission = $tmpusps;
		
		return $new_result;
	}
}

?>