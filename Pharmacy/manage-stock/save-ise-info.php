<?php
	include("../config.php");
	$sql = "UPDATE tbl_purchaseitems SET status = 1 WHERE status = 3";
	if(mysqli_query($db,$sql))
		echo 'Initial Stock Details Updated';
	else
		mysqli_error($db);
?>
