<?php
	include("../config.php");
	$fromdate = $_REQUEST['fromdate'];
	$fromto = $_REQUEST['todate'];
	$scheduletype = $_REQUEST['scheduletype'];
	
	/*$d1 = implode("-", array_reverse(explode("/",$fromdate)));
	if($fromto == "")	$d2 = $d1;
	else $d2 = implode("-", array_reverse(explode("/",$fromto)));*/
	
	$d1 = $fromdate;
	if($fromto == "")	$d2 = $d1;
	$d2 = $fromto;

	
	if($scheduletype == 'all') { $sql = "SELECT productname,tbl_manufacturer.manufacturername, scheduletype, patientname,tbl_billing.drname, tbl_billing.billno, qty, batchno, expirydate
FROM tbl_productlist
JOIN tbl_manufacturer ON tbl_manufacturer.id=tbl_productlist.manufacturer
JOIN tbl_billing_items ON tbl_productlist.id = tbl_billing_items.code
JOIN tbl_billing ON tbl_billing.billno = tbl_billing_items.billno WHERE tbl_billing.del_status != 1 AND tbl_billing.datentime BETWEEN '$d1' AND '$d2'"; }
	
	else { $sql = "SELECT productname,tbl_manufacturer.manufacturername, scheduletype, patientname,tbl_billing.drname, tbl_billing.billno, qty, batchno, expirydate
FROM tbl_productlist
JOIN tbl_manufacturer ON tbl_manufacturer.id=tbl_productlist.manufacturer
JOIN tbl_billing_items ON tbl_productlist.id = tbl_billing_items.code
JOIN tbl_billing ON tbl_billing.billno = tbl_billing_items.billno WHERE tbl_billing.del_status != 1 AND tbl_billing.datentime BETWEEN '$d1' AND '$d2' AND scheduletype='".$scheduletype."'"; }

		
	$array = array();
	$res = mysqli_query($db,$sql);
	
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=schedule_Report.xls");
header("Pragma: no-cache");
header("Expires: 0");

	$header = array("Drug Name","M.Name","S.Type","Patient Name","Doctor Name","Bill#","Qty", "BatchNo","Expirydate","Sign");
	echo implode("\t",$header). "\r\n";
	
	while($rs = mysqli_fetch_array($res)){
		//$xtotal += $rs['totalamt'];

		echo $rs['productname'] . "\t" .$rs['manufacturername'] . "\t" . $rs['scheduletype'] . "\t" . $rs['patientname'] . "\t"  . $rs['drname'] .  "\t" . $rs['billno'] . "\t" . $rs['qty'] . "\t" . $rs['batchno'] . "\t" .$rs['expirydate'] . "\t" . $rs['sign'] . "\t" . "\r\n";		
		
	}
	//echo "\t\t\t\tTotal\t" . number_format($xtotal,2,".","")  . "\r\n";

?>