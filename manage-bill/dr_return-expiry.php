<?php
	$prod = urldecode($_REQUEST['prod']);
	$prod = mysql_escape_string($prod);
	$batch = $_REQUEST['batch'];
	require_once('../config.php');
	$storid=$_SESSION['storeid'];

	
	$cmd = mysql_query("SELECT id FROM tbl_productlist WHERE productname = '$prod'");
	$rs = mysql_fetch_array($cmd);
	if($rs['id']){
		$id = $rs['id'];
		$sql = mysql_query("SELECT distinct expirydate FROM tbl_purchaseitems WHERE status = 1 AND productid = $id AND batchno = '$batch'  AND branch_id='$storid'");
		$array = array();
		while($r = mysql_fetch_array($sql)){
			$expirydate = $r['expirydate'];
			$expiry = substr($expirydate,3);
			array_push($array, array("expiry"=>$expiry));
		}
		echo $expirydate;
	}else{
		echo "error1";
	}
	
?>