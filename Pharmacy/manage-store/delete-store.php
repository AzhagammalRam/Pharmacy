<?php
	$id = $_REQUEST['id'];
	require_once("../config.php");
	$sql = "DELETE FROM branch WHERE id = ".$id;
	if(mysqli_query($db,$sql))
		echo 'ok';
	else
		echo mysqli_error($db);
?>