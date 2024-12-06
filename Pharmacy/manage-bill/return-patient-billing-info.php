<?php
	$id = $_REQUEST['id'];
	include("../config.php");
	$rs = mysqli_fetch_array(mysqli_query($db,"SELECT * FROM tbl_billing_items WHERE id = $id and del_status != 1"));
	$code = $rs['code'];
		$storid=$_SESSION['storeid'];
	$r1 = mysqli_fetch_array(mysqli_query($db,"SELECT * FROM tbl_productlist WHERE id = $code"));

	$array = array();
	array_push($array, array("type"=>$r1['stocktype']));
	array_push($array, array("desc"=>$r1['productname']));	

	$sql = mysqli_query($db,"SELECT distinct batchno FROM tbl_purchaseitems WHERE status = 1 AND productid = $code AND aval > 0 branch_id='$storid' AND branch_id='$storid'");
	while($r = mysqli_fetch_array($sql)){
		array_push($array, array("batch"=>$r['batchno']));
	}
	echo json_encode($array);
	
?>