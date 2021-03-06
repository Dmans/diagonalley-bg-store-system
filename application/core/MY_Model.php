<?php 

class MY_Model extends CI_Model {
    
    protected $table_name;
    
    function __construct() {
        parent::__construct();
        $this->load->helper("dao");
        $this->table_name="";
        $this->pk="";
        $this->value_conditions = array();
        $this->string_conditions = array();
        $this->custom_value_conditions = array();
    }
    
    public function query_by_pk($pk){
        $this->db->where($this->pk, $pk);
        $query = $this->db->get($this->table_name);
        return generate_single_result($query);
    }
    
    public function query_all(){
        $query = $this->db->get($this->table_name);
        return generate_result_list($query);
    }
    
    public function insert($inset_object){
        $this->db->insert($this->table_name,$inset_object);
        return $this->db->insert_id();
    }
    
    public function update($update_object){
        $pk = $this->__find_pk($update_object);
        $this->db->where($this->pk, $pk);
        $this->db->update($this->table_name,$update_object);
    }
    
    public function delete_by_pk($pk){
        $condition = array();
        $condition[$this->pk] = $pk;
        return $query = $this->db->delete($this->table_name, $condition);
    }
    
    public function query_by_condition($condition){
        
        //step1.加入where條件
        array_push($this->value_conditions, $this->pk);
        foreach ($this->value_conditions as $field_name) {
            if(!empty($condition[$field_name])){
                $this->db->where($field_name,$condition[$field_name]);
            }
        }
        
        //step2.加入like條件
        foreach ($this->string_conditions as $field_name) {
            if(!empty($condition[$field_name])){
                $this->db->like($field_name,$condition[$field_name]);
            }
        }
        
        //step3.加入選用where條件
        foreach ($this->custom_value_conditions as $field_name) {
            if(isset($condition[$field_name]) && $condition[$field_name]!=-1){
                $this->db->where($field_name,$condition[$field_name]);
            }
        }
        
        // Handle special case query condition
        $this->special_query_conditions($condition);
        
        $query = $this->db->get($this->table_name);
        return generate_result_list($query);
    }
    
    
    protected function special_query_conditions($condition) {
        //do nothing, override this function if need add special query condition
    }
    
    
    private function __find_pk($object) {
        if (is_array($object)) {
            return $object[$this->pk];
        } else {
            $pk = $this->pk;
            return $object->$pk;
        }
    }
    
}





?>