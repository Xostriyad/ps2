<?php
	foreach($model as $tree)
	{
		echo "<hr/>";
		echo "<h3>".$tree->name."</h3>";
		foreach($tree->branches as $branch)
		{
			echo "<h4>".$branch->name."</h4>";
			foreach($branch->leaves as $leaf)
			{
				echo $leaf->name." ";
			if($leaf->have==0)
			{
				echo "<span style='color:red;'><b>I can't find it!!</b></span><br/>";
			}
			else
			{
				//item 501, mana vehicle turret seems to show up regardless
				//Must be logically a skill to unlock the usage of this existing item.
				echo "<span style='color:green;'><b>You got it!</b></span><br/>";
			}
			}
		}
	}
?>