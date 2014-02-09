<?php
include_once("../model/CertTree/Member.php");
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
	protected function fillMembers( $id )
	{
		include("../model/Shared/dbconnect.php");
		$stmt = $dbh->prepare("
		INSERT INTO members (outfit_id, character_id, name) 
		VALUES (:outfit_id, :character_id, :name)
		");
		$stmt->bindParam(':outfit_id', $outfit_id);
		$stmt->bindParam(':character_id', $character_id);
		$stmt->bindParam(':name', $name);
		
		foreach ($this->members as $member)
		{
			$outfit_id = $id;
			$character_id = $member->id;
			$name = $member->name;
			$stmt->execute();
		}
	}
	protected function loadByID( $id ) 
	{
		$this->$id = $id;
		$url="http://census.soe.com/s:vco/get/ps2/outfit_member?outfit_id=".$id."&c:limit=1000&c:show=character_id&c:join=character^show:name.first'battle_rank.value'certs.earned_points'times.minutes_played'times.last_login_date";
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
			$last_login_date = isset($item["character_id_join_character"]["times"]["last_login_date"]) ? $item["character_id_join_character"]["times"]["last_login_date"] : 0;
			$temp = new Member($name, $character_id, $battle_rank, $earned_points, $minutes_played, $last_login_date);
			if($battle_rank != 0) //easier to filter this here than the API. BR 0 are people who are bugs.
			{
				array_push($this->members, $temp);
			}
		}
		$this->fillMembers($id);
		
    }
	
}
?>