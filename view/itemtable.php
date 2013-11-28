<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
<thead>
	<tr>
		<th>item_id</th>
		<th>name</th>
		<th>description</th>
		<th>image_path</th>
	</tr>
</thead>
<tbody>
<?php
foreach($model as $item)
{
	echo "<tr>";
	echo "<td>".$item["item_id"]."</td>";
    echo "<td>".$item["name"]."</td>";
	echo "<td>".$item["description"]."</td>";
	echo "<td>".$item["image_path"]."</td>";
	echo "</tr>";
}
?>
</tbody>
<tfoot>
	<tr>
		<th>item_id</th>
		<th>name</th>
		<th>description</th>
		<th>image_path</th>
	</tr>
</tfoot>
</table>