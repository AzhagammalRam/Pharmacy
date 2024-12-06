
<?php
/* used to insert the items that are returned in Drug Return --- 20-Nov-2016*/
	session_start();
	$username = $_SESSION['phar-username'];
	require_once('../config.php');
	$prod = urldecode($_REQUEST['prod']);
	$prod = mysql_escape_string($prod);
	$batch = $_REQUEST['batch'];
	$storid=$_SESSION['storeid'];
	$qty = $_REQUEST['qty'];	$temp = $qty;
	$expiry = $_REQUEST['expiry'];	$exp = $expiry;
	//$expiry = "27/".$expiry;
	//$expiry = implode("-",array_reverse(explode("/",$expiry)));
	
	$bid = $_REQUEST['bid'];
	$amount =0;
	$purchaseid="";
	
	
	
	$cmd = mysql_query("SELECT * FROM tbl_productlist WHERE productname = '$prod'");
	$rs = mysql_fetch_array($cmd);
	if($rs['id']){
		$code = $rs['id'];
		$type = $rs['stocktype'];
		$desc = $rs['productname'];
//		$desc1 =  substr($rs['stocktype'],0,3) . '. ' . $rs['productname'];
		$unit = $rs['unitdesc'];
		$sql = mysql_query("SELECT qty,id,aval,mrp,tax_amount / qty as vatval FROM tbl_purchaseitems WHERE status = 1 AND productid = $code AND batchno = '$batch' AND expirydate = '$expiry'  AND branch_id='$storid'");
		while($r = mysql_fetch_array($sql)){
		$vatval=$r['vatval'];
			if($temp != 0){
				if($r['aval'] > $temp){
					$ids[] = array("id"=>$r['id'],"qty"=>$temp);
					$amount = $amount + ($temp * ($r['mrp'] / $unit));
					$temp = 0;
					break;
				}else{
					$ids[] = array("id"=>$r['id'],"qty"=>$temp);
					$amount = $amount + ($temp * ($r['mrp'] / $unit));
					$temp = 0;
				}
			}else
				break;
		}
		for($i=0 ; $i<count($ids); $i++){
			$purchaseid .= $ids[$i]['id'] . '-' . $ids[$i]['qty'] .';';
		}		
		$purchaseid = substr($purchaseid, 0, -1);
		
		$ss = mysql_query("SELECT AUTO_INCREMENT FROM information_schema.tables WHERE TABLE_SCHEMA = '".DATABASE."' AND TABLE_NAME = 'tbl_drug_return_billing_items'");
		$rr = mysql_fetch_array($ss);
		$pid = $rr['AUTO_INCREMENT'];
			
		/// changed
		//$sql = "INSERT INTO tbl_billing_items (id, billno, bid, code, qty, batchno, expirydate, amount, purchaseid, datentime, username, status,vatval) VALUES (NULL, '', '$bid', '$code', '$qty', '$batch', '$expiry', '$amount', '$purchaseid', CURRENT_TIMESTAMP, '$username', '2','$vatval')";
		
		
		$sql = "INSERT INTO tbl_drug_return_billing_items (id, billno, bid, code, qty, batchno, expirydate, amount, purchaseid, datentime, username, status,vatval) VALUES (NULL, '', '$bid', '$code', '$qty', '$batch', '$expiry', '$amount', '$purchaseid', CURRENT_TIMESTAMP, '$username', '8','$vatval')";
		if(mysql_query($sql)){
			for($i=0 ; $i<count($ids); $i++){
				$ii =  $ids[$i]['id'];
				$q =  $ids[$i]['qty'];
				//$cmd = "UPDATE tbl_purchaseitems SET aval = aval - $q WHERE id = $ii";
				
				// $cmd = "UPDATE tbl_purchaseitems SET aval = aval + $q WHERE id = $ii";  //---- changed from - to +
				
				
				// mysql_query($cmd);
			}
			$array = array("code"=>$code,"type"=>$type,"desc"=>$desc,"qty"=>$qty,"batch"=>$batch,"expi"=>$exp,"amt"=>$amount,"id"=>$pid,"vatval"=>$vatval);
			echo json_encode($array);
		}else
			echo mysql_error();
	}else{
		echo "error1";
	}
	
?>