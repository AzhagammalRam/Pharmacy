<?php
	session_start();
	$username = $_SESSION['phar-username'];
	include('../config.php');
	
	$prod = urldecode($_REQUEST['prod']);
	$prod = mysqli_escape_string($db,$prod);
	$batch = $_REQUEST['batch'];
	
	$qty = $_REQUEST['qty'];	$temp = $qty;
	$expiry = $_REQUEST['expiry'];	$exp = $expiry;
	// $dte1=$_REQUEST['dtee'];
	// $expiry = "27/".$expiry;
	// $expiry = implode("-",array_reverse(explode("/",$expiry)));
	$bid = $_REQUEST['bid'];
	$storid=$_SESSION['storeid'];
	
	
	$cmd = mysqli_query($db,"SELECT * FROM tbl_productlist WHERE productname = '$prod'");
	$rs = mysqli_fetch_array($cmd);
	if($rs['id']){
		$code = $rs['id'];
		$type = $rs['stocktype'];
		$desc = $rs['productname'];
		$clm_type = $rs['claimtype'];
//		$desc1 =  substr($rs['stocktype'],0,3) . '. ' . $rs['productname'];
		$unit = $rs['unitdesc'];
		include('../config.php');
		$sql = mysqli_query($db,"SELECT a.qty,a.id,a.aval,a.mrp,a.tax_percentage,a.tax_type,a.tax_amount / a.qty as vatval FROM tbl_purchaseitems a join tbl_purchase b on  a.purchaseid = b.purchaseid  WHERE a.status = 1 AND a.productid = $code AND a.batchno = '$batch' AND a.expirydate = '$expiry' AND a.aval > 0");
		while($r = mysqli_fetch_array($sql)){
			$tax_percentage=$r['tax_percentage'];
			$tax_type=$r['tax_type'];
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
		$tax_amount=($amount*$tax_percentage)/100;
		$sql = "INSERT INTO tbl_billing_items (billno, bid, code, qty, batchno, expirydate,tax_percentage,tax_type,tax_amount, amount, purchaseid,  username, status,vatval, prod_cm_stat) VALUES ('', '$bid', '$code', '$qty', '$batch', '$expiry','$tax_percentage','$tax_type','$tax_amount','$amount', '$purchaseid',  '$username', '2','$vatval', '$clm_type')";
		
			
				$pur_itmid = explode('-', $purchaseid);
				$pur_id = $pur_itmid[0];
		
			
		if(mysqli_query($db,$sql)){
			// mysqli_query($db,"UPDATE tbl_billing SET datentime = '$dte1' WHERE id = '$bid'");
			for($i=0 ; $i<count($ids); $i++){
				$ii =  $ids[$i]['id'];
				$q =  $ids[$i]['qty'];
				$cmd = "UPDATE tbl_purchaseitems SET aval = aval - $q WHERE id = $ii";
				mysqli_query($db,$cmd);
			}
			$sup_sql = mysqli_fetch_array(mysqli_query($db,"select c.suppliername from tbl_purchase a join tbl_purchaseitems b on a.purchaseid = b.purchaseid join tbl_supplier c on c.id = a.supplierid where b.id = $pur_id"));
			 $sup_nm = $sup_sql['suppliername'];

			$amount =sprintf('%0.2f', round($amount,2));
			$qry1 =mysqli_fetch_array(mysqli_query($db,"select sum(amount) as amount from tbl_billing_items where bid= '$bid' and prod_cm_stat = 'CM' ")); 
			$cm_amt = $qry1['amount'];
			$qry2 =mysqli_fetch_array(mysqli_query($db,"select sum(amount) as amount from tbl_billing_items where bid= '$bid' and prod_cm_stat = 'NCM' ")); 
			$ncm_amt = $qry2['amount'];

			
          $format_dt = 'Y/m/d'; 
           $d_t = date ($format_dt, strtotime ( '+90 days' ) );
          $x_dt = date ($format_dt);
          $sup_sql = "select  distinct(c.suppliername),c.id from tbl_purchaseitems a join tbl_purchase b on a.purchaseid= b.purchaseid join tbl_supplier c on b.supplierid=c.id where a.productid = $code and a.aval >= 0 and a.expirydate >= '$x_dt'";
		  $sup_sql =mysqli_query($db,$sup_sql);

		  $rs_sup2[] = mysqli_fetch_array($sup_sql);

		  $bt_sql =mysqli_query($db,"select a.* from tbl_purchaseitems a join tbl_purchase b on a.purchaseid = b.purchaseid where a.productid = '$code' and a.aval >= 0 and a.expirydate >= '$x_dt'");
          $rs_bt[] = mysqli_fetch_array($bt_sql);

			$array = array("id" => $pid, "bid"=>$bid, "code"=>$code,"type"=>$type,"desc"=>$desc,"qty"=>$qty,"batch"=>$batch,"expi"=>$exp,"tax_percentage"=>$tax_percentage,"amt"=>number_format($amount,2),"id"=>$pid,"vatval"=>$vatval, "cm_amt"=>number_format($cm_amt,2), "ncm_amt"=>number_format($ncm_amt,2),"sup_nm"=>$sup_nm, "purchaseid"=>$purchaseid,"pur_id"=>$pur_id);

			$combinedArray = [
				'res_arr' => $array,
				'sup_arr' => $rs_sup2,
				'batch_arr' =>$rs_bt
			];

		echo json_encode($combinedArray);
			
		}else
			echo mysqli_error($db);
	}else{
		echo "error1";
	}
	
?>