<?php
	include("../config.php");
	$fromdate = $_REQUEST['fromdate'];
	$fromto = $_REQUEST['fromto'];
	$stfrom = $_REQUEST['stfrom'];
	$stto = $_REQUEST['stto'];
	/*$d1 = implode("-", array_reverse(explode("/",$fromdate)));
	if($fromto == "")	$d2 = $d1;
	else $d2 = implode("-", array_reverse(explode("/",$fromto)));*/
	
	$d1 = $fromdate;
	if($fromto == "")	$d2 = $d1;
	$d2 = $fromto;
	

	$sql= "select * from tbl_stock_transfer where (store_from= '$stfrom' AND store_to= '$stto') AND datestamp BETWEEN '$d1' AND '$d2'";
	// $sql = "SELECT cast(datentime as date) as billdate, billno, patientname, drname, totalamt, paymentmode FROM tbl_billing WHERE (datentime BETWEEN '$d1' AND '$d2') AND ";
	// if($paymentmode == "all")
	// 	$sql .= "paymentmode like '%' AND ";
	// else
	// 	$sql .= "paymentmode = '$paymentmode' AND ";
		
	// $sql .= "status = 1";
	$array = array();
	$res = mysqli_query($db,$sql);
	// $xtotal = 0;

	while($rs = mysqli_fetch_array($res)){
		// $xtotal += $rs['totalamt'];
		$array[] = array("invoice"=> $rs['id'],"store_from"=> $rs['store_from'], "store_to"=>$rs['store_to']); 
	}
	// $array[] = array("tamt"=>number_format($xtotal,2,".",""));
	echo json_encode($array);
?>