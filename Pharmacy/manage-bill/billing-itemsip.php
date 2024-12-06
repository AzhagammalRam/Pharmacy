<?php
	session_start();
	$username = $_SESSION['phar-username'];
	$inv_pat_id = $_REQUEST['inv_pat_id'];
	include('../config-db1.php');
    $cm = mysqli_query($db1,"SELECT * FROM `$dps_patients`.`prescriptiondetail` WHERE ip_id = '$inv_pat_id'");
	while($r = mysqli_fetch_array($cm))	
		
	$prod=$r['tablet'];
	$order=$r['order_quantity'];
	include('../config.php');
	 $cmd = mysqli_query($db,"SELECT * FROM `$pharmacydb`.`tbl_productlist` WHERE productname = '$prod'");
	$rs = mysqli_fetch_array($cmd);
		$code = $rs['id'];
		$type = $rs['stocktype'];
		$desc = $rs['productname'];
		$unit = $rs['unitdesc'];	
	$sql = mysqli_query($db,"SELECT qty,id,aval,mrp,tax_amount / qty as vatval,productid,batchno,expirydate FROM `$pharmacydb`.`tbl_purchaseitems` WHERE productid = $code ");
		while($r = mysqli_fetch_array($sql)){
			$batch=$r['batchno'];
			$exp=$r['expirydate'];
	  	$vatval=$r['vatval'];
			if($temp != 0){
				if($r['aval'] > $temp){
					$ids[] = array("id"=>$r['id'],"qty"=>$temp);
					$amount = $amount + ($temp * ($r['mrp'] / $unit));
					$temp = 0;
					break;
				}else{
					$ids[] = array("id"=>$r['id'],"qty"=>$r['aval']);
					$amount = $amount + ($r['aval'] * ($r['mrp'] / $unit));
					$temp = $temp - $r['aval'];
				}
			}else
				break;
		}
		for($i=0 ; $i<count($ids); $i++){
			$purchaseid .= $ids[$i]['id'] . '-' . $ids[$i]['qty'] .';';
		}		
		$purchaseid = substr($purchaseid, 0, -1);
		
		$ss = mysqli_query($db,"SELECT AUTO_INCREMENT FROM information_schema.tables WHERE TABLE_SCHEMA = '".DATABASE."' AND TABLE_NAME = 'tbl_billing_items'");
		$rr = mysqli_fetch_array($ss);
		$pid = $rr['AUTO_INCREMENT'];
			$array = array("code"=>$code,"type"=>$type,"desc"=>$desc,"qty"=>$qty,"batch"=>$batch,"expi"=>$exp,"amt"=>$amount,"id"=>$pid,"vatval"=>$vatval, "de"=>"");
		echo json_encode($array);
?>