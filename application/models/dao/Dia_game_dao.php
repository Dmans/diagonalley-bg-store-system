<?php
    /**
     * dia_game table data access object
     */
    class Dia_game_dao extends MY_Model {
        
        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_game"; // Table name
            $this->pk="gam_num"; // Primary key
            $this->string_conditions = array("gam_cname","gam_ename"); // Field for "LIKE" criteria
            $this->custom_value_conditions= array("gam_type","gam_status","gam_sale"); // Field for full text criteria
        }
        
        public function query_by_gam_ename($gam_ename){
            $condition['gam_ename']=$gam_ename;
            return $this->query_by_condition($condition);
        }
        
        public function query_by_gam_cname($gam_cname){
            $condition['gam_cname']=$gam_cname;
            return $this->query_by_condition($condition);
        }
        
        protected function special_query_conditions($condition) {
            if(isset($condition["order_gam_ename"]) && $condition["order_gam_ename"]==TRUE){
                $this->db->order_by("gam_ename",$condition["order_gam_ename"]);
            }
            
            if(isset($condition["gam_storage"]) && $condition["gam_storage"]!=-1){
                if($condition["gam_storage"]==999){
                    $this->db->where("gam_storage > ","0");
                }else{
                    $this->db->where("gam_storage",$condition["gam_storage"]);
                }
            }
        }
    }
    
?>