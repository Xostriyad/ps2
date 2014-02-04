<div>
  <em>Weapons Select</em>
  <form id="InfantryWeapons" method="post" action="insertLeaf.php">
	  <select name="weapons[ ]" data-placeholder="Choose Items" style="width:350px;" class="chosen-select" multiple tabindex="6">
		<option value=""></option>
		<?php
			$tree = $model["allItems"]->trees["weapons"];
			foreach($tree->branches as $branch)
			{
				echo '<optgroup label="'.$branch->name.'">';
				foreach($branch->leaves as $leaf)
				{
					echo '<option value="'.$_GET["id"].','.$leaf->item_id.'">'.$leaf->name.'</option>';
				}
				echo '</optgroup>';
			}
		?>
	</select>
	<input type="submit" name="Submit" value=Submit tabindex="2" />
	</form>
</div>
<div>
  <em>Vehicle Select</em>
  <form id="VehicleStuff" method="post" action="insertLeaf.php">
	  <select name="weapons[ ]" data-placeholder="Choose Items" style="width:350px;" class="chosen-select" multiple tabindex="6">
		<option value=""></option>
		<?php
			$tree = $model["allItems"]->trees["vehicles"];
			foreach($tree->branches as $branch)
			{
				echo '<optgroup label="'.$branch->name.'">';
				foreach($branch->leaves as $leaf)
				{
					echo '<option value="'.$_GET["id"].','.$leaf->item_id.'">'.$leaf->name.'</option>';
				}
				echo '</optgroup>';
			}
		?>
	</select>
	<input type="submit" name="Submit" value=Submit tabindex="2" />
	</form>
</div>
<div>
  <em>Suit Upgrade Select</em>
  <form id="SuitStuff" method="post" action="insertLeaf.php">
	  <select name="weapons[ ]" data-placeholder="Choose Items" style="width:350px;" class="chosen-select" multiple tabindex="6">
		<option value=""></option>
		<?php
			$tree = $model["allItems"]->trees["suits"];
			foreach($tree->branches as $branch)
			{
				echo '<optgroup label="'.$branch->name.'">';
				foreach($branch->leaves as $leaf)
				{
					echo '<option value="'.$_GET["id"].','.$leaf->item_id.'">'.$leaf->name.'</option>';
				}
				echo '</optgroup>';
			}
		?>
	</select>
	<input type="submit" name="Submit" value=Submit tabindex="2" />
	</form>
</div>
<div>
<?php
	foreach($model["forest"]->trees as $tree)
	{
		echo "<hr/>";
		echo "<h3>".$tree->name."</h3>";
		foreach($tree->branches as $branch)
		{
			echo "<h4>".$branch->name."</h4>";
			foreach($branch->leaves as $leaf)
			{
				echo $leaf->name;
				echo ' <a href="deleteLeaf.php?group_id='.$_GET["id"].'&item_id='.$leaf->item_id.'">Delete</a><br/>';
			}
		}
	}
?>
</div>