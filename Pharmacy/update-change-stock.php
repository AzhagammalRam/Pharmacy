<?php
	/*$invoiceno = $_REQUEST['invoiceno'];
	require_once("../config.php");
	
	$res = mysqli_query($db,"SELECT payment, purchaseid FROM tbl_purchase WHERE id = $invoiceno");
	$rs = mysqli_fetch_array($res);
	$purchaseid = $rs['purchaseid'];
	$paymentid =  $rs['payment'];

	mysqli_query($db,"UPDATE tbl_purchaseitems SET status = 1 WHERE purchaseid = $purchaseid AND status = 2");
	mysqli_query($db,"UPDATE tbl_payment SET status = 1 WHERE id = $paymentid AND status = 2");
	$q = "UPDATE tbl_purchase SET status = 1 WHERE id = $invoiceno AND status = 2";
	if(mysqli_query($db,$q))
		echo 'Purchase Entry Saved';
	else
		echo mysqli_error();*/
		require_once("config.php");
		$invoiceno = $_REQUEST['invoiceno'];
		$res = mysqli_query($db,"SELECT payment, purchaseid FROM tbl_purchase WHERE id = $invoiceno");
		$rs = mysqli_fetch_array($res);
		$purchaseid = $rs['purchaseid'];

		$exp_dt = $_REQUEST['exp_dt'];
		$exp_dt_array =(explode(",",$exp_dt));
	
		$batch = $_REQUEST['batch'];
		$batch_array =(explode(",",$batch));
		
		for($i=0;$i<count($batch_array);$i++)
		{
			$bid=$batch_array[$i];
			$exp=$exp_dt_array[$i];
			$r="UPDATE tbl_purchaseitems SET status = 1 WHERE status = 2 and batchno = '$bid' and expirydate='$exp'";
		}
		
		
		if(mysqli_query($db,$r)){
			echo 'Purchase Entry Saved';
			}
		else
		echo mysqli_error($db);
?>