<?php
	$id = $_REQUEST['id'];
	$batch = $_REQUEST['batch'];
	
	include('../config.php');
	
	$sql = "UPDATE tbl_billing_items SET batchno = '$batch' WHERE id = $id";
	if(mysql_query($sql))
		echo 'updated';
	else
		mysql_error();
?>