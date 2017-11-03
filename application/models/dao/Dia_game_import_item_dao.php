<?php
    /**
     * dia_game_import_item table data access object
     */
    class Dia_game_import_item_dao extends MY_Model {
        
        function __construct() {
            // Call the Model constructor
            parent::__construct();
            $this->table_name="dia_game_import_item"; // Table name
            $this->pk="gii_num"; // Primary key
            $this->value_conditions = array("gam_num", "gim_num");
            $this->string_conditions = array("gii_source"); // Field for "LIKE" criteria
            $this->custom_value_conditions= array("gii_ivalue", "gii_imp_cvalue", "gii_old_cvalue", "gii_new_cvalue"); // Field for full text criteria
        }
        
        public function query_by_gam_num($gam_num){
            $condition['gam_num']=$gam_num;
            return $this->query_by_condition($condition);
        }
        
        public function query_by_gim_num($gim_num){
            $condition['gim_num']=$gim_num;
            return $this->query_by_condition($condition);
        }
    }
    
?>