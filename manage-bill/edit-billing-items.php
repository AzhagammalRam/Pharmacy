<?php
	session_start();
	$username = $_SESSION['phar-username'];
	include('../config.php');
	$prod = urldecode($_REQUEST['prod']);
	$prod = mysqli_escape_string($db,$prod);
	$batch = $_REQUEST['batch'];
	$qty = $_REQUEST['qty'];	$temp = $qty;
	$expiry = $_REQUEST['expiry'];	
	$exp = $expiry;
 	// echo $exp = "27/".$expiry;
  	$exp = implode("/",array_reverse(explode("/",$exp)));
  	$exp = substr($exp,3);
  	
	$storid=$_SESSION['storeid'];
	$billno = $_REQUEST['billno'];
	
	include('../config.php');
	
	$s1 = mysqli_query($db,"SELECT id FROM tbl_billing WHERE billno = '$billno' and del_status != 1");
	$rq1 = mysqli_fetch_array($s1);
	$bid = $rq1['id'];
	
	$cmd = mysqli_query($db,"SELECT * FROM tbl_productlist WHERE productname = '$prod'");
	$rs = mysqli_fetch_array($cmd);
	if($rs['id']){
		$code = $rs['id'];
		$desc = $rs['productname'];
		$unit = $rs['unitdesc'];
		$sql = mysqli_query($db,"SELECT * FROM tbl_purchaseitems WHERE status = 1 AND productid = $code AND batchno = '$batch' AND expirydate = '$expiry' AND branch_id='$storid'  ");
		while($r = mysqli_fetch_array($sql)){
			if($temp != 0){
				if($r['aval'] > $temp){
					$ids[] = array("id"=>$r['id'],"qty"=>$temp);
					$amount = $amount + ($temp * ($r['mrp'] / $unit));
					$amount = round($amount,2);
					$temp = 0;
					break;
				}else{
					$ids[] = array("id"=>$r['id'],"qty"=>$r['aval']);
					$amount = $amount + ($r['aval'] * ($r['mrp'] / $unit));
					$amount = round($amount,2);
					$temp = $temp - $r['aval'];
				}
			}else
				break;
		}
		for($i=0 ; $i<count($ids); $i++){
			$purchaseid .= $ids[$i]['id'] . '-' . $ids[$i]['qty'] . ';';
		}		
		$purchaseid = substr($purchaseid, 0, -1);
		
		$ss = mysqli_query($db,"SELECT AUTO_INCREMENT FROM information_schema.tables WHERE TABLE_SCHEMA = '".DATABASE."' AND TABLE_NAME = 'tbl_billing_items'");
		$rr = mysqli_fetch_array($ss);
		$pid = $rr['AUTO_INCREMENT'];
		
		 $sql = "INSERT INTO tbl_billing_items (id, billno, bid, code, qty, batchno, expirydate, amount, purchaseid, datentime, username, status) VALUES (NULL, '$billno', '$bid', '$code', '$qty', '$batch', '$expiry', '$amount', '$purchaseid', CURRENT_TIMESTAMP, '$username', '8')";
		if(mysqli_query($db,$sql)){
			for($i=0 ; $i<count($ids); $i++){
				$ii =  $ids[$i]['id'];
				$q =  $ids[$i]['qty'];
				$cmd = "UPDATE tbl_purchaseitems SET aval = aval - $q WHERE id = $ii";
				mysqli_query($db,$cmd);
			}
			$cmd = "UPDATE tbl_billing SET totalamt = totalamt + $amount, netamt = netamt + $amount, paidamt = paidamt + $amount WHERE id = $bid and del_status != 1";
			mysqli_query($db,$cmd);
			$array = array("code"=>$code,"desc"=>$desc,"qty"=>$qty,"batch"=>$batch,"expi"=>$exp,"amt"=>$amount,"id"=>$pid);
			echo json_encode($array);
		}else
			echo mysqli_error($db);
	}else{
		echo "error1";
	}
	
?>