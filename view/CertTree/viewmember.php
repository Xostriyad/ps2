<?php
echo '<div class="container">';
	foreach($model["forest"] as $tree)
	{
		echo '<div class="row">';
		echo '<div class="col-md-12">';
		echo "<h3>".$tree->name."</h3>";
		echo '</div>'; //col
		echo '</div>'; //row
		
		echo '<div class="row">';
		$i = 0;
		foreach($tree->branches as $branch)
		{
			if($i%3 == 0) //close the row, start a new one every set amount of 
			{
				echo '</div>'; //row
				echo '<div class="row">';
			}
			$i++;
			echo '<div class="col-md-4">';
			/*
			
				
				  <h3>Panel title</h3>
				
				<div class="panel-body">
				  Panel content
				</div>
			</div>
			*/
			echo '<div class="panel panel-default">';
			echo '<div class="panel-heading">';
			echo '<h4  class="panel-title">'.$branch->name."</h4>";
			echo '</div>';
			echo '<div class="panel-body">';
			foreach($branch->leaves as $leaf)
			{
				
				echo $leaf->name." ";
				if($model["player"]->getItemByID($leaf->item_id)==0)
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
			echo '</div>';//panel-body
			echo '</div>';//panel
			echo '</div>'; //col-md-4
		}
		echo '</div>'; //close any open rows
	}
echo '</div>'; //container
?>