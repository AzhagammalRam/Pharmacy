<?php
	$invoiceno = $_REQUEST['invoiceno'];
	$cred = $_REQUEST['cred'];
	if($cred=='')
	{
		$cred=0;
	}
	include("../config.php");
	
	$res = mysqli_query($db,"SELECT payment, purchaseid, supplierid FROM tbl_purchase WHERE id = $invoiceno");
	$rs = mysqli_fetch_array($res);
	$purchaseid = $rs['purchaseid'];
	$paymentid =  $rs['payment'];
	$supplierid =  $rs['supplierid'];
	mysqli_query($db,"UPDATE tbl_purchase SET balanceamt = balanceamt-$cred, credit_adj= $cred WHERE purchaseid='$purchaseid'") or die(mysqli_error($db));
	mysqli_query($db,"UPDATE tbl_supplier SET credit = credit-$cred WHERE id='$supplierid' ") or die(mysqli_error($db));
	mysqli_query($db,"UPDATE tbl_purchaseitems SET status = 1 WHERE purchaseid = '$purchaseid' AND status = 2");
	mysqli_query($db,"UPDATE tbl_payment SET status = 1 WHERE id = '$paymentid' AND status = 2");
	$q = "UPDATE tbl_purchase SET status = 1 WHERE id = '$invoiceno' AND status = 2";
	if(mysqli_query($db,$q))
		echo 'Purchase Entry Saved';
	else
		echo mysqli_error($db);

?>