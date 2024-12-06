<?php
	$id = $_REQUEST['id'];
	include("../config.php");
	$sql = "UPDATE tbl_requestmedicine SET status = 8 WHERE reqid = $id";
	if(mysqli_query($db,$sql))
		echo 'Bill Cancelled !';
	else
		echo mysqli_error($db);
?>