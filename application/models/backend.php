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

}
?>
