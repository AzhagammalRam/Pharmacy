<?php
	include("../config.php");
	$fromdate = $_REQUEST['fromdate'];
	$fromto  = $_REQUEST['todate'];
	$pro = $_REQUEST['productname'];
	
	$d1 = implode("-", array_reverse(explode("/",$fromdate)));
	if($fromto == "")	$d2 = $d1;
	else $d2 = implode("-", array_reverse(explode("/",$fromto)));

	$sql1="SELECT tbl_productlist.id, tbl_productlist.productname, tbl_productlist.genericname, tbl_purchaseitems.productid, tbl_purchaseitems.batchno, tbl_purchaseitems.expirydate, tbl_purchaseitems.mrp,tbl_purchaseitems.datentime, tbl_billing_items.batchno, tbl_billing_items.qty, tbl_billing_items.billno, tbl_billing.billno, tbl_billing.patientname, tbl_billing.datentime
		FROM tbl_productlist
		JOIN tbl_purchaseitems ON tbl_productlist.id = tbl_purchaseitems.productid
		JOIN tbl_billing_items ON tbl_purchaseitems.batchno = tbl_billing_items.batchno
		JOIN tbl_billing ON tbl_billing_items.billno = tbl_billing.billno
		WHERE tbl_purchaseitems.datentime BETWEEN '$d1' AND '$d2' AND tbl_billing.del_status != 1 AND ";
	if($pro == "all")
		$sql1 .= "productname like '%'  ";
	else
		$sql1 .= "productname = '$pro'  ";

	$sql="SELECT tbl_productlist.id, tbl_productlist.productname, tbl_productlist.genericname, tbl_purchaseitems.productid, tbl_purchaseitems.qty, tbl_purchaseitems.batchno, tbl_purchaseitems.expirydate, tbl_purchaseitems.mrp, tbl_purchaseitems.username, tbl_purchase.invoicedate, tbl_purchase.invoiceno, tbl_supplier.id, tbl_supplier.suppliername FROM tbl_productlist JOIN tbl_purchaseitems ON tbl_productlist.id = tbl_purchaseitems.productid JOIN tbl_purchase ON tbl_purchaseitems.purchaseid = tbl_purchase.purchaseid JOIN tbl_supplier ON tbl_purchase.supplierid = tbl_supplier.id
 WHERE tbl_purchase.invoicedate BETWEEN  '$d1' AND '$d2' AND ";
	
	if($pro == "all")
		$sql .= "productname like '%'  ";
	else
		$sql .= "productname = '$pro'  ";
		
	

	
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=PF_Report.xls");
header("Pragma: no-cache");
header("Expires: 0");



	echo "PF Reports \n";
	$header = array("Generic Name","P.Inv No","Supplier","Qty/strip", "Bat.no", "Ex.Date", "MRP", "Inv.Date", "Entered By");
	echo implode("\t",$header). "\r\n";

	$res = mysqli_query($db,$sql);
	$xtotal = 0;
	while($rs = mysqli_fetch_array($res)){

		echo $rs['genericname'] . "\t" . $rs['invoiceno'] . "\t" . $rs['suppliername'] . "\t" . $rs['qty'] . "\t" . $rs['batchno'] . "\t" . $rs['expirydate']. "\t" . $rs['mrp'] . "\t" . $rs['invoicedate'] . "\t" . $rs['username'] . "\r\n";		
		
	}

	
	echo "\n";
	$header1 = array("Patient Name","Bill No","Qty/unit","Bat.No", "Ex.Date", "MRP", "Bill.date");
	echo implode("\t",$header1). "\r\n";

	$res1 = mysqli_query($db,$sql1);
	$xtotal = 0;
	while($rs1 = mysqli_fetch_array($res1)){

		echo $rs1['patientname'] . "\t" . $rs1['billno'] . "\t" . $rs1['qty'] . "\t" . $rs1['batchno'] . "\t" . $rs1['expirydate'] . "\t" . $rs1['mrp']. "\t" . $rs1['datentime'] . "\r\n";		
		
	}
?>