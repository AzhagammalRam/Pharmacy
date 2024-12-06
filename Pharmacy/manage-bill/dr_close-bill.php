<?php
	$pm =  $_REQUEST['pm'];
	$id = $_REQUEST['id'];
	// $dis = $_REQUEST['dis'];
	//$remind = $_REQUEST['remind'];
	//$remind = 2;
	$Date = date('Y-m-d');
	// $rmiddate= date('Y-m-d', strtotime($Date. ' + '.$remind.' days'));
	//exit();
	include("../config.php");
	
	$billno = date("Y").$id;
	
	//$sql = mysql_query("SELECT sum(amount) as total FROM tbl_billing_items WHERE status = 2 AND bid = $id"); --- commented and replaced with tbl_drug_return_billing_items on 20-nov-2016
	
	$sql = mysql_query("SELECT sum(amount) as total FROM tbl_drug_return_billing_items WHERE bid = $id and status=8");
	$rs = mysql_fetch_array($sql);
	$amount = $rs['total'];
	$sql1=mysql_query("SELECT * FROM tbl_drug_return_billing_items WHERE bid = $id and status =8");
	// echo "SELECT * FROM tbl_drug_return_billing_items WHERE bid = $id and status =8";
	while($rs1 = mysql_fetch_array($sql1))
	{
		$quantity = $rs1['qty'];
		$code = $rs1['code'];
		$batch = $rs1['batchno'];
		$sql3 = mysql_query("UPDATE tbl_purchaseitems SET aval =aval+$quantity WHERE productid = '$code' AND batchno='$batch' ORDER BY id DESC LIMIT 1");

	}
	//if($dis !=0) {
//	$disamt=($dis/100)*($amount);
//	$disfinal=$amount-$disamt; 
//	}
	//else {
	//$disamt=0;
	//$disfinal=$amount;
	//}
//	$round = round($amount,0);
	/*
	mysql_query("UPDATE tbl_billing_items SET billno = $billno, status = 1 WHERE status = 2 AND bid = $id");
	mysql_query("UPDATE tbl_billing_items SET status = 10 WHERE status = 3 AND bid = $id");
	$sql = "UPDATE tbl_billing SET billno = $billno, status = 1, totalamt = $disfinal, netamt = $amount, paidamt = $amount, paymentmode = '$pm',discount='$disamt',disper='$dis',reminderdate='$rmiddate' WHERE (status = 2 or status = 3) AND id = $id";
	* commented by  vikram on 20th */
	
	//// added on 20th nov
	
	//mysql_query("UPDATE tbl_billing_items SET billno = $billno, status = 1 WHERE status = 2 AND bid = $id");
//	mysql_query("UPDATE tbl_billing_items SET status = 10 WHERE status = 3 AND bid = $id");
	 $sql = "UPDATE tbl_drug_return_billing SET billno = $billno, totalamt = $amount, paymentmode = '$pm', status = '1' where id = $id";
	
		/////
	
	if(mysql_query($sql))
		echo $billno;
	else
		echo mysql_error();
		
		mysql_query("UPDATE tbl_drug_return_billing_items SET billno = $billno ,status='2' WHERE bid = $id and status=8");
		// echo "UPDATE tbl_drug_return_billing_items SET billno = $billno ,status='2' WHERE bid = $id";
		$dr_qry = "select * from tbl_drug_return_billing where id = $id";
		$dr_cmd = mysql_query($dr_qry);
		$dr_1 = mysql_fetch_array($dr_cmd);
		$phno = $dr_1['phno'];
		$totamt = $dr_1['totalamt'];
		include('../config-db1.php');
		$seph="select * from `$dps_patients`.`patientdetails` where ip_id='$phno' or patientid='$phno' or contactno='$phno'";
		$selph=mysql_query($seph);
		$rowph=mysql_fetch_array($selph);
		$patient_id=$rowph['patientid'];
		$pat_name=$rowph['patientname'];
		$phup="insert into `$dps_patients`.`feesp_detailsip` (`id`,`patient_id`,`bill_number`,`pat_name`,`ip_id`,`description`,`fees`,`paid_status`,`ph_bill_no`) values (null,'$patient_id','$billno','$pat_name','$phno','Drug return charges','$totamt','3','$billno')";
    	mysql_query($phup);


?>