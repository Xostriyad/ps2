<?php

class Member {

	public $name;
	public $id;
	public $battle_rank;
	public $earned_points;
	public $minutes_played;
	public $avg_cpm;
	
	public function __construct($name, $id, $battle_rank, $earned_points, $minutes_played)  
    {  
        $this->name = $name;
	    $this->id = $id;
		$this->battle_rank = $battle_rank;
		$this->earned_points = $earned_points;
		$this->minutes_played = $minutes_played;
		if($minutes_played >= 1)
		{
			$this->avg_cpm = $earned_points/$minutes_played;
		}
		else
		{
			$this->avg_cpm = 0;
		}
    } 
}

?>