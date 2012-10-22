<?php
class backend extends CI_Model
{
	private $stop_location;

	public function __construct()
	{
		parent::__construct();
		$dbName = 'reroutesf';
		$this->dbSF     = $this->load->database($dbName,TRUE,TRUE);
		$this->stop_location = $this->getStopLocation();
		return;
	}

	public function getAllStopName()
	{
		$allStopNameArr = array();

		$sql = "SELECT DISTINCT stop_name
			FROM dw_sfmta_bus_load_matrix";
		//	echo "sql=$sql";
		//echo "\n";

		$result = $this->dbSF->query($sql)->result_array();
		foreach($result as $row) {
			array_push($allStopNameArr, $row['stop_name']);
		}

		return $allStopNameArr;
	}	

	public function getStopLocation()
	{
		$stop_location = array();
		$sqlquery = " SELECT * FROM dw_sfmta_bus_location";
		$rows = $this->dbSF->query($sqlquery)->result_array();
		foreach($rows as $row)
		{
			$stop_location[$row['stop_name']] = array(      'long' => $row['longitude'],
					'lat'  => $row['latitude'],);
		}
		//print_r($stop_location);
		return $stop_location;
	}

	public function getNearby($stop)
	{
		$stops	= $this->getAllStopName();
		return array("PRESIDIO AVE&CLAY ST SE-NS/P",
					"FILLMORE ST&PINE ST NE-FS/BZ");
	//	return array('SUTTER ST&SANSOME ST NW-FS/B', 'SUTTER ST&SANSOME ST NW- - EOL');
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

	public function getRoutes($stop1, $stop2)
	{
		$route_arr = array();
		$numquery = "   SELECT route_num
			FROM dw_sfmta_route_stop_info
			WHERE stop_name = '$stop1'
			GROUP BY seq_stop_id
			ORDER BY seq_stop_id    ";
		$rows = $this->dbSF->query($numquery)->result_array();
		foreach($rows as $row)
		{
			$route_num = $row['route_num'];
			$stopquery = "  SELECT stop_name
				FROM dw_sfmta_route_stop_info
				WHERE route_num = $route_num
				GROUP BY seq_stop_id
				ORDER BY seq_stop_id    ";
			$stoprows = $this->dbSF->query($stopquery)->result_array();
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

	public function getLoad( $stop,$hour,$min)
	{
		if($min >= 30) {
			$halfHourAdjust = 1;
		} else {
			$halfHourAdjust = 0;
		}
		$halfhour_of_day = $hour * 2 + $halfHourAdjust;
	
		$loadarray = array();
		$max_boundary = $halfhour_of_day / 2 + 2;
		$min_boundary = $halfhour_of_day / 2 - 2;
		$sql = "SELECT AVG(current_psgr_load) avg_curr_psgr_load, AVG(psgr_load_idx) as avg_psgr_load_idx, AVG(seat_load_idx) as avg_seat_load_idx FROM dw_sfmta_bus_load_matrix WHERE stop_name = '" . $stop . "'AND halfhour_of_day >= ".$min_boundary ." AND halfhour_of_day <= ".$max_boundary." GROUP BY stop_name";

		$result = $this->dbSF->query($sql)->result_array();
		foreach($result as $row)
		{
			$loadarray[$row['avg_curr_psgr_load']] = $row['avg_curr_psgr_load'];
			$loadarray[$row['avg_psgr_load_idx']] = $row['avg_psgr_load_idx'];
			$loadarray[$row['avg_seat_load_idx']] = $row['avg_seat_load_idx'];
		
			if($row)
			{
				return $row['avg_psgr_load_idx'];
			} else {
				return "0.7";
			}
		}
	}

	public function getTimeTakeBetweenStops($stop1, $stop2, $routeNum, $hour, $min)
	{
		if($min >= 30) {
			$halfHourAdjust = 1;
		} else {
			$halfHourAdjust = 0;
		}
		$halfhourOfDay = $hour * 2 + $halfHourAdjust;
		//echo "halfhourOfDay = $halfhourOfDay\n";

		$startTimestamp = 0;
		$endTimestamp = 0;


		$sql = "SELECT *
			FROM dw_sfmta_bus_load_matrix
			WHERE route_num = $routeNum
			AND day_of_week = 1
			";
		//echo "sql=$sql";
		//echo "\n";

		$result = $this->dbSF->query($sql)->result_array();
		$count = 0;
		$indexToStart = 0;
		$previousRecordSeqStopID = 0;
		foreach($result as $row) {
			$count++;
			//if($row['seq_stop_id'] < $previousRecordSeqStopID) {
			if($row['seq_stop_id'] == 1 && $row['halfhour_of_day'] == $halfhourOfDay) {
				$indexToStart = $count;
				//echo "indexToStart = $indexToStart, stop_name = " . $row['stop_name'] . ", time = " . $row['time'] . "\n";
				break;
			}
			$previousRecordSeqStopID = $row['seq_stop_id'];
		}

		$result2 = $this->dbSF->query($sql)->result_array();
		$count = 0;
		foreach($result2 as $row) {
			$count++;
			if($count < $indexToStart) {
				continue;
			}
			if($row['stop_name'] == $stop1) {
				$startTimestamp = $row['timestamp'];
				//echo "startTimestamp = " . $startTimestamp . "\n";
			}
			if($row['stop_name'] == $stop2) {
				$endTimestamp = $row['timestamp'];
				//echo "endTimestamp = " . $endTimestamp . "\n";
				break;
			}
		}

		$timetakes = ( $endTimestamp - $startTimestamp ) / 1000;

		return $timetakes;
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
			//print_r(array_slice($dist_arr,1,3));
			return array_keys(array_slice($dist_arr,1,3));
		}

	}
	?>

