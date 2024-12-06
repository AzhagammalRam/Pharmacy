<?php
	$id = $_REQUEST['id'];
	include("../config.php");
	
	$res = mysqli_query($db,"SELECT payment, purchaseid FROM tbl_purchase WHERE id = $id");
	$rs = mysqli_fetch_array($res);
	$purchaseid = $rs['purchaseid'];
	$paymentid =  $rs['payment'];

	mysqli_query($db,"DELETE FROM tbl_purchaseitems WHERE purchaseid = $purchaseid AND status = 2");
	mysqli_query($db,"DELETE FROM tbl_payment WHERE id = $paymentid AND status = 2");
	$q = "DELETE FROM tbl_purchase WHERE id = $id AND status = 2";
	if(mysqli_query($db,$q))
		echo 'Deleted !';
	else
		echo mysqli_error($db);
?>