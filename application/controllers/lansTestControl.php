<?php
class lansTestControl extends  CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('backend','backend');
		$this->load->model('backend_lans','backend_lans');
		
		return;
	}	

	public function index()
	{
		$allStopName	= $this->backend->getAllStopName();

		$data['allStopName']	= $allStopName;
		$this->load->view('mainpage',$data);
		return;
	}

	public function test1() {
		$stop1 = 'BEALEMST & HOWARD ST W-FS/SI';
		$stop2 = 'MARKET ST&SANSOME ST W-FS/BZ';
		
		$aaa = $this->backend_lans->getTimeTakeBetweenStops($stop1, $stop2, 38, 1, 43);
		echo $aaa;
	}

	public function showRoutes($startStop,$endStop)
	{
		$startArr	= $this->backend->getNearby($startStop);	
		$endArr		= $this->backend->getNearby($endStop);
		
		$routes		= array();
		foreach($startArr as $stop1)
		{
			foreach($endArr as $stop2)
			{
				$routeNums	= $this->backend->getRoutes($stop1,$stop2);
				foreach($routeNums as $routeNum)
				{
					$duration	= $this->backend->getDuration($routeNum,$stop1,$stop2);
					$load		= $this->backend->getLoad($stop1);
					$routes[]	= array(
					'routeNum'	=> $routeNum,
					'duration'	=> $duration,
					'load'		=> $load
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
