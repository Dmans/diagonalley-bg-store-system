<?php
    /**
     * dia_salary table data access object
     */
    class Dia_salary_dao extends CI_Model {
        
        private $table_name;
        
        function __construct()
        {
            
            // Call the Model constructor
            parent::__construct();
            $this->load->helper("dao");
            $this->table_name="dia_salary";
            $this->pk="say_num";
        }
        
        public function query_all(){
            $query = $this->db->get($this->table_name);
            return generate_result_list($query);
        }
        
        public function query_by_say_num($pk){
            $this->db->where($this->pk, $pk);
            $query = $this->db->get($this->table_name);
            return generate_single_result($query);
        }
        
        public function query_by_usr_num($usr_num){
            $condition['usr_num']=$usr_num;
            return $this->query_by_condition($condition);
        }
        
        public function query_by_say_month($say_month) {
            $condition['say_month']=$say_month;
            return $this->query_by_condition($condition);
        }
        
        public function insert($inset_object) {
            $this->db->insert($this->table_name,$inset_object);
            return $this->db->insert_id();
        }
        
        public function update($update_object) {
            $pk = $this->pk;
            $this->db->where($pk,$update_object->$pk);
            $this->db->update($this->table_name,$update_object);
        }
        
        public function delete_by_say_month($say_month) {
            $condition['say_month']=$say_month;
            return $query = $this->db->delete($this->table_name, $condition);
        }
        
        public function query_by_condition($condition){
            
            //step1.加入where條件
            $value_conditions=array($this->pk);
            foreach ($value_conditions as $field_name) {
                if(!empty($condition[$field_name])){
                    $this->db->where($field_name,$condition[$field_name]);
                }
            }
            
            //step2.加入like條件
//             $string_conditions=array("dbk_name","dbk_phone","dbk_memo");
//             foreach ($string_conditions as $field_name) {
//                 if(!empty($condition[$field_name])){
//                     $this->db->like($field_name,$condition[$field_name]);
//                 }
//             }
            
            //step3.加入選用where條件
            $custom_value_conditions=array("usr_num","say_month");
            foreach ($custom_value_conditions as $field_name) {
                if(isset($condition[$field_name]) && $condition[$field_name]!=-1){
                    $this->db->where($field_name,$condition[$field_name]);
                }
            }
            
            $query = $this->db->get($this->table_name);
            return generate_result_list($query);
        }
    }
    
?>