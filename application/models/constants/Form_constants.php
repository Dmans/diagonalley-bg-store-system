<?php
    /**
     * 
     */
    class Form_constants extends CI_Model {
        
        function __construct()
	    {
	        parent::__construct();
	    }
		
		public function transfer_usr_role($usr_role){
			switch ($usr_role) {
				case '0':
					return 'root'; 
				case '1':
					return '店長';
				case '2':
					return '員工';
				case '3':
					return '會員';
				case '4':
				    return '工讀生';
			}
			
			return NULL;
		}
		
		public function transfer_usr_status($usr_status){
			switch ($usr_status) {
				case '0':
					return '停用'; 
				case '1':
					return '啟用';
			}
			
			return NULL;
		}
		
		public function transfer_gam_sale($gam_sale){
			switch ($gam_sale) {
				case '0':
					return '否'; 
				case '1':
					return '是';
			}
			
			return NULL;
		}
		
		public function transfer_gid_status($gid_status){
			switch ($gid_status) {
				case '0':
					return '店內(未使用)'; 
				case '1':
					return '店內(使用中)';
				case '2':
					return '出租中';
			}
			
			return NULL;
		}
		
		public function transfer_gid_rentable($gid_rentable){
			switch ($gid_rentable) {
				case '0':
					return '否'; 
				case '1':
					return '是';
			}
			
			return NULL;
		}
		
		public function transfer_gid_enabled($gid_enabled){
			switch ($gid_enabled) {
				case '0':
					return '下架'; 
				case '1':
					return '上架';
			}
			
			return NULL;
		}
		
		public function transfer_act_type($act_type){
			switch ($act_type) {
				case '0':
					return '加點'; 
				case '1':
					return '扣點';
				case '2':
					return '消費';
			}
			
			return NULL;
		}
		
		public function transfer_act_status($act_status){
			switch ($act_status) {
				case '0':
					return '暫存'; 
				case '1':
					return '啟用';
				case '2':
					return '停用';
			}
			
			return NULL;
		}
		
		public function transfer_grd_type($grd_type){
			switch ($grd_type) {
				case '1':
					return '店內使用';
				case '2':
					return '出租';
			}
			
			return NULL;
		}
		
		public function transfer_ddr_status($ddr_status){
			switch ($ddr_status) {
				case '0':
					return '隱藏'; 
				case '1':
					return '顯示';
				case '2':
					return '停用';
			}
			
			return NULL;
		}
		
		public function transfer_ddr_type($ddr_type){
			switch ($ddr_type) {
				case '0':
					return '一般'; 
				case '1':
					return '置頂';
			}
			
			return NULL;
		}
		
		public function transfer_ord_status($ord_status){
			switch ($ord_status) {
				case '0':
					return '一般'; 
				case '1':
					return '預購';
				case '2':
					return '取消';
					
			}
			
			return NULL;
		}
		
		public function transfer_ord_type($ord_type){
			switch ($ord_type) {
				case '0':
					return '原價'; 
				case '1':
					return '折扣';
			}
			
			return NULL;
		}
    }
    
?>