<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
<thead>
	<tr>
		<th>skill_id</th>
		<th>name</th>
		<th>description</th>
		<th>image_path</th>
		<th>skill_points</th>
		<th>skill_line_id</th>
	</tr>
</thead>
<tbody>
<?php
foreach($model as $item)
{
	echo "<tr>";
	echo "<td>".$item["skill_id"]."</td>";
    echo "<td>".$item["name"]."</td>";
	echo "<td>".$item["description"]."</td>";
	echo "<td>".$item["image_path"]."</td>";
	echo "<td>".$item["skill_points"]."</td>";
	echo "<td>".$item["skill_line_id"]."</td>";
	echo "</tr>";
}
?>
</tbody>
<tfoot>
	<tr>
		<th>skill_id</th>
		<th>name</th>
		<th>description</th>
		<th>image_path</th>
		<th>skill_points</th>
		<th>skill_line_id</th>
	</tr>
</tfoot>
</table>