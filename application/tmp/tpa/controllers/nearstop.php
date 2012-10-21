<?php

require APPPATH . 'controllers/report/report.php';

class nearstop extends report
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
                $this->load->view('view', $data);
        }

        public function test()
        {
                $this->nearstopmodel->test();
        }
}

?>
