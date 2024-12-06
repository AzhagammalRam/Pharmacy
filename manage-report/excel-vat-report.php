<?php
	include("../config.php");
	$fromdate = $_REQUEST['fromdate'];
	$fromto = $_REQUEST['todate'];
	
	
	$d1 = implode("-", array_reverse(explode("/",$fromdate)));
	if($fromto == "")	$d2 = $d1;
	else $d2 = implode("-", array_reverse(explode("/",$fromto)));
	
    $sql = "select sum(tax_amount) as tax_amount,netamt,purchaseid, invoiceno,datentime FROM tbl_purchaseitems where (datentime BETWEEN '$d1' AND '$d2') AND status = 1 group by invoiceno";
	//if($paymentmode == "all")
	//	$sql .= "invoicetype like '%' AND ";
	//else
		//$sql .= "invoicetype = '$paymentmode' AND ";
		
	//$sql .= "status = 1";
	
	$array = array();
	$res = mysqli_query($db,$sql);
	$xtotal = 0;
	
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Tax_Report.xls");
header("Pragma: no-cache");
header("Expires: 0");

	$header = array("Date","Bill #","Supplier Details","Payment Mode","Tax Amount", "Bill Amount");
	echo implode("\t",$header). "\r\n";
	while($rs = mysqli_fetch_array($res)){
		$xtotal += $rs['netamt'];
		$purchaseid = $rs['purchaseid'];
		$se = mysqli_query($db,"SELECT supplierid FROM tbl_purchase WHERE purchaseid = $purchaseid");
		$re = mysqli_fetch_array($se);
		$sup = $re['supplierid'];

		$s = mysqli_query($db,"SELECT * FROM tbl_supplier WHERE id = $sup");
		// echo "SELECT * FROM tbl_supplier WHERE id = $sup";
		$r = mysqli_fetch_array($s);


		$e = mysqli_query($db,"SELECT tax_amount FROM tbl_purchaseitems WHERE purchaseid='$purchaseid' AND status = 1");
	// echo "SELECT tax_amount FROM tbl_purchaseitems WHERE purchaseid='$purchaseid' AND status = 1";
		while($f = mysqli_fetch_array($e)){
		$tax_amounts += $f['tax_amount'];
		}
		$supplier = $r['suppliername'] . $r['addressline1'] . $r['addressline2'] . $r['addressline3'] . $r['contactno1'];
		echo date('d/m/Y', strtotime($rs['datentime'])) . "\t" . $rs['invoiceno'] . "\t" . $supplier . "\t" . $rs['invoicetype'] . "\t" . number_format($tax_amounts,2,".",""). "\t" . number_format($rs['netamt'],2,".","") . "\r\n";		
		
	}
	echo "\t\t\t\tTotal\t" . number_format($xtotal,2,".","")  . "\r\n";

?>