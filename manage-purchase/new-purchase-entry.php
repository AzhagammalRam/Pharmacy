<?php
	session_start();
	$username = $_SESSION['phar-username'];
	include("../config.php");
	
//	$purchaseid = $_REQUEST['purchaseid'];
	$supplierid = $_REQUEST['supplierid'];
	$invoicedate = $_REQUEST['invoicedate']; 
	$invoicedate = implode("-", array_reverse(explode("/",$invoicedate)));
	$invoiceno = $_REQUEST['invoiceno'];
	$invoiceamt = $_REQUEST['invoiceamt'];
	$invoicetype = $_REQUEST['invoicetype'];
	$paymentdate = $_REQUEST['paymentdate'];
	$paymentdate = implode("-", array_reverse(explode("/",$paymentdate)));
	$dued1 = $_REQUEST['dued'];
	$dued = implode("-", array_reverse(explode("/",$dued1)));
	$credit_adj = $_REQUEST['creditval'];
	$paymentamt = $_REQUEST['paymentamt'];
	$payable = $_REQUEST['payable'];
	$creditdate = $_REQUEST['creditdate'];
	$creditdate = implode("-", array_reverse(explode("/",$creditdate)));
	
	$s = mysqli_query($db,"SELECT AUTO_INCREMENT FROM information_schema.tables WHERE TABLE_SCHEMA = '".DATABASE."' AND TABLE_NAME = 'tbl_payment'");
	$r = mysqli_fetch_array($s);
	$paymentid = $r['AUTO_INCREMENT'];
	
	$s1 = mysqli_query($db,"SELECT max(purchaseid) as purchaseid FROM tbl_purchaseitems");
	$r1 = mysqli_fetch_array($s1);
	$purchaseitemid = $r1['purchaseid'] ? $r1['purchaseid']+1 : 1;
	
	$s2 = mysqli_query($db,"SELECT AUTO_INCREMENT FROM information_schema.tables WHERE TABLE_SCHEMA = '".DATABASE."' AND TABLE_NAME = 'tbl_purchase'");
	$r2 = mysqli_fetch_array($s2);
	$purchaseid = $r2['AUTO_INCREMENT'];
	
	$balanceamt = $invoiceamt - $paymentamt;
	if($balanceamt ==0 || $balanceamt=="")
	$bal=0;
	else
	$bal=1;
	if($invoicetype == 'CASH'){
		$paymenttype = "PAYMENT";
		$paymentmode = "CASH";
	}else{
		$paymenttype = "";
		$paymentmode = "";
	}
	
	$query1 = "INSERT INTO tbl_payment (id, invoiceno, invoiceamt, paymenttype, paymentmode, creditdate, paymentdate, chequeno, bankname, paymentamt, payable, balanceamt, dued, username, datentime, status) VALUES ('$paymentid', '$invoiceno', '$invoiceamt', '$paymenttype', '$paymentmode', '$creditdate', '$paymentdate', '', '', '$paymentamt', '$payable', '$balanceamt','$dued', '$username', CURRENT_TIMESTAMP, '2')";
	
	$query3=mysqli_query($db,"insert into tbl_invoice_payment(invoiceno,incoiceamount,balance) values ('$invoiceno','$invoiceamt','$bal')");
	
	if(mysqli_query($db,$query1)){
		$query2 = "INSERT INTO tbl_purchase (id, supplierid, purchaseid, invoicedate, invoiceno, invoiceamt,payable, balanceamt, credit_adj, dued, invoicetype,  payment, username, datentime, status) VALUES ('$purchaseid', '$supplierid', '$purchaseitemid', '$invoicedate', '$invoiceno', '$invoiceamt', '$payable', '$balanceamt', '$credit_adj'  , '$dued', '$invoicetype', '$paymentid', '$username', CURRENT_TIMESTAMP, '2')";
		if(mysqli_query($db,$query2)){
			echo $purchaseid;
		}else{
			mysqli_query($db,"DELETE FROM tbl_purchase WHERE id = $purchaseid AND status = 2");
			echo "ERROR";
		}
	}else{
		mysqli_query($db,"DELETE FROM tbl_payment WHERE id = $paymentid AND status = 2");
		echo "ERROR";
	}
?>