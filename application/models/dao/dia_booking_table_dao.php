<?php
    /**
     * dia_booking_table table data access object
     */
    class Dia_booking_table_dao extends CI_Model {

        private $table_name;

        function __construct()
        {

            // Call the Model constructor
            parent::__construct();
            $this->load->helper("dao");
            $this->table_name="dia_booking_table";
        }

        public function query_all(){
            $query = $this->db->get($this->table_name);
            return generate_result_list($query);
        }

        public function query_by_dbt_num($dbt_num){
            $this->db->where('dbt_num',$dbt_num);
            $query = $this->db->get($this->table_name);
            return generate_single_result($query);
        }

        public function query_by_dbk_num($dbk_num){
            $this->db->where('dbk_num',$dbk_num);
            $query = $this->db->get($this->table_name);
            return generate_single_result($query);
        }

        public function insert($dbt){
            $this->db->insert($this->table_name,$dbt);
            return $this->db->insert_id();
        }

        public function update($dbt){
            $this->db->where("dbt_num",$dbt->dbt_num);
            $this->db->update($this->table_name,$dbt);
        }

        public function query_by_condition($condition){

            //step1.加入where條件
            $value_conditions=array("dbt_num");
            foreach ($value_conditions as $field_name) {
                if(!empty($condition[$field_name])){
                    $this->db->where($field_name,$condition[$field_name]);
                }
            }

            //step2.加入like條件
            // $string_conditions=array("gam_cname","gam_ename");
            // foreach ($string_conditions as $field_name) {
                // if(!empty($condition[$field_name])){
                    // $this->db->like($field_name,$condition[$field_name]);
                // }
            // }

            //step3.加入選用where條件
            $custom_value_conditions=array("dbk_num");
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