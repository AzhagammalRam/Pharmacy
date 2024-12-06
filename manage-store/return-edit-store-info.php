<?php
	$id = $_REQUEST['id'];
	require_once("../config.php");
	$sql = "SELECT * FROM branch WHERE id = ".$id;
	$res = mysqli_query($db,$sql);
	$rs = mysqli_fetch_array($res);
	// $status = ($rs['status'] == 1) ? "<span class='label label-sm label-success arrowed-in arrowed-in-right'>Active <//span>" : "<span class='label label-sm label-arrowed arrowed-in arrowed-in-right'>Expired</span>";
	
	$array = array("id"=>$rs['id'],"name"=>$rs['name'], "status"=>$rs['status']);
	
	print json_encode($array);
?>