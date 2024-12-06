<?php
	//$type = $_REQUEST['type'];
	$prod = urldecode($_REQUEST['prod']);
	include('../config.php');
	$prod = mysqli_escape_string($db,$prod);
        $storid=$_SESSION['storeid'];
        $format = 'Y/m/d '; 
	$d = date ( $format, strtotime ( '+90 days' ) );
	$x = date ( $format);

	$cmd = mysqli_query($db,"SELECT id FROM tbl_productlist WHERE productname = '$prod'");
	$rs = mysqli_fetch_array($cmd);
	if($rs['id']){
		$id = $rs['id'];
		$sql = mysqli_query($db,"SELECT distinct(c.id),c.suppliername FROM tbl_purchaseitems a join tbl_purchase b on a.purchaseid = b.purchaseid join tbl_supplier c on b.supplierid =c.id WHERE productid = $id AND a.branch_id='$storid'  AND a.aval > 0 AND a.expirydate >= '$x' order by a.expirydate asc");
		$array = array();
		while($r = mysqli_fetch_array($sql)){
			array_push($array, array("sup_nm"=>$r['suppliername'],"sup_id"=>$r['id']));
		}
		echo json_encode($array);
	}else{
		echo "error1";
	}
	
?>