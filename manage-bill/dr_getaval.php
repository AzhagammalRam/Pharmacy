<?php
/* used to insert the items that are returned in Drug Return --- 20-Nov-2016*/
error_reporting(0);
	session_start();
	$username = $_SESSION['phar-username'];
	require_once('../config.php');
	$prod = urldecode($_REQUEST['prod']);
	$prod = mysql_escape_string($prod);
	$batch = $_REQUEST['batch'];
	$storid=$_SESSION['storeid'];
	$qty = $_REQUEST['qty'];	$temp = $qty;
	$expiry = $_REQUEST['expiry'];	$exp = $expiry;
	$bid = $_REQUEST['bid'];
	$amount =0;
	$purchaseid="";
	
	
	
	$cmd = mysql_query("SELECT * FROM tbl_productlist WHERE productname = '$prod'");
	$rs = mysql_fetch_array($cmd);
	if($rs['id']){
		$code = $rs['id'];
		$type = $rs['stocktype'];
		$desc = $rs['productname'];

		$unit = $rs['unitdesc'];
		$sql = mysql_query("SELECT SUM(aval) as aval FROM tbl_purchaseitems WHERE status = 1 AND productid = $code AND batchno = '$batch' AND expirydate = '$expiry'  AND branch_id='$storid'");
		while($r = mysql_fetch_array($sql)){
		echo $aval = $r['aval'];
	}
}
	?>