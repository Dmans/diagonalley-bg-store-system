<?php 

class Calendar_service extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('dao/dia_calendar_dao');
        $this->load->model("constants/form_constants");
    }
    
    public function save_calendar($input) {
        return $this->dia_calendar_dao->insert($input);
    }
    
    public function find_calendar_for_update($cal_num) {
        return $this->dia_calendar_dao->query_by_pk($cal_num);
    }
    
    public function update_calendar($input) {
        return $this->dia_calendar_dao->update($input);
    }
    
    public function find_calendar($input) {
        return object_sorter($this->dia_calendar_dao->query_by_condition($input), "cal_date");
    }
    
    public function remove_calendar($cal_num) {
        return $this->dia_calendar_dao->delete_by_pk($cal_num);
    }
}





?>