<?php
	session_start();
	$username = $_SESSION['phar-username'];
	include("../config.php");

	$supplierid = $_REQUEST['supplierid'];

	$s = mysqli_query($db,"SELECT AUTO_INCREMENT FROM information_schema.tables WHERE TABLE_SCHEMA = '".DATABASE."' AND TABLE_NAME = 'tbl_purchase_return'");
	$r = mysqli_fetch_array($s);
	$returnid = $r['AUTO_INCREMENT'];
	

	$query="INSERT into tbl_purchase_return (supplierid, datentime, totalamount, status) VALUES ('$supplierid', CURRENT_TIMESTAMP, '0', '2' )";
	if(mysqli_query($db,$query)){ echo $returnid; }
	
	else { echo "error !"; }
?>