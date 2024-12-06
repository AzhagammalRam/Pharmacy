<?php
	$id = $_REQUEST['id'];
	include("../config.php");
	$sql = "DELETE FROM tbl_purchaseitems WHERE id = $id AND status = 2";
	if(mysqli_query($db,$sql))
		echo 'ok';
	else
		mysqli_error($db);
?>
