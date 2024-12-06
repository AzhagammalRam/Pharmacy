<?php
	$id = $_REQUEST['id'];
	include("../config.php");
	$sql = "DELETE FROM tbl_productlist WHERE id = ".$id;
	if(mysqli_query($db,$sql))
		echo 'ok';
	else
		echo mysql_error($db,);
?>