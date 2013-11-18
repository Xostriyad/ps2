<?php
	foreach($model as $group)
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