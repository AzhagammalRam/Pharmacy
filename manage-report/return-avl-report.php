<?php
	include("../config.php");
	$fromdate = $_REQUEST['fromdate'];
	$fromto = $_REQUEST['fromto'];
	
	
	
	$d1 = implode("-", array_reverse(explode("/",$fromdate)));
	if($fromto == "")	$d2 = $d1;
	else $d2 = implode("-", array_reverse(explode("/",$fromto)));
	
	$sql = "SELECT * FROM tbl_stockadjustment WHERE (datentime BETWEEN '$d1' AND '$d2') AND status=1";
	
	$array = array();
	$res = mysql_query($sql);
	$xtotal = 0;
	while($rs = mysql_fetch_array($res)){
	$productid=$rs['productid'];
		//$sup = $rs['supplierid'];
		$xtotal += $rs['invoiceamt'];
		$s = mysql_query("SELECT * FROM tbl_productlist WHERE id='$productid'");
		$r = mysql_fetch_array($s);
		//$supplier = $r['productname'] . '<br />'. $r['addressline1'] . '<br />'. $r['addressline2'] . '<br />'. $r['addressline3'] . '<br />'. $r['contactno1'];
		$array[] = array("date"=> implode("/", array_reverse(explode("-",date("Y-m-d"),$rs['datentime'])))), "productname"=>$r['productname'], "qty" => $rs['qty'], "batchno" => $rs['batchno'], "adjreason" => $rs['adjreason'],"expiry" => $rs['expiry'],"adjtype" => $rs['adjtype']); 
	}
	$array[] = array("tamt"=>number_format($xtotal,2,".",""));
	echo json_encode($array);
?>