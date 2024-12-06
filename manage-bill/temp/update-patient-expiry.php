<?php
	$id = $_REQUEST['id'];
	$expiry = $_REQUEST['expiry'];
	$x = explode("/",$expiry);
	$expirydate = $x[1] . '-' . $x[0] . '-27';
	include('../config.php');
	
	$sql = "UPDATE tbl_billing_items SET expirydate = '$expirydate' WHERE id = $id";
	if(mysql_query($sql))
		echo 'updated';
	else
		mysql_error();
?>