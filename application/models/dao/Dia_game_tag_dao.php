<?php
    /**
     * dia_game_tag table data access object
     */
    class Dia_game_tag_dao extends MY_Model {
        
        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_game_tag"; // Table name
            $this->pk="dgt_num"; // Primary key
            $this->string_conditions = array(); // Field for "LIKE" criteria
            $this->custom_value_conditions= array("tag_num","gam_num"); // Field for full text criteria
        }
        
        public function query_by_tag_num($tag_num){
            $condition['tag_num']=$tag_num;
            return $this->query_by_condition($condition);
        }
        
        public function query_by_gam_num($gam_num){
            $condition['gam_num']=$gam_num;
            return $this->query_by_condition($condition);
        }
        
        public function delete_by_tag_num($tag_num){
            $this->db->where("tag_num",$tag_num);
            $this->db->delete($this->table_name);
        }
        
        public function delete_by_gam_num($gam_num){
            $this->db->where("gam_num",$gam_num);
            $this->db->delete($this->table_name);
        }
    }
    
?>