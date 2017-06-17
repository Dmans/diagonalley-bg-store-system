<?php
class Automail_action extends CI_Controller {
    function __construct()
        {
            parent::__construct();
            $this->load->library('form_validation');
            $this->load->model("automail/automail_service");
        }


    public function afternoon($valid, $send=FALSE){

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
    
    public function uncheckout($valid, $send=FALSE) {
        if($valid == 'fmweeije45gEEFGerr') {
            $this->automail_service->send_uncheckout_mail($send);
            echo 'Done';
        } else {
            echo "Hello";
        }
    }
}
?>