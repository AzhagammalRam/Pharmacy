<?php
	//$type = $_REQUEST['type'];
	$prod = urldecode($_REQUEST['prod']);
	include('../config.php');
	$prod = mysqli_escape_string($db,$prod);
        $storid=$_SESSION['storeid'];
        $format = 'Y/m/d '; 
	$d = date ( $format, strtotime ( '+90 days' ) );
	
	$cmd = mysqli_query($db,"SELECT id FROM tbl_productlist WHERE productname = '$prod'");
	$rs = mysqli_fetch_array($cmd);
	if($rs['id']){
		$id = $rs['id'];
		$sql = mysqli_query($db,"SELECT distinct batchno FROM tbl_purchaseitems WHERE status = 1 AND productid = $id AND aval > 0 AND branch_id='$storid' AND expirydate >= '$d'");
		$array = array();
		while($r = mysqli_fetch_array($sql)){
			array_push($array, array("batch"=>$r['batchno']));
		}
		echo json_encode($array);
	}else{
		echo "error1";
	}
	
?>