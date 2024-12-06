<?php
	include("../config.php");
	$manuf = $_REQUEST['manuf'];
	$manuf = urldecode($manuf);
	$manuf = mysqli_escape_string($db,$manuf);
	$sql = mysqli_query($db,"SELECT id FROM tbl_manufacturer WHERE manufacturername = '$manuf'");
	$cnt = mysqli_num_rows($sql);
	if($cnt == 0)
		echo 'invalid';
	else
		echo 'valid';
	
?>