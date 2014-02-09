<?php
$pathToRoot = '../';

class Controller 
{
	public function __construct()  
    {
	
	}
	
	protected function view($page, $model = null)
	{
		global $pathToRoot;
		$title = 'Leader Board';
		$menu = '
			<li><a href='.$pathToRoot.'CertTree/>Certification Trees</a></li>
			<li><a href='.$pathToRoot.'index.php>Go back Home</a></li>
		';
		include_once($pathToRoot."view/shared/pagelayout.php");
	}
	
	public function index()
	{	
		global $pathToRoot;
		include_once($pathToRoot."model/Shared/Members.php");
		if (!isset($_GET['StartDate']) OR !isset($_GET['EndDate']))
		{
			$startDate = strtotime("-7 days");
			$endDate = time();
		}
		else
		{
			$startDate = strtotime($_GET['StartDate']." 12:00:00 AM");
			$endDate = strtotime($_GET['EndDate']." 12:00:00 AM");
			echo $endDate;
		}
		$dates = "?StartDate=".date('r', $startDate)."&EndDate=".date('r', $endDate);
		if (isset($_GET['id']))
		{
			$this->fillVehicleDestroyFromAPI($_GET['id']);
			header('Location: index.php'.$dates);
		}
		$id = "37509488620610014"; 
		//hard coding just one member group for the time being until phase 1 deployment is done
		$members = Members::withID($id);
		$players = $members->getMembers();
		$leaderBoard = $this->getLeaderBoard($_GET['StartDate'], $_GET['EndDate']);
		$model = $leaderBoard;
		
		$page = $pathToRoot.'view/LeaderBoard/index.php';
		$this->view($page, $model);
	}
	
	protected function getLeaderBoard($startDate, $endDate)
	{
		global $pathToRoot;
		include($pathToRoot."model/Shared/dbconnect.php");
		$StartStamp = strtotime($startDate);
		$EndStamp = strtotime($endDate);
		$query = "
			SELECT  m.`character_id`, m.`name`,
			SUM( IF(  vd.`vehicle_definition_id` = 1, 1, 0 ) ) AS Flash, 
			SUM( IF(  vd.`vehicle_definition_id` = 2, 1, 0 ) ) AS Sunderer,
			SUM( IF(  vd.`vehicle_definition_id` = 3, 1, 0 ) ) AS Lightning,
			SUM( IF(  vd.`vehicle_definition_id` = 4, 1, 0 ) ) AS Magrider,
			SUM( IF(  vd.`vehicle_definition_id` = 6, 1, 0 ) ) AS Prowler,
			SUM( IF(  vd.`vehicle_definition_id` = 7, 1, 0 ) ) AS Scythe,
			SUM( IF(  vd.`vehicle_definition_id` = 9, 1, 0 ) ) AS Mosquito,
			SUM( IF(  vd.`vehicle_definition_id` = 10, 1, 0 ) ) AS Liberator,
			SUM( IF(  vd.`vehicle_definition_id` = 11, 1, 0 ) ) AS Galaxy,
			SUM( IF(  vd.`vehicle_definition_id` = 12, 1, 0 ) ) AS Harasser
			FROM `members` m
			LEFT JOIN
			(
			SELECT `vehicle_definition_id`, `attacker_player_guid`
			FROM `vehicle_destroy`
			WHERE (`faction_id` != 2 OR `faction_id`=NULL)
			AND (`timestamp` BETWEEN ".$StartStamp." AND ".$EndStamp.")
			)vd on m.`character_id` = vd.`attacker_player_guid`
			GROUP BY  m.`character_id` 
		";
		
		$queryItems = $dbh->prepare($query);
		$queryItems->execute();
		$rows = $queryItems->fetchAll();
		return $rows;
	}
	
	protected function fillVehicleDestroyFromAPI($id)
	{
	//WIP
		global $pathToRoot;
		include($pathToRoot."model/shared/dbconnect.php");
		$stmt = $dbh->prepare("
		INSERT INTO vehicle_destroy (attacker_loadout_id, attacker_player_guid, attacker_vehicle_id, 
		attacker_weapon_id, character_id, event_type, faction_id, projectile_id, table_type, timestamp, 
		world_id, zone_id, vehicle_definition_id, key_32) 
		VALUES (:attacker_loadout_id, :attacker_player_guid, :attacker_vehicle_id, :attacker_weapon_id, 
		:character_id, :event_type, :faction_id, :projectile_id, :table_type, :timestamp, 
		:world_id, :zone_id, :vehicle_definition_id, :key_32)
		");
		$stmt->bindParam(':attacker_loadout_id', $attacker_loadout_id);
		$stmt->bindParam(':attacker_player_guid', $attacker_player_guid);
		$stmt->bindParam(':attacker_vehicle_id', $attacker_vehicle_id);
		$stmt->bindParam(':attacker_weapon_id', $attacker_weapon_id);
		$stmt->bindParam(':character_id', $character_id);
		$stmt->bindParam(':event_type', $event_type);
		$stmt->bindParam(':faction_id', $faction_id);
		$stmt->bindParam(':projectile_id', $projectile_id);
		$stmt->bindParam(':table_type', $table_type);
		$stmt->bindParam(':timestamp', $timestamp);
		$stmt->bindParam(':vehicle_definition_id', $vehicle_definition_id);
		$stmt->bindParam(':world_id', $world_id);
		$stmt->bindParam(':zone_id', $zone_id);
		$stmt->bindParam(':key_32', $key_32);
		
		$url = "http://census.soe.com/s:vco/get/ps2:v2/characters_event/?character_id=".$id."&type=VEHICLE_DESTROY&c:limit=1000";
		$response = file_get_contents($url);
		$json = json_decode($response, true);
		foreach ($json["characters_event_list"] as $item)
		{
			$attacker_loadout_id = $item["attacker_loadout_id"];
			$attacker_player_guid = $item["attacker_player_guid"];
			$attacker_vehicle_id = $item["attacker_vehicle_id"];
			$attacker_weapon_id = $item["attacker_weapon_id"];
			$character_id = $item["character_id"];
			$event_type = $item["event_type"];
			$faction_id = $item["faction_id"];
			$projectile_id = $item["projectile_id"];
			$table_type = $item["table_type"];
			$timestamp = $item["timestamp"];
			$vehicle_definition_id = $item["vehicle_definition_id"];
			$world_id = $item["world_id"];
			$zone_id = $item["zone_id"];
			//----------------------------
			//Start create unique 32 base key

			$apg1 = substr($item["attacker_player_guid"], 0, 8);
			$apg2 = substr($item["attacker_player_guid"], 8, 5);
			$apg3 = substr($item["attacker_player_guid"], 16, 3);
			$ci1 = substr($item["character_id"], 0, 8);
			$cil2 = substr($item["character_id"], 8, 5);
			$cil3 = substr($item["character_id"], 16, 3);

			$key = base_convert($apg1, 10, 32).base_convert($apg2, 10, 32).base_convert($apg3, 10, 32).base_convert($ci1, 10, 32).base_convert($cil2, 10, 32).base_convert($cil3, 10, 32).base_convert($item["timestamp"], 10, 32);
			//End unique 32 base key
			//----------------------------
			$key_32 = $key;
			$stmt->execute();
		}
		
	}
}
/*
SELECT  m.`character_id`, m.`name`,
SUM( IF(  vd.`vehicle_definition_id` = 1, 1, 0 ) ) AS Flash, 
SUM( IF(  vd.`vehicle_definition_id` = 2, 1, 0 ) ) AS Sunderer,
SUM( IF(  vd.`vehicle_definition_id` = 3, 1, 0 ) ) AS Lightning,
SUM( IF(  vd.`vehicle_definition_id` = 4, 1, 0 ) ) AS Magrider,
SUM( IF(  vd.`vehicle_definition_id` = 6, 1, 0 ) ) AS Prowler,
SUM( IF(  vd.`vehicle_definition_id` = 7, 1, 0 ) ) AS Scythe,
SUM( IF(  vd.`vehicle_definition_id` = 9, 1, 0 ) ) AS Mosquito,
SUM( IF(  vd.`vehicle_definition_id` = 10, 1, 0 ) ) AS Liberator,
SUM( IF(  vd.`vehicle_definition_id` = 11, 1, 0 ) ) AS Galaxy,
SUM( IF(  vd.`vehicle_definition_id` = 12, 1, 0 ) ) AS Harasser
FROM `members` m
LEFT JOIN
(
SELECT `vehicle_definition_id`, `attacker_player_guid`
FROM `vehicle_destroy`
WHERE (`faction_id` != 2 OR `faction_id`=NULL)
)vd on m.`character_id` = vd.`attacker_player_guid`
GROUP BY  m.`character_id` 
ORDER BY  `Sunderer` DESC 
*/
?>