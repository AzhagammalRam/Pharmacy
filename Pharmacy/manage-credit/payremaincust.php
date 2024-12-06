<?php
	$id =  $_REQUEST['id'];
	$amount = $_REQUEST['amount'];
	require_once("../config.php");
	
	$billno = date("Y").$id;
	
	//$sql = mysqli_query($db,"SELECT sum(amount) as total FROM tbl_billing_items WHERE status = 2 AND bid = $id"); --- commented and replaced with tbl_drug_return_billing_items on 20-nov-2016
	
	$sql = mysqli_query($db,"SELECT * FROM tbl_billing WHERE id = $id and del_status != 1");
	$rs = mysqli_fetch_array($sql);
	$invoiceamt = $rs['invoiceamt'];
	$invoiceno = $rs['billno'];
	
$balancemt=$rs['balanceamt'] - $amount;
$paidamount=$rs['paidamt'] + $amount;
	$sql = "UPDATE tbl_billing SET balanceamt = $balancemt,paidamt = $paidamount where id = $id and del_status != 1";
	
	if(mysqli_query($db,$sql))
		echo 'success';
	else
		echo mysqli_error();
		
		if ($balancemt==0)
		   {
				$balance=0;
				 }
				 else 
				 {
					$balance=1; 
					 }		
			$sql2 = "INSERT INTO tbl_invoice_payment (invoiceno, incoiceamount, balance, status, date) VALUES ('$invoiceno', '$amount', '$balance', '1',CURRENT_TIMESTAMP)";
			if(mysqli_query($db,$sql2))
		echo 'success';
	else
		echo mysqli_error($db);
?>