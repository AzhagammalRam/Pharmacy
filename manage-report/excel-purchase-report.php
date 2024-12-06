<?php
	include("../config.php");
	$fromdate = $_REQUEST['fromdate'];
	$fromto = $_REQUEST['todate'];
	$paymentmode = $_REQUEST['paymentmode'];
	
	$d1 = implode("-", array_reverse(explode("/",$fromdate)));
	if($fromto == "")	$d2 = $d1;
	else $d2 = implode("-", array_reverse(explode("/",$fromto)));
	
	$sql = "SELECT * FROM tbl_purchase WHERE (invoicedate BETWEEN '$d1' AND '$d2') AND ";
	if($paymentmode == "all")
		$sql .= "invoicetype like '%' AND ";
	else
		$sql .= "invoicetype = '$paymentmode' AND ";
		
	$sql .= "status = 1";
	
	$array = array();
	$res = mysqli_query($db,$sql);
	$xtotal = 0;
	
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Purchase_Report.xls");
header("Pragma: no-cache");
header("Expires: 0");

	$header = array("Date","Bill #","Supplier Details","Payment Mode","Pending Amount","Due Date", "Bill Amount", "Paid To");
	echo implode("\t",$header). "\r\n";
	while($rs = mysqli_fetch_array($res)){
		$sup = $rs['supplierid'];
		$xtotal += $rs['invoiceamt'];
		$s = mysqli_query($db,"SELECT * FROM tbl_supplier WHERE id = $sup");
		$r = mysqli_fetch_array($s);
		$supplier = $r['suppliername'] . $r['addressline1'] . $r['addressline2'] . $r['addressline3'] . $r['contactno1'];

		echo implode("/", array_reverse(explode("-",$rs['invoicedate']))) . "\t" . $rs['invoiceno'] . "\t" . $supplier . "\t" . $rs['invoicetype'] . "\t" .  $rs['balanceamt'] . "\t" . implode("/", array_reverse(explode("-",$rs['dued']))) . "\t" . number_format($rs['invoiceamt'],2,".","") . "\t" .  $rs['payable'] . "\r\n";		
		
	}
	echo "\t\t\t\t\tTotal\t" . number_format($xtotal,2,".","")  . "\r\n";

?>