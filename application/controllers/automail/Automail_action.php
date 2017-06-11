<?php
class Automail_action extends CI_Controller {
    function __construct()
        {
            parent::__construct();
            $this->load->library('form_validation');
            $this->load->model("automail/automail_service");
            // $this->load->model('service/store_data_service');

        }


    public function afternoon($valid, $send=FALSE){

//         $receiver = array('lijia.yeh@gmail.com', 'gpsam25@gmail.com', 'dmans1124@gmail.com');

        // $receiver = array('dmans1124@gmail.com');
    	$data = $this->automail_service->get_automail_data();
    	
        if($valid == 'fmweeije45gEEFGerr') {
            
            if ($send) {
                $this->automail_service->send_mail();
                echo 'done';
            } else {
                $this->load->view("automail/afternoon", $this->automail_service->get_automail_data());
            }
        } else {
            echo "Hello";
        }
    }
}
?>