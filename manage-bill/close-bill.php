<?php
	session_start();
	$username = $_SESSION['phar-username'];
	$pm =  trim($_REQUEST['pm']);
	$id = $_REQUEST['id'];
	$dis = $_REQUEST['dis'];
	$remind = $_REQUEST['remind'];
	//$remind = 2;
	$Date = date('Y-m-d');
	$rmiddate= date('Y-m-d', strtotime($Date. ' + '.$remind.' days'));
	//exit();
	include("../config.php");
	
	$billno = date("Y").$id;
	
	$sql = mysqli_query($db,"SELECT sum(amount) as total FROM tbl_billing_items WHERE status = 2 AND bid = $id and del_status != 1");
	$rs = mysqli_fetch_array($sql);
	$amount = $rs['total'];
	if($dis !=0) {
	$disamt=($dis/100)*($amount);
	$disfinal=$amount-$disamt; 
	}
	else {
	$disamt=0;
	$disfinal=$amount;
	}
//	$round = round($amount,0);
	mysqli_query($db,"UPDATE tbl_billing_items SET billno = $billno, status = 1 WHERE status = 2 AND bid = $id and del_status != 1");
	
	 if($pm!="Credit" && $pm!="Credit-Claim")
{
	mysqli_query($db,"UPDATE tbl_billing_items SET status = 10 WHERE status = 3 AND bid = $id and del_status != 1");
	$sql = "UPDATE tbl_billing SET `billno` = '$billno', `status` = 1, `totalamt` = '$disfinal', `netamt` = '$amount', `paidamt` = '$amount', `paymentmode` = '$pm',`discount`='$disamt',`disper`='$dis',`reminderdate`='$rmiddate' WHERE (`status` = 2 or `status` = 3) AND `id` = '$id' and del_status != 1";
}
else if($pm =="Credit" || $pm =="Credit-Claim"){
	mysqli_query($db,"UPDATE tbl_billing_items SET status = 10 WHERE status = 3 AND bid = $id and del_status != 1");
	$sql = "UPDATE tbl_billing SET `billno` = '$billno', `status` = 1, `totalamt` = '$disfinal', `netamt` = '$amount', `paidamt` = '0', `balanceamt`='$amount',`paymentmode` = '$pm',`discount`='$disamt',`disper`='$dis',`reminderdate`='$rmiddate' WHERE (`status` = 2 or `status` = 3) AND `id` = '$id' and del_status != 1";
}
 if(isset($_REQUEST['ncm_pm']))
 {	
 	$ncm_pm = $_REQUEST['ncm_pm'];
 	$ncm_amt = 0;
 	$qry_2 = mysqli_query($db,"SELECT * FROM tbl_billing_items WHERE `billno` = '$billno' AND prod_cm_stat = 'NCM' ");
 	$cm_billno =  $billno.'CM';
 	if(mysqli_num_rows($qry_2) > 0)
 	{
 		$qry1 = mysqli_query($db,"SELECT * FROM tbl_billing WHERE  `id` = '$id' ");
 		while($res1 = mysqli_fetch_array($qry1))
 		{	
 			$pat_id = $res1['patientid'];
 			$pname = $res1['patientname'];
 			$dname = $res1['drname'];
 			$billda = $res1['datentime'];
 			$phno = $res1['phno'];
 			$ncm_billno = $billno.'NCM';
 			$ins_qry = mysqli_query($db,"INSERT INTO tbl_billing (billno, patientid, patientname, drname, totalamt, discount, netamt, paidamt, balanceamt, datentime, username, status,phno) VALUES ('$ncm_billno', '$pat_id', '$pname', '$dname', '0.00', '0.00', '0.00', '0.00', '0.00', '$billda', '$username', '2','$phno')");
			$rs2 = mysqli_fetch_array(mysqli_query($db,"SELECT * FROM tbl_billing WHERE `billno` = '$ncm_billno' "));
			$ncm_id = $rs2['id'];
			while ( $res2 = mysqli_fetch_array($qry_2) ) {
				$bitm_id =  $res2['id'];
				$ncm_amt +=  $res2['amount'];
				$qry3 = mysqli_query($db,"UPDATE tbl_billing_items SET billno = '$ncm_billno', bid = '$ncm_id' WHERE `billno` = '$billno' AND prod_cm_stat = 'NCM' and id = '$bitm_id'");
				}
			$qry_3 = mysqli_query($db,"UPDATE tbl_billing_items SET billno = '$cm_billno' WHERE `billno` = '$billno' AND prod_cm_stat = 'CM'");
			if($dis !=0) {
			$dis_amt=($dis/100)*($ncm_amt);
			$dis_final=$ncm_amt-$dis_amt; 
			}
			else {
			$dis_amt=0;
			$dis_final=$ncm_amt;
			}
			  if($ncm_pm!="Credit" && $ncm_pm!="Credit-Claim" && $ncm_pm!="Credit-NC")
 	{
	$qry5 = mysqli_query($db,"UPDATE tbl_billing SET  `status` = 1, `totalamt` = '$dis_final', `netamt` = '$ncm_amt', `paidamt` = '$ncm_amt', `paymentmode` = '$ncm_pm',`discount`='$dis_amt',`disper`='$dis',`reminderdate`='$rmiddate' WHERE  `id` = '$ncm_id' and del_status != 1");
}
else if($ncm_pm =="Credit" || $ncm_pm =="Credit-Claim" || $ncm_pm =="Credit-NC"){
	$qry5 = mysqli_query($db,"UPDATE tbl_billing SET `status` = 1, `totalamt` = '$dis_final', `netamt` = '$ncm_amt', `paidamt` = '0', `balanceamt`='$ncm_amt',`paymentmode` = '$ncm_pm',`discount`='$dis_amt',`disper`='$dis',`reminderdate`='$rmiddate' WHERE  `id` = '$ncm_id' and del_status != 1");
}
		$netamt = $amount - $ncm_amt;
		$disc_amt =  $disamt - $dis_amt;
		$disc_amt = abs($disc_amt);
		$totalamt = $netamt- $disc_amt;
		$balanceamt = $netamt- $disc_amt;
	$q_ry3 = mysqli_query($db,"SELECT * FROM tbl_billing_items WHERE `billno` = '$cm_billno' AND prod_cm_stat = 'CM' ");	
	if(mysqli_num_rows($q_ry3) > 0)
 	{
	if($pm === "Credit" || $pm === "Credit-Claim")
	{
		 $sql = "UPDATE tbl_billing SET `billno` = '$cm_billno', `status` = 1, `totalamt` = '$totalamt', `netamt` = '$netamt', `paidamt` = '0', `discount`='$disc_amt', `balanceamt`='$balanceamt',`paymentmode` = '$pm',`disper`='$dis',`reminderdate`='$rmiddate' WHERE (`status` = 2 or `status` = 3) AND `id` = '$id' and del_status != 1 ";
	}
	else if($pm != "Credit" || $pm != "Credit-Claim")
	{
		 $sql = "UPDATE tbl_billing SET `billno` = '$cm_billno', `status` = 1, `totalamt` = '$totalamt', `netamt` = '$netamt', `paidamt` = '$balanceamt', `discount`='$disc_amt', `balanceamt`='0',`paymentmode` = '$pm',`disper`='$dis',`reminderdate`='$rmiddate' WHERE (`status` = 2 or `status` = 3) AND `id` = '$id' and del_status != 1 ";
	}
}
}
 		// $dis_amt = 0;$dis_final=0;$disfinal=0;$netamt=0;$balanceamt=0;
 	} 
 	else{
 		$qry2 = mysqli_query($db,"SELECT * FROM tbl_billing_items WHERE `billno` = '$billno' AND prod_cm_stat = 'CM' ");
 	if(mysqli_num_rows($qry2) > 0)
 	{
 		$cm_billno =  $billno.'CM';
 		$qry_3 = mysqli_query($db,"UPDATE tbl_billing_items SET billno = '$cm_billno' WHERE `billno` = '$billno' AND prod_cm_stat = 'CM'");
 		$sql = "UPDATE tbl_billing SET `billno` = '$cm_billno', `status` = 1, `totalamt` = '$disfinal', `netamt` = '$amount', `paidamt` = '0', `balanceamt`='$amount',`paymentmode` = '$pm',`discount`='$disamt',`disper`='$dis',`reminderdate`='$rmiddate' WHERE (`status` = 2 or `status` = 3) AND `id` = '$id' and del_status != 1";
 	}
}
}
 include("../config.php");
 $sel="select * from `$pharmacydb`.`tbl_billing` where id='$id' and del_status != 1";
 $quer=mysqli_query($db,$sel);
 $res=mysqli_fetch_array($quer);
 $phno=$res['phno'];
 include('../config-db1.php');
 $seph="select * from `$dps_patients`.`patientdetails` where ip_id='$phno' or patientid='$phno' or contactno='$phno'";
 $selph=mysqli_query($db1,$seph);
 $rowph=mysqli_fetch_array($selph);
$patient_id=$rowph['patientid'];
$pat_name=$rowph['patientname'];
$isclm = mysqli_query($db,"SELECT * FROM `$pharmacydb`.`tbl_billing_items` A JOIN `$pharmacydb`.`tbl_productlist` B  ON A.code = B.id WHERE B.claimtype='CM' AND A.billno ='$billno' and A.del_status != 1");
if(mysqli_num_rows($isclm) != 0)
{
	$clm_stat=1;
}else
{
	$clm_stat=0;
}
include('../config-db1.php');
   $phup="insert into `$dps_patients`.`feesp_detailsip` (`patient_id`,`bill_number`,`pat_name`,`ip_id`,`description`,`fees`,`paid_status`,`ph_bill_no`,`claim_status`,`init_fees`) values ('$patient_id','$billno','$pat_name','$phno','pharmacy charges','$disfinal','0','$billno','$clm_stat','$disfinal')";
    mysqli_query($db1,$phup);
    $upd="update `$dps_patients`.`prescriptiondetail` set status='1' where (ip_id='$phno' OR (patientid='$phno' AND ip_id='')) AND status='2'";
    mysqli_query($db1,$upd);
    if($pm=='Cash' || $pm=='Card')
    {
    	$sup="update `$dps_patients`.`feesp_detailsip` set paid_status='1' where ip_id='$phno' AND paid_status='0' AND ph_bill_no='$billno'";
    	mysqli_query($db1,$sup);
    }
    if(isset($_REQUEST['ncm_pm']))
	 {
	 	if(mysqli_num_rows($qry_2) > 0)
 	{
 		if($ncm_pm =="Credit" || $ncm_pm =="Credit-Claim" || $ncm_pm =="Credit-NC")
 		{
	 	$phup="insert into `$dps_patients`.`feesp_detailsip` (`patient_id`,`bill_number`,`pat_name`,`ip_id`,`description`,`fees`,`paid_status`,`ph_bill_no`,`claim_status`,`init_fees`) values ('$patient_id','$billno','$pat_name','$phno','pharmacy charges','$dis_final','0','$ncm_billno','$clm_stat','$dis_final')";
    	mysqli_query($db1,$phup);
		}
	}
	$qr_y3 = mysqli_query($db,"SELECT * FROM tbl_billing_items WHERE `billno` = '$cm_billno' AND prod_cm_stat = 'CM' ");	
	if(mysqli_num_rows($qr_y3) > 0)
 	{
 		$sup1="update `$dps_patients`.`feesp_detailsip` set ph_bill_no='$cm_billno', fees = fees - '$dis_final', init_fees = fees - '$dis_final' where ip_id='$phno' AND ph_bill_no='$billno'";
    	mysqli_query($db1,$sup1);
    } else{
    	// $del = mysqli_query($db,"DELETE FROM `$pharmacydb`.`tbl_billing` WHERE id='$id'");
    	// $del1 = mysqli_query($db1,"DELETE FROM `$dps_patients`.`feesp_detailsip` WHERE ph_bill_no='$billno'");
       }
    }
$dis_amt = 0;$dis_final=0;$disfinal=0;$netamt=0;$balanceamt=0;
include("../config.php");
	if(mysqli_query($db,$sql)){
		if(isset($_REQUEST['ncm_pm']))
 		{
 			$q2 = mysqli_query($db,"SELECT * FROM tbl_billing_items WHERE `billno` = '$cm_billno' AND prod_cm_stat = 'CM' ");
 	if(mysqli_num_rows($q2) > 0)
 	{
 			$msg .= '1'.'~'.$billno.'~'.$phno.'~'.$cm_billno.'~'.$ncm_billno;
 	}else{
 		$msg .= '1'.'~'.$billno.'~'.$phno.'~'.''.'~'.$ncm_billno;
 	}
		echo $msg;
 		}else{
		$msg .= '2'.'~'.$billno.'~'.$phno;
		echo $msg;
 		}	
	}else{
		echo mysqli_error($db);
	}
?>