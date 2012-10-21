<?php
class sardine extends  CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('backend','backend');
		return;
	}	

	public function index()
	{
		$allStopName	= $this->backend->getAllStopName();

		$data['allStopName']	= $allStopName;
		$this->load->view('mainpage',$data);
		return;
	}

	public function showRoutes($startStop,$endStop)
	{
		$startArr	= $this->backend->getNearby($startStop);	
		$endArr		= $this->backend->getNearby($endStop);
		
			

	}

}
?>
