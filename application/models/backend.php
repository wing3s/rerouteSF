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

	public function getRoutes($stop1, $stop2)
	{
		return array(38,2);
	}

	public function getLoad($stop)
	{
		return 1;
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
