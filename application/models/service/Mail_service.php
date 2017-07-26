<?php
    /**
     *
     */
    class Mail_service extends CI_Model {

        function __construct()
        {
            parent::__construct();
            $this->load->library('email');
        }
        
        public function send_automail($receiver, $message, $subject) {
            
            $this->email->from('Auto-Mail@bogamon.com', '古靈閣Auto-mail');
            $this->email->to($receiver);
            $this->email->subject($subject);
            $this->email->message($message);
            
            $this->email->send();
        }
    }