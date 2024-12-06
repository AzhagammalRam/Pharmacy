<?php
	session_start();
	$username = $_SESSION['phar-username'];
	$pname = $_REQUEST['pname'];
	$dname = $_REQUEST['dname'];
	$phno = $_REQUEST['phno'];
	include("../config.php");
	
	$ss = mysqli_query($db,"SELECT AUTO_INCREMENT FROM information_schema.tables WHERE TABLE_SCHEMA = '".DATABASE."' AND TABLE_NAME = 'tbl_billing'");  //changed from tbl_billing_items - ----- on 20th Nov 2016
		$rr = mysqli_fetch_array($ss);
		$pid = $rr['AUTO_INCREMENT'];
		$billingindex = $pid; ///// we are adding 1 to existing tbl_billing_items
	$cmd1 = "INSERT INTO tbl_drug_return_billing ( patientid, patientname, drname, totalamt, discount, netamt, paidamt, balanceamt, datentime, username, status,phno,billingindex) VALUES ('', '$pname', '$dname', '0.00', '0.00', '0.00', '0.00', '0.00', CURRENT_TIMESTAMP, '$username', '2','$phno','$billingindex');";
	
	mysqli_query($db,$cmd1) or die("Unable to create bill");
	
	$last_id = mysqli_insert_id($db);
	echo '+'.$last_id;
	//echo '+'.$billingindex;
	
	//$cmd = "INSERT INTO tbl_billing (id, patientid, patientname, drname, totalamt, discount, netamt, paidamt, balanceamt, datentime, username, status,phno) VALUES (NULL, '', '$pname', '$dname', '0.00', '0.00', '0.00', '0.00', '0.00', CURRENT_TIMESTAMP, '$username', '2','$phno');";
	
	//mysqli_query($db,$cmd) or die("Unable to create bill");
	//$last_id = mysqli_insert_id();
	//echo '+'.$last_id;
?>