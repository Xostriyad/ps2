<h1> Welcome to the Leader Board App! </h1>
<p>View your individual kills and your total score earned!<br/>
So when you see "2" under Sunderer that means you killed 2 Sunderers! But you scored 4 points! That is reflected in the total score column!<br/>
If your kills are looking old or just not updated at all <b>click your name<b/> and the page will refresh your data!</p>
<form action="index.php" method="GET">
<p>Times start at midnight or 4pm... it's kind of odd really I'm still hammering out weird date time issues.<br/>
If you are willing to fudge a single day this should be fine!</p>
<p>Start Date: <input type="text" name="StartDate" class="datepicker" value="<?php echo $_GET['StartDate'] ?>"> End Date: <input type="text" name="EndDate" value="<?php echo $_GET['EndDate'] ?>" class="datepicker"></p>
<input type="submit" />
</form>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
	<thead>
		<tr>
			<th>Member Name</th>
			<th>Sunderer</th>
			<th>Lightning</th>
			<th>Magrider</th>
			<th>Prowler</th>
			<th>Scythe</th>
			<th>Mosquito</th>
			<th>Liberator</th>
			<th>Galaxy</th>
			<th>Harasser</th>
			<th>Total Points Earned</th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach ($model as $player)
		{
			$total = $player["Lightning"] + $player["Harasser"] + (($player["Sunderer"] + $player["Scythe"] + $player["Mosquito"] + $player["Liberator"] + $player["Galaxy"]) * 2);
			echo "<tr>";
			echo '<td><a href="index.php?id='.$player["character_id"].'&name='.$player["name"].'">'.$player["name"].'</a></td>';
			echo "<td>".$player["Sunderer"]."</td>";
			echo "<td>".$player["Lightning"]."</td>";
			echo "<td>".$player["Magrider"]."</td>";
			echo "<td>".$player["Prowler"]."</td>";
			echo "<td>".$player["Scythe"]."</td>";
			echo "<td>".$player["Mosquito"]."</td>";
			echo "<td>".$player["Liberator"]."</td>";
			echo "<td>".$player["Galaxy"]."</td>";
			echo "<td>".$player["Harasser"]."</td>";
			echo "<td>".$total."</td>";
			echo "</tr>";
		}
	?>
	</tbody>
	<tfoot>
		<tr>
			<th>Member Name</th>
			<th>Sunderer</th>
			<th>Lightning</th>
			<th>Magrider</th>
			<th>Prowler</th>
			<th>Scythe</th>
			<th>Mosquito</th>
			<th>Liberator</th>
			<th>Galaxy</th>
			<th>Harasser</th>
			<th>Total Points Earned</th>
		</tr>
	</tfoot>
</table>