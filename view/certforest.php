<form action="insertTree.php" method="POST">
	New Group Name: <input type="text" name="name" />
	<input type="submit" />
</form>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
<thead>
	<tr>
		<th>Group Name</th>
		<th> </th>
		<th> </th>
	</tr>
</thead>
<tbody>
<?php
foreach($model as $item)
{
	echo '<tr>';
	echo '<td>'.$item["group_name"].'</td>';
	echo '<td> <a href="viewTree.php?id='.$item["group_id"].'">View</a></td>';
	echo '<td> <a href="deleteTree.php?id='.$item["group_id"].'">Delete</a></td>';
	echo '</tr>';
}
?>
</tbody>
<tfoot>
	<tr>
		<th>Group Name</th>
		<th> </th>
		<th> </th>
	</tr>
</tfoot>
</table>