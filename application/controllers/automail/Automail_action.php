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

        $receiver = array('lijia.yeh@gmail.com', 'gpsam25@gmail.com', 'dmans1124@gmail.com');

        // $receiver = array('dmans1124@gmail.com');

        if($valid == 'fmweeije45gEEFGerr') {
            $data['chks'] = $this->automail_service->find_in_progress_checkin();
            $data['uncheckin_store'] = $this->automail_service->find_uncheckin_store($data['chks']);
            if ($send) {

                if (count($data['uncheckin_store']) > 0) {
                    $this->send_mail($receiver, $data, '本日店鋪無人打卡警示');
                }
                echo 'done';
            } else {
                $this->load->view("automail/afternoon", $data);
            }
        } else {
            echo "Hello";
        }
    }

    private function get_uncheckin_store($chks) {

    }

    private function send_mail($receiver, $data, $subject) {
        $this->load->library('email');

        $this->email->from('Auto-Mail@bogamon.com', '古靈閣Auto-mail');
        $this->email->to($receiver);

        $this->email->subject($subject);
        $this->email->message($this->load->view("automail/afternoon", $data, TRUE));

        $this->email->send();

        // echo $this->email->print_debugger();
    }


    // public function _message($to = 'World')
    // {
        // echo "Hello {$to}!".PHP_EOL;
//
//
        // $data['stores']=$this->store_data_service->get_stores();
        // echo ''.print_r($data['stores'][2]);
    // }
}
?>