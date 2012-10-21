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
		$time		= time();	
	
		$halfHour	= date("G",$time)*2;
		$halfHour	+= (date("i",$time)>30)?1:0; 
		$routes		= array();
		foreach($startArr as $stop1)
		{
			foreach($endArr as $stop2)
			{
				$routeNums	= $this->backend->getRoutes($stop1,$stop2);
				foreach($routeNums as $routeNum)
				{
					$duration	= $this->backend->getDuration($routeNum,$stop1,$stop2);
					$load		= $this->backend->getLoad($halfHour,$stop1);
					$routes[]	= array(
					'routeNum'	=> $routeNum,
					'duration'	=> $duration,
					'load'		=> $load,
					);
				}
			}
		}	
		$data['routes']		= $routes;
		$this->load->view('routeinfo',$data);
		return;
	}

}
?>
