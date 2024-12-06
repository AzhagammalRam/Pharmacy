<?php
	$dis =  $_REQUEST['dis'];
	$id = $_REQUEST['billno'];
	//echo $id;
	include("../config.php");
	
	//$billno = date("Y").$id;
	
	$sql = mysql_query("sELECT sum(amount) as total FROM tbl_billing_items WHERE  billno = '$id'  and del_status != 1 ");
	//echo $sql;
	$rs = mysql_fetch_array($sql);
	$amount = $rs['total'];
	$disamt=($dis/100)*($amount);
	$disfinal=$amount-$disamt;
//	$round = round($amount,0);
	
		echo $disfinal;
	
?>