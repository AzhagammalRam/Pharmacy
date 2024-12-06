<?php
	$id =  $_REQUEST['id'];
	$amount = $_REQUEST['amount'];
	require_once("../config.php");
	
	$billno = date("Y").$id;
	
	//$sql = mysqli_query($db,"SELECT sum(amount) as total FROM tbl_billing_items WHERE status = 2 AND bid = $id"); --- commented and replaced with tbl_drug_return_billing_items on 20-nov-2016
	
	$sql = mysqli_query($db,"SELECT * FROM tbl_purchase WHERE id = $id");
	$rs = mysqli_fetch_array($sql);
	$invoiceamt = $rs['invoiceamt'];
	$invoiceno = $rs['invoiceno'];
	
$balancemt=$rs['balanceamt'] - $amount;
	$sql = "UPDATE tbl_purchase SET balanceamt = $balancemt where id = $id";
	
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