<?php
class backend extends CI_Model
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

	public function getTimeTakeBetweenStops($stop1, $stop2, $routeNum)
	{
		$startTimestamp;
		$endTimestamp;		


		$sql = "SELECT *
			FROM dw_sfmta_bus_load_matrix
			WHERE route_num = $routeNum 
			AND day_of_week = 1";
		
		$result = $this->dbBI->query($sql)->result_array();
		$count = 0;
		$indexToStart = 0;
		$previousRecordSeqStopSeq = 0;
		foreach($result as $row) {
			$count++;
			if($row->seq_stop_id < $previousRecordSeqStopID) {
				$indexToStart = $count;
			}
			$previousRecordSeqStopID = $row->seq_stop_id;
		}
		
		$result2 = $this->dbBI->query($sql)->result_array();
		$count = 0;
		foreach($result2 as $row) {
			$count++;
			if($count < $indexToStart) {
				continue;
			}
			if($row->stop_name == $stop1) {
				$startTimestamp = $row->timestamp;
			}
			if($row->stop_name == $stop2) {
				$endTimestamp = $row->timestamp;
				break;
			}
		}

		$timetakes = ( $endTimestamp - $startTimestamp ) / 1000;

		return $timetakes;
	}
}
?>




