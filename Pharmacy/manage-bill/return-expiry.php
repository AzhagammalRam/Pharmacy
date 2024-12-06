<?php
	$prod = urldecode($_REQUEST['prod']);
	include('../config.php');
	$prod = mysqli_escape_string($db,$prod);
	$batch = $_REQUEST['batch'];
	$format = 'Y/m/d '; 
	$d = date ( $format, strtotime ( '+90 days' ) );
	$x = date ( $format);
	$storid=$_SESSION['storeid'];
	$cmd = mysqli_query($db,"SELECT id FROM tbl_productlist WHERE productname = '$prod'");
	$rs = mysqli_fetch_array($cmd);
	if($rs['id']){
		$id = $rs['id'];
		$array = array();
		$sql = mysqli_query($db,"SELECT distinct a.expirydate as exp_dt, c.suppliername,c.id FROM tbl_purchaseitems a join tbl_purchase b on a.purchaseid = b.purchaseid join tbl_supplier c on b.supplierid =c.id WHERE a.status = 1 AND a.productid = $id AND a.batchno = '$batch' AND a.aval > 0 AND a.branch_id='$storid' ");
		//$array = array();
		//while($r = mysqli_fetch_array($sql)){
		//	$expirydate = implode("/",array_reverse(explode("-",$r['expirydate'])));
		//	$expiry = substr($expirydate,3);
			//array_push($array, array($expiry));
		//}`
		//echo json_encode($array);

$r = mysqli_fetch_array($sql);
 $exp=$r['exp_dt'];
 $sup_nm = $r['suppliername'];
 $sup_id = $r['id'];
 $dexp = date ( $format, strtotime ($exp) );
 			if($dexp>= $d) 
			{
				$expval=1;
			} 
			else if($dexp< $d)
			{
				$expval=0;
			}


$expirydate = implode("/",explode("-",$exp));
array_push($array, array("expirydate"=>$expirydate,"expval"=>$expval,"sup_nm"=>$sup_nm,"sup_id"=>$sup_id));
echo json_encode($array);
	}else{
		echo "error1";
	}
	
?>