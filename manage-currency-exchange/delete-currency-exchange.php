<?php
	$id = $_REQUEST['id'];
	include("../config.php");
	$sql = "DELETE FROM tbl_currency WHERE id = ".$id;
	if(mysql_query($sql))
		echo 'ok';
	else
		echo mysql_error();
?>