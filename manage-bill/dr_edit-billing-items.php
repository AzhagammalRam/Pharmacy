<?php
	session_start();
	$username = $_SESSION['phar-username'];
	
	$prod = urldecode($_REQUEST['prod']);
	$prod = mysql_escape_string($prod);
	$batch = $_REQUEST['batch'];
	$qty = $_REQUEST['qty'];	$temp = $qty;
	$expiry = $_REQUEST['expiry'];	$exp = $expiry;
	$expiry = "27/".$expiry;
	$expiry = implode("-",array_reverse(explode("/",$expiry)));
		$storid=$_SESSION['storeid'];
	$billno = $_REQUEST['billno'];
	
	include('../config.php');
	
	$s1 = mysql_query("SELECT id FROM tbl_billing WHERE billno = '$billno' and del_status != 1");
	$rq1 = mysql_fetch_array($s1);
	$bid = $rq1['id'];
	
	$cmd = mysql_query("SELECT * FROM tbl_productlist WHERE productname = '$prod'");
	$rs = mysql_fetch_array($cmd);
	if($rs['id']){
		$code = $rs['id'];
		$desc = $rs['productname'];
		$unit = $rs['unitdesc'];
		$sql = mysql_query("SELECT * FROM tbl_purchaseitems WHERE status = 1 AND productid = $code AND batchno = '$batch' AND expirydate = '$expiry'  AND branch_id='$storid'");
		while($r = mysql_fetch_array($sql)){
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
			$purchaseid .= $ids[$i]['id'] . '-' . $ids[$i]['qty'] . ';';
		}		
		$purchaseid = substr($purchaseid, 0, -1);
		
		$ss = mysql_query("SELECT AUTO_INCREMENT FROM information_schema.tables WHERE TABLE_SCHEMA = '".DATABASE."' AND TABLE_NAME = 'tbl_billing_items'");
		$rr = mysql_fetch_array($ss);
		$pid = $rr['AUTO_INCREMENT'];
		
		$sql = "INSERT INTO tbl_billing_items (id, billno, bid, code, qty, batchno, expirydate, amount, purchaseid, datentime, username, status) VALUES (NULL, '$billno', '$bid', '$code', '$qty', '$batch', '$expiry', '$amount', '$purchaseid', CURRENT_TIMESTAMP, '$username', '8')";
		if(mysql_query($sql)){
			for($i=0 ; $i<count($ids); $i++){
				$ii =  $ids[$i]['id'];
				$q =  $ids[$i]['qty'];
				$cmd = "UPDATE tbl_purchaseitems SET aval = aval - $q WHERE id = $ii";
				mysql_query($cmd);
			}
			$cmd = "UPDATE tbl_billing SET totalamt = totalamt + $amount, netamt = netamt + $amount, paidamt = paidamt + $amount WHERE id = $bid and del_status != 1";
			mysql_query($cmd);
			$array = array("code"=>$code,"desc"=>$desc,"qty"=>$qty,"batch"=>$batch,"expi"=>$exp,"amt"=>$amount,"id"=>$pid);
			echo json_encode($array);
		}else
			echo mysql_error();
	}else{
		echo "error1";
	}
	
?>