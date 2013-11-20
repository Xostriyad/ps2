<?php
include_once("model/Member.php");
class Members
{
	private $members;
	private $id;
	public function __construct()
	{	
	}
	public static function withID($id) 
	{
    	$instance = new self();
    	$instance->loadByID( $id );
    	return $instance;
    }
	public function getMembers()
	{
		return $this->members;
	}
	protected function loadByID( $id ) 
	{
		$this->$id = $id;
		$url="http://census.soe.com/get/ps2/outfit_member?outfit_id=".$id."&c:limit=1000&c:show=character_id&c:join=character^show:name.first'battle_rank.value'certs.earned_points'times.minutes_played";
		$response = file_get_contents($url);
		$json = json_decode($response, true);
		$this->members = array();
		foreach ($json["outfit_member_list"] as $item)
		{
			$character_id = isset($item["character_id"]) ? $item["character_id"] : "N/A";
			$name = isset($item["character_id_join_character"]["name"]["first"]) ? $item["character_id_join_character"]["name"]["first"] : "DNE";
			$battle_rank = isset($item["character_id_join_character"]["battle_rank"]["value"]) ? $item["character_id_join_character"]["battle_rank"]["value"] : 0;
			$earned_points = isset($item["character_id_join_character"]["certs"]["earned_points"]) ? $item["character_id_join_character"]["certs"]["earned_points"] : 0;
			$minutes_played = isset($item["character_id_join_character"]["times"]["minutes_played"]) ? $item["character_id_join_character"]["times"]["minutes_played"] : 0;
			$temp = new Member($name, $character_id, $battle_rank, $earned_points, $minutes_played);
			array_push($this->members, $temp);
		}
    }
}
?>