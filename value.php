<?php
foreach ($_POST['weapons'] as $input)
{
	$inputs = explode(",", $input);
	print "group_id: $inputs[0]<br/>";
	print "item_id: $inputs[1]<br/>";
}

?>