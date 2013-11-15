<?php
	include("dbconnect.php");
	include("playerClass.php");
	$id = $_GET['id'];
	if(empty($id))
	{
		exit();
	}
	$player = Player::withID($id);
	$query = $dbh->prepare("
	SELECT b.group_name, p.name, cb.item_id, pa.name AS base_name
	FROM groups b
	JOIN group_items cb ON cb.group_id = b.group_id
	JOIN items p ON p.item_id = cb.item_id
	LEFT JOIN wattachments a ON cb.item_id = a.attachment_item_id
	LEFT JOIN items pa ON pa.item_id = a.item_id
	");
	$query->execute();
	$rows = $query->fetchAll();
	$groupA = array();
	foreach ($rows as $row) 
	{
		if (!isset($groupA[$row["group_name"]]))
		{
			$groupA[$row["group_name"]] = array();
		}
		array_push($groupA[$row["group_name"]], $row);
	}
	foreach($groupA as $group)
	{
		$output = $group[0]["group_name"]."<br/>";
		
		foreach($group as $gItem)
		{
			$name = $gItem["name"];
			$name = $name.(isset($gItem["base_name"]) ? "[".$gItem["base_name"]."]" : "");
			$output = $output.$name.": ";
			$temp = $player->getItemByID($gItem["item_id"]);
			if($temp==0)
			{
				$output = $output."<span style='color:red;'><b>I can't find it!!</b></span><br/>";
			}
			else
			{
				//item 501, mana vehicle turret seems to show up regardless
				//Must be logically a skill to unlock the usage of this existing item.
				$output = $output."<span style='color:green;'><b>You got it!</b></span><br/>";
			}
			
		}
		echo $output;
		
	}
?>