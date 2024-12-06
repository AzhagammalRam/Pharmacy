<?php
	$prod = urldecode($_REQUEST['prod']);
	
	include('../config.php');
	$prod = mysqli_escape_string($db,$prod);
	$batch = $_REQUEST['batch'];
	$storid=$_SESSION['storeid'];
	$cmd = mysqli_query($db,"SELECT id FROM tbl_productlist WHERE productname = '$prod'");
	$rs = mysqli_fetch_array($cmd);
	if($rs['id']){
		$id = $rs['id'];
		$sql = mysqli_query($db,"SELECT distinct expirydate as exp_dt, id, aval FROM tbl_purchaseitems WHERE status = 1 AND productid = $id AND batchno = '$batch' AND aval > 0 AND branch_id='$storid' ");

	$r = mysqli_fetch_array($sql);
	$expirydate = implode("/",explode("-",$r['exp_dt']));
	$data = array('expirydate' => $expirydate,'id' => $r['id'], 'aval' => $r['aval'] ); 

 	echo json_encode($data);
	}else{
		echo "error1";
	}
	
?>