<?php
	include("../config.php");
	$fromdate = $_REQUEST['fromdate'];
	$fromto = $_REQUEST['fromto'];
	$scheduletype = $_REQUEST['scheduletype'];
	//$billtype = $_REQUEST['billtype'];
	/*
	$d1 = implode("-", array_reverse(explode("/",$fromdate)));
	if($fromto == "")	$d2 = $d1;
	else $d2 = implode("-", array_reverse(explode("/",$fromto)));*/
	
	
	$d1 = $fromdate;
	if($fromto == "")	$d2 = $d1;
	$d2 = $fromto;
	
	include("../config.php");
	if($scheduletype == 'all') { $sql = "SELECT productname,tbl_manufacturer.manufacturername, scheduletype, patientname,tbl_billing.drname, tbl_billing.billno, qty, batchno, expirydate
FROM tbl_productlist
JOIN tbl_manufacturer ON tbl_manufacturer.id=tbl_productlist.manufacturer
JOIN tbl_billing_items ON tbl_billing_items.code = tbl_productlist.id
JOIN tbl_billing ON tbl_billing.billno = tbl_billing_items.billno WHERE tbl_billing.del_status != 1 AND tbl_billing.datentime BETWEEN '$d1' AND '$d2'"; }
	
	else { $sql = "SELECT productname,tbl_manufacturer.manufacturername, scheduletype, patientname,tbl_billing.drname, tbl_billing.billno, qty, batchno, expirydate
FROM tbl_productlist
JOIN tbl_manufacturer ON tbl_manufacturer.id=tbl_productlist.manufacturer
JOIN tbl_billing_items ON tbl_billing_items.code = tbl_productlist.id
JOIN tbl_billing ON tbl_billing.billno = tbl_billing_items.billno WHERE tbl_billing.del_status != 1 AND tbl_billing.datentime BETWEEN '$d1' AND '$d2' AND scheduletype='".$scheduletype."'"; }

	
	$array = array();
	$res = mysqli_query($db,$sql);
	$xtotal = 0;
	while($rs = mysqli_fetch_array($res)){

		$array[] = array('productname'=> $rs['productname'],'manufacturername'=> $rs['manufacturername'],'scheduletype'=> $rs['scheduletype'],'drname'=> $rs['drname'],'patientname'=> $rs['patientname'],'billno'=> $rs['billno'],'qty'=> $rs['qty'],'batchno'=> $rs['batchno'],'expirydate'=> $rs['expirydate']); 
	}
	//$array[] = array("tamt"=>number_format($xtotal,2,".",""));
	echo json_encode($array);
	
	
?>