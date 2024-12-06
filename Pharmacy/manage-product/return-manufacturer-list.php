<?php
	include("../config.php");
	$sql = "SELECT manufacturername FROM tbl_manufacturer WHERE status = 1";
	$res = mysqli_query($db,$sql);
	$data = array();
	while($rs = mysqli_fetch_array($res)){
		$x = array('manufacturer'=>$rs['manufacturername']);
		array_push($data, $x);
	}
	echo json_encode($data);
?>