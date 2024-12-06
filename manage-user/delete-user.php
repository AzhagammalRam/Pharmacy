<?php
	$id = $_REQUEST['id'];
	include("../config.php");
	$sql = "DELETE FROM tbl_users WHERE id = ".$id;
	if(mysqli_query($db,$sql))
		echo 'ok';
	else
		echo mysqli_error($db);
?>