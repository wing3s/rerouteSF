<?php
class backend_lans extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$dbName	= 'reroutesf';
		$this->dbSF	= $this->load->database($dbName,TRUE,TRUE);
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
		$stopArr	= array(
			'111',
			'222',
			'333',
			);
		return $stopArr;
	}

	public function getDuration($stop1, $stop2)
	{

		return 10;
	}

	public function getRoute($stop1, $stop2)
	{
		return 38;
	}

	public function getLoad($stop)
	{
		return 1;
	}

	public function getTimeTakeBetweenStops($stop1, $stop2, $routeNum, $hour, $min)
	{
		if($min >= 30) {
			$halfHourAdjust = 1;
		} else {
			$halfHourAdjust = 0;
		}
		$halfhourOfDay = $hour * 2 + $halfHourAdjust;
		echo "halfhourOfDay = $halfhourOfDay\n";

		$startTimestamp = 0;
		$endTimestamp = 0;		


		$sql = "SELECT *
			FROM dw_sfmta_bus_load_matrix
			WHERE route_num = $routeNum 
			AND day_of_week = 1
			";
		echo "sql=$sql";
		echo "\n";
		
		$result = $this->dbSF->query($sql)->result_array();
		$count = 0;
		$indexToStart = 0;
		$previousRecordSeqStopID = 0;
		foreach($result as $row) {
			$count++;
			//if($row['seq_stop_id'] < $previousRecordSeqStopID) {
			if($row['seq_stop_id'] == 1 && $row['halfhour_of_day'] == $halfhourOfDay) {
				$indexToStart = $count;
				echo "indexToStart = $indexToStart, stop_name = " . $row['stop_name'] . ", time = " . $row['time'] . "\n";
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
				echo "startTimestamp = " . $startTimestamp . "\n";
			}
			if($row['stop_name'] == $stop2) {
				$endTimestamp = $row['timestamp'];
				echo "endTimestamp = " . $endTimestamp . "\n";
				break;
			}
		}

		$timetakes = ( $endTimestamp - $startTimestamp ) / 1000;

		return $timetakes;
	}
}
?>




