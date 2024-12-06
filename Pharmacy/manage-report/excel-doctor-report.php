<?php
	include("../config.php");
	$fromdate = $_REQUEST['fromdate'];
	$fromto = $_REQUEST['todate'];
	$doc = $_REQUEST['doc'];
	
	$d1 = implode("-", array_reverse(explode("/",$fromdate)));
	if($fromto == "")	$d2 = $d1;
	else $d2 = implode("-", array_reverse(explode("/",$fromto)));
	
	$sql = "SELECT cast(datentime as date) as billdate, billno, patientname, drname, totalamt FROM tbl_billing WHERE (cast(datentime as date) BETWEEN '$d1' AND '$d2') and del_status != 1 AND ";
	if($doc == "all")
		$sql .= "drname like '%' AND ";
	else
		$sql .= "drname = '$doc' AND ";
		
	$sql .= "status = 1";
	$array = array();
	$res = mysqli_query($db,$sql);
	$xtotal = 0;
	
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Doctor_Report.xls");
header("Pragma: no-cache");
header("Expires: 0");

	$header = array("Date","Bill #", "Doctor Name", "Patient Name", "Bill Amount");
	echo implode("\t",$header). "\r\n";
	while($rs = mysqli_fetch_array($res)){
		$xtotal += $rs['totalamt'];

		echo implode("/", array_reverse(explode("-",$rs['billdate']))) . "\t" . $rs['billno'] . "\t" . $rs['drname'] . "\t" . $rs['patientname'] . "\t" . number_format($rs['totalamt'],2,".","") . "\r\n";		
		
	}
	echo "\t\t\tTotal\t" . number_format($xtotal,2,".","")  . "\r\n";

?>