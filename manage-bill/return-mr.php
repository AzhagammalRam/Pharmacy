<?php
	include('../config.php');
	$prod = urldecode($_REQUEST['prod']);
	$prod = mysqli_escape_string($db,$prod);
	$batch = $_REQUEST['batch'];
	$storid=$_SESSION['storeid'];

	
	$cmd = mysqli_query($db,"SELECT id FROM tbl_productlist WHERE productname = '$prod'");
	$rs = mysqli_fetch_array($cmd);
	if($rs['id']){
		$id = $rs['id'];
		$sql = mysqli_query($db,"SELECT distinct mrp FROM tbl_purchaseitems WHERE status = 1 AND productid = $id AND batchno = '$batch' AND aval > 0  AND branch_id='$storid' ");
		$array = array();
		while($r = mysqli_fetch_array($sql)){
			array_push($array, array("mr"=>$r['mrp']));
		}
		echo json_encode($array);
	}else{
		echo "error1";
	}
	
?>