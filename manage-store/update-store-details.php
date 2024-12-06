<?php
	require_once("../config.php");
	
	$id = $_REQUEST['uid'];						$id = mysqli_escape_string($db,$id);
	$store = $_REQUEST['ustore'];				$store = mysqli_escape_string($db,$store);
	$status = $_REQUEST['ustatus'];				$status = mysqli_escape_string($db,$status);

	$sql = "UPDATE branch SET name = '$store', status = '$status' WHERE id =".$id;
	
	if(mysqli_query($db,$sql))
		echo 'Store Information Updated!';
	else
		echo mysqli_error($db);
?>