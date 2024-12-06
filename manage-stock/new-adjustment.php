<?php
	session_start();
	include("../config.php");
	$username = $_SESSION['phar-username'];
	 $storid=$_SESSION['storeid'];
	$prod = $_REQUEST['pname'];
	$prod = mysqli_escape_string($db,$prod);
	$adjtype = $_REQUEST['adjtype'];
	$avail = $_REQUEST['avail'];
	$batch = $_REQUEST['batch'];
	$mr = $_REQUEST['mr'];
	$expiry = $_REQUEST['expiry'];
	// $expiry=date_format($expiry,"Y/m/d");

	// $expiry = "27/".$expiry;
	 $expiry = implode("/",array_reverse(explode("-",$expiry)));
	
	$qty = $_REQUEST['qty'];	$temp = $qty;
	$reason = $_REQUEST['reason'];
	
	include("../config.php");
	$cmd = mysqli_query($db,"SELECT * FROM tbl_productlist WHERE productname = '$prod'");
	$rs = mysqli_fetch_array($cmd);
	$code = $rs['id'];
	$unit = $rs['unitdesc'];
	$mrp = $rs['mrp'];

	include("../config.php");
	$sqlr = mysqli_query($db,"SELECT * FROM tbl_purchaseitems WHERE status = 1 AND productid = '$code' AND batchno = '$batch' AND expirydate = '$expiry' AND branch_id='1' order by productid asc limit 1");
		$res = mysqli_fetch_array($sqlr);
		$pid = $res['id'];
		// echo "SELECT * FROM tbl_purchaseitems WHERE status = 1 AND productid = 1122 AND batchno = '6NA0006' AND expirydate = '2018/12/27' AND branch_id='1' order by productid asc limit 1";
	
	if($adjtype == 'Deletion'){
		$sql = mysqli_query($db,"SELECT * FROM tbl_purchaseitems WHERE status = 1 AND productid = $code AND batchno = '$batch' AND expirydate = '$expiry' AND branch_id='$storid'");
		while($r = mysqli_fetch_array($sql)){
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



		// $purchaseid = substr($purchaseid, 0, -1);
		for($i=0 ; $i<count($ids); $i++){
			$ii =  $ids[$i]['id'];
			$q =  $ids[$i]['qty'];
			$cmd = "UPDATE tbl_purchaseitems SET aval = aval - $q WHERE id = $ii";
			mysqli_query($db,$cmd);
		}
	}else{
		// $ss = mysqli_query($db,"SELECT AUTO_INCREMENT FROM information_schema.tables WHERE TABLE_SCHEMA = '".DATABASE."' AND TABLE_NAME = 'tbl_stockadjustment'");
		// $rr = mysqli_fetch_array($ss);
		// $purchaseid = $rr['AUTO_INCREMENT'] . '-' . $qty;
		
		// echo $cmd = "INSERT INTO tbl_purchaseitems (id, purchaseid, invoiceno, productid, qty, freeqty, batchno, expirydate, pprice, mrp, tax_amount, grossamt, netamt, aval, username, datentime, status) VALUES (NULL, '0', '0', '$code', '$qty', '0', '$batch', '$expiry', '0', '$mr', '0', '0', '0', '$qty', '$username', CURRENT_TIMESTAMP, '1')";
		// mysqli_query($db,$cmd);
		$purchaseid = substr($purchaseid, 0, -1);
		// for($i=0 ; $i<count($ids); $i++){
		// 	$ii =  $ids[$i]['id'];
		// 	$q =  $ids[$i]['qty'];
		$cmds = "UPDATE tbl_purchaseitems SET aval = aval + $qty WHERE `batchno` ='$batch' and aval='$avail' and id='$pid'";
		mysqli_query($db,$cmds);
	// }
	}
	
	$cmd = "INSERT INTO tbl_stockadjustment (productid, qty, batchno, expiry, adjtype, adjreason, purchaseid, username, datentime, status) VALUES ('$code', '$qty', '$batch', '$expiry', '$adjtype', '$reason', '$purchaseid', '$username', CURRENT_TIMESTAMP, '1')";
	if(mysqli_query($db,$cmd))
		echo 'Stock Adjusted Successfully';
	else
		echo mysqli_error($db);
?>