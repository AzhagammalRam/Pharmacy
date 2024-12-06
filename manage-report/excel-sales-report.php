<?php
	include("../config.php");
	$fromdate = $_REQUEST['fromdate'];
	$fromto = $_REQUEST['todate'];
	$paymentmode = $_REQUEST['paymentmode'];
	
	$d1 = implode("-", array_reverse(explode("/",$fromdate)));
	if($fromto == "")	$d2 = $d1;
	else $d2 = implode("-", array_reverse(explode("/",$fromto)));
	
	$sql = "SELECT cast(datentime as date) as billdate, billno, patientname, drname, totalamt, paymentmode FROM tbl_billing WHERE (cast(datentime as date) BETWEEN '$d1' AND '$d2') and del_status != 1 AND ";
	if($paymentmode == "all")
		$sql .= "paymentmode like '%' AND ";
	else
		$sql .= "paymentmode = '$paymentmode' AND ";
		
	$sql .= "status = 1";
	$array = array();
	$res = mysqli_query($db,$sql);
	$xtotal = 0;
	
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Sales_Report.xls");
header("Pragma: no-cache");
header("Expires: 0");

	$header = array("Date","Bill #","Patient Name","Doctor Name","Payment Mode", "Bill Amount");
	echo implode("\t",$header). "\r\n";
	while($rs = mysqli_fetch_array($res)){
		$xtotal += $rs['totalamt'];

		echo implode("/", array_reverse(explode("-",$rs['billdate']))) . "\t" . $rs['billno'] . "\t" . $rs['patientname'] . "\t" . $rs['drname'] . "\t" . $rs['paymentmode'] . "\t" . number_format($rs['totalamt'],2,".","") . "\r\n";		
		
	}
	$sql_return = "SELECT cast(datentime as date) as billdate,drname , phno, patientname,  billno, totalamt, paymentmode FROM tbl_drug_return_billing WHERE (datentime BETWEEN '$d1' AND '$d2') ";
	if($paymentmode == "all")
		$sql_return .= "";
	else
		$sql_return .= "AND paymentmode = '$paymentmode' ";
	
	$xtotal_return =0;
	$res_return = mysqli_query($db,$sql_return);
	while($rs_return = mysqli_fetch_array($res_return)){
		
		$xtotal_return += $rs_return['totalamt'];		
	}
	$GrandTotal=$xtotal-$xtotal_return;
	echo "\t\t\t\tTotal return\t" . number_format(-$xtotal_return.' (return)',2,".","")  . "\r\n";
	echo "\t\t\t\tTotal Sales\t" . number_format($xtotal,2,".","")  . "\r\n";
	echo "\t\t\t\tGrand Total\t" . number_format($GrandTotal,2,".","")  . "\r\n";

?>