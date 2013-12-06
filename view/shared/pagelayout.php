<html>
	<head>
		<title>Cert Tree App</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<!--  Need to clean up this part below -->
		<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/favicon.ico" />
		<style type="text/css" title="currentStyle">
			@import "css/jquery.dataTables.css";
			@import "css/chosen.min.css";
		</style>

		<div id="menu">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="itemTable.php">Item List</a></li>
				<li><a href="skillTable.php">Skill List</a></li>
			</ul>
		</div>
	</head>
	<body>
		<?php include($page);//This is where we load the page ?>
	</body>
	<footer>
	<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
		<!--DataTable JS stuff-->
		<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example').dataTable();
			} );
		</script>
		<!--Chosen JS stuff-->
		<script src="js/chosen.jquery.min.js" type="text/javascript"></script>
		<script type="text/javascript">
		var config = {
		'.chosen-select'           : {},
		'.chosen-select-deselect'  : {allow_single_deselect:true},
		'.chosen-select-no-single' : {disable_search_threshold:10},
		'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
		'.chosen-select-width'     : {width:"95%"}
		}
		for (var selector in config) {
		$(selector).chosen(config[selector]);
		}
		</script>
		<!--  Need to clean up this part above -->
	</footer>
</html>
