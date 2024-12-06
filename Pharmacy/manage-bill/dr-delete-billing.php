<?php
	$id = $_REQUEST['id'];
	include("../config.php");
	
	$cmd = mysql_query("DELETE FROM tbl_drug_return_billing_items WHERE bid = $id");
	// $cmd = mysql_query("DELETE FROM tbl_billing WHERE id = $id");
	$cmd = "DELETE FROM tbl_drug_return_billing WHERE id = $id";
	if(mysql_query($cmd))
		echo 'Deleted !';
	else
		echo mysql_error();
?>
