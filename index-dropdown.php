<link rel="stylesheet" href="css/chosen.min.css">
<select data-placeholder="Choose a Player..." class="chosen-select" style="width:350px;" tabindex="2">
	<option value=""></option>
<?php

	$url="http://census.soe.com/get/ps2/outfit_member?outfit_id=37509488620610014&c:limit=1000&c:show=character_id&c:join=character^show:name.first";
	$response = file_get_contents($url);
	$json = json_decode($response, true);
		foreach ($json["outfit_member_list"] as $item)
		{
			$character_id = $item["character_id"];
			$name = $item["character_id_join_character"]["name"]["first"];
			//echo $character_id.": ".$name."<br/>";
			echo '<option value="'.$character_id.'">'.$name.'</option>';
		}
?>
</select>
<div id='myStyle'>

</div>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
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
<script>
$( "select" )
  .change(function () {
    var str = "";
    $( "select option:selected" ).each(function() {
      str += $( this ).val();
    });
	var url = "data.php?id=" + str;
    $( "#myStyle" ).load(url);
  })
  .change();
</script>