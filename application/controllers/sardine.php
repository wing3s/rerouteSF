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
	
	public function getData()	
	{
		$form= $this->input->post();
		$startStop = $form['startStop'];
		$endStop = $form['endStop'];
		$this->showRoutes($startStop,$endStop);
		
	}

	public function showRoutes($startStop,$endStop)
	{
		$startArr	= $this->backend->getNearby($startStop);	
		$endArr		= $this->backend->getNearby($endStop);
		$hour 		= date('H');
		$min		= date('i');
		//print_r($startArr);
		//print_r($endArr);
		//exit;
		
		$routes		= array();
		foreach($startArr as $stop1)
		{
			foreach($endArr as $stop2)
			{
				$routeNums	= $this->backend->getRoutes($stop1,$stop2);
				foreach($routeNums as $routeNum)
				{
					$duration	= $this->backend->getTimeTakeBetweenStops($stop1, $stop2, $routeNum, $hour, $min);
					$load		= $this->backend->getLoad($stop1,$hour,$min);
					$routes[]	= array(
					'startStop'	=> $stop1,
					'endStop'	=> $stop2,
					'routeNum'	=> $routeNum,
					'duration'	=> $duration,
					'load'		=> $load
					);
				}
			}
		}	
		$data['routes']		= $routes;
	//	print_r($data);
		$this->load->view('routeinfo',$data);
		return;
	}

	public function test()
	{
		$startStop = 'PRESIDIO AVE&CLAY ST SE-NS/P';
		$endStop = 'FILLMORE ST&PINE ST NE-FS/BZ'; 
		
		$this->showRoutes($startStop,$endStop);
		//echo 'test';
		//$this->backend->getNearby('SUTTER ST&LARKIN ST NW-FS/BZ');
		//$this->backend->getRoute($startStop, $endStop);
	}

}
?>
