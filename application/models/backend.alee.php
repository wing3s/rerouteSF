<?php
class backend extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $dbName    = 'reroutesf';
        $this->dbSF    = $this->load->database($dbName,TRUE,TRUE);
        return;    
    }

    public function getAllStopName()
    {
        $allStopNameArr    = array(
            'aaa',
            'bbb',
            );
        return $allStopNameArr;
    }

    public function getNearby($stop)
    {
        $stopArr    = array(
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

    public function getLoad($halfhour_of_day, $stop)
    {
         $loadarray = array();
         $max_boundary = $halfhour_of_day / 2 + 2;
         $min_boundary = $halfhour_of_day / 2 - 2;
         $sql = "SELECT AVG(current_psgr_load) avg_curr_psgr_load, AVG(psgr_load_idx) as avg_psgr_load_idx, AVG(seat_load_idx) as avg_seat_load_idx FROM sfmta_bus_load_matrix WHERE stop_name = '" . $stop . "'AND halfhour_of_day >= ".$min_boundary ." AND halfhour_of_day <= ".$max_boundary." GROUP BY stop_name";
         $result = $this->dbSF->query($sql)->result_array();
         foreach($result as $row)
         {
             $loadarray[$row['avg_curr_psgr_load']] = $row['avg_curr_psgr_load'];
             $loadarray[$row['avg_psgr_load_idx']] = $row['avg_psgr_load_idx'];
             $loadarray[$row['avg_seat_load_idx']] = $row['avg_seat_load_idx'];
         }     
        return $loadarray;
    }

    public function getStopsBetween($stop1,$stop2)
    {
        $stopArr    = array(
            '777',
            '888',
            '999',
            );
        return;
    }
}
?>




