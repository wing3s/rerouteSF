<?php
class backend extends CI_Model
{
	private $stop_location;

	public function __construct()
	{
		parent::__construct();
		$dbName	= 'reroutesf';
		$this->dbSF	= $this->load->database($dbName,TRUE,TRUE);
		$this->stop_location = $this->getStopLocation();
		return;	
	}

	public function getAllStopName()
	{
		$allStopNameArr	= array(
			'aaa',
			'bbb',
			);
		return $allStopNameArr;
	}

	public function getNearby($stop)
	{
		$stop_nearstop = array();
		foreach($this->stop_location as $stop_name => $location)
		{
			$long = $location['long'];
			$lat = $location['lat'];
			$stop_nearstop[$stop_name] = $this->getNearestStop($long, $lat);	
		}
		//print_r($stop_nearstop[$stop]);
		return $stop_nearstop[$stop];
	}

	public function getDuration($stop1, $stop2)
	{

		return 10;
	}

	public function getRoute($stop1, $stop2)
	{
		$route_arr = array();
		$numquery = "	SELECT route_num
						FROM dw_sfmta_route_stop_info
						WHERE stop_name = '$stop1'
						GROUP BY seq_stop_id
						ORDER BY seq_stop_id	";
		$rows = $this->dbRecord->query($numquery)->result_array();
		foreach($rows as $row)
		{
			$route_num = $row['route_num'];
			$stopquery = "	SELECT stop_name
							FROM dw_sfmta_route_stop_info
							WHERE route_num = $route_num
							GROUP BY seq_stop_id
							ORDER BY seq_stop_id	";
			$stoprows = $this->dbRecord->query($stopquery)->result_array();
			foreach($stoprows as $stoprow)
			{
				$stop = $stoprow['stop_name'];
				if($stop == $stop2)
					$route_arr[] = $route_num;
			}
		}
		//print_r($route_arr);
		return $route_arr;
	}

	public function getLoad($stop)
	{
		return 1;
	}

	private function getNearestStop($long, $lat)
	{	
		$dist_arr = array();
		//$stop_location = $this->getStopLocation();	
		foreach($this->stop_location as $stop_name => $stop_info)
		{
			$stop_long = $stop_info['long'];
			$stop_lat = $stop_info['lat'];

			$dist = sqrt(pow(($stop_lat - $lat),2) + pow(($stop_long - $long),2));
			$dist_arr[$stop_name] = $dist; 
		}
		asort($dist_arr,SORT_NUMERIC);
		//print_r(array_slice($dist_arr,1,4));
		return array_slice($dist_arr,1,3);
	} 

	public function getStopsBetween($stop1,$stop2)
	{
		$stopArr	= array(
			'777',
			'888',
			'999',
			);
		return;
	}
}
?>




