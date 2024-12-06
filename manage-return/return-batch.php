<?php
	$prod = urldecode($_REQUEST['prod']);
	$prod = mysql_escape_string($prod);
	$batch = $_REQUEST['batch'];
	
	include('../config.php');
	$storid=$_SESSION['storeid'];
	$cmd = mysql_query("SELECT id FROM tbl_productlist WHERE productname = '$prod'");
	$rs = mysql_fetch_array($cmd);
	if($rs['id']){
		$id = $rs['id'];
		$sql = mysql_query("SELECT distinct expirydate as exp_dt, id, aval FROM tbl_purchaseitems WHERE status = 1 AND productid = $id AND batchno = '$batch' AND aval > 0 AND branch_id='$storid' ");

	$r = mysql_fetch_array($sql);
	$expirydate = implode("/",explode("-",$r['exp_dt']));
	$data = array('expirydate' => $expirydate,'id' => $r['id'], 'aval' => $r['aval'] ); 

 	echo json_encode($data);
	}else{
		echo "error1";
	}
	
?>