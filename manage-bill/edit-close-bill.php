<?php
	session_start();
	$username = $_SESSION['phar-username'];
	$pm =  $_REQUEST['pm'];
	$billno = $_REQUEST['billno'];
	$discount = $_REQUEST['discount'];
	$assets = $_REQUEST['assets'];
	include("../config.php");
	$sql = mysqli_query($db,"select sum(amount) as total FROM tbl_billing_items WHERE  billno = '$billno' and del_status != 1 ");
	
	$rs = mysqli_fetch_array($sql);
	$amount = $rs['total'];
	$disamt=($dis/100)*($amount);
	$disfinal=$amount-$disamt;
	$sqlr = "select * from tbl_billing WHERE  billno = '$billno' and del_status != 1";
	$rsst= mysqli_query($db,$sqlr);
	$rsr = mysqli_fetch_array($rsst);
	$patientname=$rsr['patientname'];
	$phno=$rsr['phno'];
	$drname=$rsr['drname'];
	$totalamt=$rsr['totalamt'];
	$paymentmode=$rsr['paymentmode'];
	$discount=$rsr['discount'];
	$dispers=$rsr['disper'];
	$count = 0;
	foreach($assets as $asset => $key){
		$qty = $key[5];
	$perprice=$amount/$qty;
	$totalprice=$perprice*$returnqty;
	if ($key[0]==1)  
	{
		$count = $count + 1;
	}
	}
	 if($count == 0)
	 {
	 	$sql = mysqli_query($db,"UPDATE tbl_billing SET paymentmode = '$pm' WHERE billno = '$billno' and del_status != 1");
	 	if($sql)
	 	{
	 		echo '1';
	 	}
	 } 
	 else{
	 $cmd = "INSERT INTO tbl_sales_return_billing ( `billno`, `patientname`, `phno`,`drname`,`paymentmode`,`discount`,`disper`, `datentime`, `status`, `created_by`) VALUES ( '$billno', '$patientname', '$phno', '$drname', '$paymentmode','$discount','$dispers',CURRENT_TIMESTAMP, '1', '$username')";
	mysqli_query($db,$cmd);
	$ids = mysqli_insert_id($db);


	 $sql = "select * from tbl_billing_items WHERE status = 8 AND billno = '$billno' and del_status != 1";
	$rst= mysqli_query($db,$sql);
	while($rse = mysqli_fetch_array($rst)){
	$quantity=$rse['qty'];
	$code=$rse['code'];
	$batch=$rse['batchno'];
	$expirydate=$rse['expirydate'];
	$pamount=$rse['amount'];
	$tax_amount=$rse['tax_amount'];
	$tax_percentage=$rse['tax_percentage'];
	$tax_type=$rse['tax_type'];
	$purchaseid=$rse['purchaseid'];
	$pur_ref_id = explode("-", $purchaseid);
	$pur_ref_id = $pur_ref_id[0];
	$ret_qty = $rse['returnqty'];
		$bid=$rse['bid'];
foreach($assets as $asset => $key){
	$perprice=$amount/$qty;
	$totalprice=$perprice*$returnqty;
	if ($key[0]==1 && $key[3]==$code && $key[7]==$batch)  
	{
		$perprice=$pamount/$quantity;
	$totalprice=$perprice*$key[6];
	if(!(($key[5]+$ret_qty)>$quantity))
	{
		$cmd = "INSERT INTO tbl_sales_return_billing_items (`billno`, `bid`,`code`,`batchno`,`qty`,`returnqty`,`amount`,`taxamount`,`tax_type`,`tax_percentage`,`expirydate`, `purchaseid`, `datentime`, `status`, `username`) VALUES ( '$billno', '$ids', '$code', '$batch', '$quantity','$key[5]', '$totalprice', '$tax_amount','$tax_type', '$tax_percentage', '$expirydate', '$purchaseid',CURRENT_TIMESTAMP, '1', '$username')";
		$cmd1 = mysqli_query($db,$cmd);
		 
		}

	if(!(($key[5]+$ret_qty)>$quantity))
	{
		mysqli_query($db,"UPDATE `tbl_purchaseitems` SET `aval` =aval+$key[5] WHERE `productid` = '$code' AND `batchno`='$batch'AND `expirydate`='$expirydate' AND `id`='$pur_ref_id'");
	}

	if(($key[5]+$ret_qty)==$quantity)
	{
		mysqli_query($db,"UPDATE tbl_billing_items SET `status` = 0, `returnqty`=($key[5]+$ret_qty) WHERE status = 8 AND billno = '$billno' and `code`='$code' AND `expirydate`='$expirydate' and del_status != 1");
	}
	elseif(($key[5]+$ret_qty) < $quantity)
	{
		mysqli_query($db,"UPDATE tbl_billing_items SET `returnqty`=($key[5]+$ret_qty) WHERE status = 8 AND billno = '$billno' and `code`='$code' AND `expirydate`='$expirydate' and del_status != 1");
	}

	}
		}
		}
	 include("../config.php");
    $sel="select * from `$pharmacydb`.`tbl_billing` where `billno`='$billno' and del_status != 1";
    $quer=mysqli_query($db,$sel);
    $res=mysqli_fetch_array($quer);
    $phno=$res['phno'];
	
// if ($key==1){	
	include("../config.php");
	$amt_qry =  mysqli_query($db,"SELECT sum(amount) as amount FROM tbl_sales_return_billing_items WHERE billno ='$billno' AND bid = '$ids'");
	$amt_cmd = mysqli_fetch_array($amt_qry);
	$tot_amt = $amt_cmd['amount'];
	$discountedamount=($dispers/100)*($tot_amt);
	$finalamount=$tot_amt-$discountedamount;
	mysqli_query($db,"UPDATE tbl_sales_return_billing SET `totalamt`='$tot_amt',finalamt='$finalamount',`discount`='$discountedamount' WHERE  billno = '$billno' AND id = '$ids'");



	$qry = "SELECT sum(qty) as tot_qty,sum(returnqty) as tot_retqty  FROM tbl_billing_items WHERE `billno`='$billno' and del_status != 1";
	$cmd_qry = mysqli_query($db,$qry);
	 $qry_res=mysqli_fetch_array($cmd_qry);
	 $tot_qty = $qry_res['tot_qty'];
	 $tot_retqty = $qry_res['tot_retqty'];
	if($tot_qty==$tot_retqty){
	$sql = "UPDATE tbl_billing SET status = 0,disper='$discount',paymentmode = '$pm' WHERE status = 8 AND billno = '$billno' and del_status != 1";
	if(mysqli_query($db,$sql)){
		
		$msg .= $billno.'~'.$phno.'~'.$ids;
			echo $msg;
	}else{
		echo mysqli_error($db);
	}
	}else
	{	
		$msg .= $billno.'~'.$phno.'~'.$ids;
		
			echo $msg;
	}
}
?>