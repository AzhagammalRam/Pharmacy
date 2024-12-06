<?php
	$dis =  $_REQUEST['dis'];
	$id = $_REQUEST['bid'];
	
	include("../config.php");
	
	//$billno = date("Y").$id;
	
	$sql = mysqli_query($db,"SELECT sum(amount) as total FROM tbl_billing_items WHERE status = 2 AND bid = $id  and del_status != 1");
	$rs = mysqli_fetch_array($sql);
	$amount = $rs['total'];
	$disamt=($dis/100)*($amount);
	$disfinal=$amount-$disamt;
	$sql1 =  mysqli_query($db,"SELECT sum(amount) as total FROM tbl_billing_items WHERE status = 2 AND bid = $id  and del_status != 1 AND prod_cm_stat = 'NCM' ");
	$rs1 = mysqli_fetch_array($sql1);
	$amountncm = $rs1['total'];
	if($amountncm=='')
	{
		$amountncm=0;
	}
	$disamtncm=($dis/100)*($amountncm);
	$disfinalncm=$amountncm-$disamtncm;
	$sql2 =  mysqli_query($db,"SELECT sum(amount) as total FROM tbl_billing_items WHERE status = 2 AND bid = $id  and del_status != 1 AND prod_cm_stat = 'CM' ");
	$rs2 = mysqli_fetch_array($sql2);
	$amountcm = $rs2['total'];
	if($amountcm=='')
	{
		$amountcm=0;
	}
	$disamtcm=($dis/100)*($amountcm);
	$disfinalcm=$amountcm-$disamtcm;
//	$round = round($amount,0);
	
		echo $disfinal.'~'.$disamt.'~'.$disfinalncm.'~'.$disamtncm.'~'.$disfinalcm.'~'.$disamtcm;
	
?>