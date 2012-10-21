<?php
class googlemap extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->mapURL		= "http://maps.googleapis.com/maps/api/staticmap?";
		$this->mapSetting	= array(
				'center'	=> 'San Francisco',
				'size'		=> '300x640',
				'maptype'	=> 'terrain',
				'sensor'	=> 'false',
				);
		$this->mapSeperator	= '%7C';
		$this->pathColor	= '0x0000ff';
		$this->pathWeight	= '5';
		return;
	}

	public function plotBusRoute()
	{
		$stopsArr	= array(
			'stop1'	=> array(37.791982,-122.408037),
			'stop2'	=> array(37.725571,-122.394272),
			'stop3'	=> array(37.783537,-122.415641),
			);
		$stopStr	= '';
		$stopCount	= 1;
		foreach($stopsArr as $stopName=>$stopLoc)
		{
			if($stopCount == 1)
			{
				$stopColor	= 'green';
				$stopLabel	= 'S';
			}	elseif ($stopCount == count($stopsArr)) {
				$stopColor	= 'green';
				$stopLabel	= 'E';
			}	else {
				$stopColor	= 'blue';
				$stopLabel	= ''; 
			}
			$stopInfoArr	= array(
				"markers=color:$stopColor",
				"label:$stopLabel",
				implode(',',$stopLoc)
				);
			$stopInfoStr	= implode($this->mapSeperator,$stopInfoArr); 
			$allstopsInfoArr[]	= $stopInfoStr;
			$pathArr[]			= implode(',',$stopLoc);
			$stopCount++;
		}
		$pathInfoArr	= array(
				"path=color:$this->pathColor",
				"weight:$this->pathWeight");
		$allPathInfoArr	= array_merge($pathInfoArr , $pathArr);
		$pathStr	= implode($this->mapSeperator,$allPathInfoArr);

		$mapRoute			= $this->mapURL .
								http_build_query($this->mapSetting,'','&'). '&'.
								implode('&',$allstopsInfoArr) . '&'.
								$pathStr;
		$data['resultRouteMap']	= $mapRoute;
		$this->load->view('map',$data);	
		return;
	}

	public function getStopLocation($stopID)
	{
		$stopLocation	= array(
			'stopID'	=> 3335,
			'lon'		=> 99.9,
			'lat'		=> 38,
			);
		return $stopLocation;
	}

}
?>
