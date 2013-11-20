<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/favicon.ico" />
	<title>Item Table</title>
	<style type="text/css" title="currentStyle">
		@import "css/jquery.dataTables.css";
	</style>
	<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
			$('#example').dataTable();
		} );
	</script>
</head>
<body>
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
include("model/dbconnect.php");
$stmt = $dbh->prepare("SELECT * FROM `items`");
$stmt->execute();
while ($row = $stmt->fetch()) 
{
	echo "<tr>";
	echo "<td>".$row["item_id"]."</td>";
    echo "<td>".$row["name"]."</td>";
	echo "<td>".$row["description"]."</td>";
	echo "<td>".$row["image_path"]."</td>";
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
</body>
</html>