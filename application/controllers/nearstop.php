<?php

class nearstop extends CI_Controller
{
        public function __construct()
        {
                parent::__construct();
                //$this->checkLogin();
                date_default_timezone_set('America/Los_Angeles');
                $this->load->model('nearstopmodel','nearstopmodel');
        }

        public function index()
        {
                $data = array();
        }

        public function test()
        {
                $this->nearstopmodel->test();
        }
}

?>
