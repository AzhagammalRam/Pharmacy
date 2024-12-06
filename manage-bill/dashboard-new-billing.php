<?php
	session_start();
	$username = $_SESSION['phar-username'];
	$id = $_REQUEST['id'];
	include("../config.php");
	$sql = mysqli_query($db,"SELECT * FROM tbl_requestmedicine WHERE reqid = $id");
	$rs = mysqli_fetch_array($sql);
	$pid = $rs['patientid'];
	$pname = $rs['patientname'];
	$dname = $rs['doctorname'];

	$ss = mysqli_query($db,"SELECT AUTO_INCREMENT FROM information_schema.tables WHERE TABLE_SCHEMA = '".DATABASE."' AND TABLE_NAME = 'tbl_billing'");
	$rr = mysqli_fetch_array($ss);
	$billid = $rr['AUTO_INCREMENT'];
		
	$cmd = "INSERT INTO tbl_billing (patientid, patientname, drname, totalamt, discount, netamt, paidamt, balanceamt, datentime, username, status) VALUES ('$pid', '$pname', '$dname', '0.00', '0.00', '0.00', '0.00', '0.00', CURRENT_TIMESTAMP, '$username', '3');";
	
	if(mysqli_query($db,$cmd)){
		
		mysqli_query($db,"UPDATE tbl_requestmedicine SET status = 1, billingid = $billid WHERE reqid = $id");
		
		$sql1 = mysqli_query($db,"SELECT * FROM tbl_requestmedicine WHERE reqid = $id");
		while($rs = mysqli_fetch_array($sql1)){
			$reqpid = $rs['id'];
			$prod = $rs['drugname'];
			$cmd = mysqli_query($db,"SELECT * FROM tbl_productlist WHERE productname = '$prod'");
			$r = mysqli_fetch_array($cmd);
			if($r['id']){
				$code = $r['id'];
				$sql = "INSERT INTO tbl_billing_items (billno, bid, code, qty, batchno, expirydate, amount, purchaseid, datentime, username, status) VALUES ('', '$billid', '$code', '', '', '', '', '', CURRENT_TIMESTAMP, '$username', '3')";
			}else{
				$sql = "INSERT INTO tbl_outofstock (reqid, reqpid, billingid, datentime, username, status) VALUES ( '$id', '$reqpid', '$billid', CURRENT_TIMESTAMP, '$username', '1')";
			}
			mysqli_query($db,$sql);
		}
		echo "Select ".$pname." in Patient Bills";
	}else{
		echo "Unable to create bill";
	}
?>