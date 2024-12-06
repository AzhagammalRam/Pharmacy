<?php
require_once("../config.php");
	// include("../config.php");
	// $cmd = mysql_query("SELECT * FROM tbl_productlist WHERE productname = '$prod'");
	// echo "SELECT * FROM tbl_productlist WHERE productname = '$prod'";
	// $rs = mysql_fetch_array($cmd);
	// $code = $rs['id'];
	// $sqlr = mysql_query("SELECT * FROM tbl_purchaseitems WHERE status = 1 AND productid = '$code' AND batchno = '$batch' AND expirydate = '$expiry' AND branch_id='1' order by productid asc limit 1");
	// echo "SELECT * FROM tbl_purchaseitems WHERE status = 1 AND productid = '$code' AND batchno = '$batch' AND expirydate = '$expiry' AND branch_id='1' order by productid asc limit 1";
	// 	$res = mysql_fetch_array($sqlr);
	// 	$pid = $res['id'];

	// 	echo $cmde = "UPDATE tbl_purchaseitems SET aval = aval - $quantity WHERE id = $pid";
	// 		mysql_query($cmde);

	$cmd = "UPDATE stockwastage SET `status`=0 WHERE `status`=1";
	if(mysql_query($cmd))
		echo 'Stock Details Updated';
	else
		mysql_error();
?>