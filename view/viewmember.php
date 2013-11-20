<?php
	foreach($model as $tree)
	{
		echo $tree->name."<br/>";
		foreach($tree->branches as $branch)
		{
			echo $branch->name."<br/>";
			foreach($branch->leaves as $leaf)
			{
				echo $leaf->name." ".$leaf->have."<br/>";
			}
		}
		echo "<br/><br/>";
	}
?>