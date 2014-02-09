<html>
	<head>
		<!--<title>Cert Tree App</title>-->
		<title><?php echo $title; ?></title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<!--  Need to clean up this part below -->
		<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
		<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/favicon.ico" />
		<style type="text/css" title="currentStyle">
			@import "<?php echo $pathToRoot; ?>css/jquery.dataTables.css";
			@import "<?php echo $pathToRoot; ?>css/chosen.min.css";
			@import "<?php echo $pathToRoot; ?>css/bootstrap.min.css";
			@import "<?php echo $pathToRoot; ?>css/sticky-footer-navbar.css";
		</style>
	</head>
	<body>
	<!-- Wrap all page content here -->
    <div id="wrap">
      <!-- Fixed navbar -->
      <div class="navbar navbar-default navbar-fixed-top" role="navigation" >
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo $pathToRoot; ?>index.php">VCO</a>
          </div>
          <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
				<?php echo $menu; ?>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
		<div style="padding-top: 60px;">
      <!-- Begin page content -->
        <?php include($page);//This is where we load the page ?>
		</div>
    </div>

    <div id="footer">
      <div class="container">
        <p class="text-muted">Voodoo Shipping Company Certification Tree App</p>
      </div>
    </div>
    <!-- JavaScript================================================== -->
		<script type="text/javascript" language="javascript" src="<?php echo $pathToRoot; ?>js/jquery.js"></script>
		<script src="<?php echo $pathToRoot; ?>js/bootstrap.min.js"></script>
		<!--\/DataTable JS stuff\/-->
		<script type="text/javascript" language="javascript" src="<?php echo $pathToRoot; ?>js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example').dataTable();
			} );
		</script>
		<!--\/Chosen JS stuff\/-->
		<script src="<?php echo $pathToRoot; ?>js/chosen.jquery.min.js" type="text/javascript"></script>
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
		<
		<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		<script>
		  jQuery(document).ready(function($) {
		  $('.datepicker').datepicker({
			 autoclose: true
		  });
		});
		  </script>
    <!-- JavaScript================================================== -->

		
	</body>
</html>
