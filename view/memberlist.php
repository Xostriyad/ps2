<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
	<thead>
		<tr>
			<th>Member Name</th>
			<th>Member ID</th>
			<th>Battle Rank</th>
			<th>Earned Certs</th>
			<th>Minutes Played</th>
			<th>Certs/Minute</th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach ($model as $player)
		{
			echo "<tr>";
			echo '<td><a href="index.php?id='.$player->id.'">'.$player->name.'</a></td>';
			echo "<td>".$player->id."</td>";
			echo "<td>".$player->battle_rank."</td>";
			echo "<td>".$player->earned_points."</td>";
			echo "<td>".$player->minutes_played."</td>";
			echo "<td>".$player->avg_cpm."</td>";
			echo "</tr>";
		}
	?>
	</tbody>
	<tfoot>
		<tr>
			<th>Member Name</th>
			<th>Member ID</th>
			<th>Battle Rank</th>
			<th>Earned Certs</th>
			<th>Minutes Played</th>
			<th>Certs/Minute</th>
		</tr>
	</tfoot>
</table>