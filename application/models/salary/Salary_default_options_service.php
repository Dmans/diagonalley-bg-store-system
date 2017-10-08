<?php
class Salary_default_options_service extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('dao/dia_salary_default_options_dao');
        
    }
    
    public function save_default_option($input) {
        return $this->dia_salary_default_options_dao->insert($input);
    }
    
    public function update_default_option($input) {
        $this->dia_salary_default_options_dao->update($input);
    }
    
    public function find_default_option_for_update($dsdo_num){
        return $this->dia_salary_default_options_dao->query_by_pk($dsdo_num);
    }
    
    public function find_default_options($input) {
        return $this->dia_salary_default_options_dao->query_by_condition($input);
    }
    
}