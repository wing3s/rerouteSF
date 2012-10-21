<?php

class nearstopmodel extends CI_Model
{
        public function __construct()
        {
                date_default_timezone_set('America/Los_Angeles');
                return;
        }

	public function getNearestStop($lan, $long, $stop_arr)
	{
		$dist_arr = array();
		
		foreach($stop_arr as $stop_id => $stop_info)
		{
			//$stop_id = $stop_info['stop_id'];
			$stop_lan = $stop_info['lan'];
			$stop_long = $stop_info['long'];

			$dist = sqrt(pow(($stop_lan - $lan),2) + pow(($stop_long - $long),2));
			$dist_arr[$stop_id] = $dist; 
		}
		asort($dist_arr,SORT_NUMERIC);
		print_r(array_slice($dist_arr,0,3));
		return array_slice($dist_arr,0,3);
	} 

	public function test()
	{
		$lan = 0;
		$long = 0;
		$stop_arr = array();
		$stop_arr[0] = array('lan' => 4, 'long'=> 4,);
		$stop_arr[1] = array('lan' => -3, 'long'=> -3,);
		$stop_arr[2] = array('lan' => 2, 'long'=> 2,);
		$stop_arr[3] = array('lan' => -1, 'long'=> -1,);
		
		print_r($stop_arr);
		$result = $this->getNearestStop($lan, $long, $stop_arr);	
	}
}

?>
