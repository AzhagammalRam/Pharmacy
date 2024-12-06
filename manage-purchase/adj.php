<?php
	session_start();
	//$adj = $_SESSION['adj'];
	$adj = $_REQUEST['lblpadj'];
	//echo $adj;
	

	include("../config.php");
	$sql = "SELECT * FROM  tbl_purchaseitems order by id desc limit 1";
	$res = mysql_query($sql);
	$rs = mysql_fetch_array($res);
	
	$productid = $rs['purchaseid'];
	$sql = "SELECT sum(netamt) as net FROM  tbl_purchaseitems where purchaseid='$productid'";
	$res = mysql_query($sql);
	$rs = mysql_fetch_array($res);
	$tot = $rs['net'];
	$sql = "SELECT invoiceamt FROM  tbl_purchase where purchaseid='$productid'";
	$res = mysql_query($sql);
	$rs = mysql_fetch_array($res);
	 $net = $rs['invoiceamt'];
	// echo $net.'<br />';
	  //echo $tot.'<br />';
	 //  echo $adj.'<br />';
	  $tots=($tot+$adj);
	 //   echo $tots.'<br />';
   echo $final=$tots-$net;
?>