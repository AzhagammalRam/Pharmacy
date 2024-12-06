<?php
	include("../config.php");
	$fromdate = $_REQUEST['fromdate'];
	$fromto = $_REQUEST['fromto'];
	//$paymentmode = $_REQUEST['paymentmode'];
	//$billtype = $_REQUEST['billtype'];
	
	// $d1 = implode("-", array_reverse(explode("/",$fromdate)));
	$d1arr = explode("/",$fromdate);
	$d1 = $d1arr[2].'-'.$d1arr[1].'-'.$d1arr[0];
	if($fromto == "")	$d2 = $d1;
	else //$d2 = implode("-", array_reverse(explode("/",$fromto)));
	$d2arr = explode("/",$fromto);
	$d2 = $d2arr[2].'-'.$d2arr[1].'-'.$d2arr[0];
	
	$sql = "SELECT sum(tax_amount) as billvat, billno,amount, datentime  FROM  tbl_billing_items WHERE (datentime BETWEEN '$d1' AND '$d2') AND status = 1 and del_status != 1 group by billno";
	
	//$sql .= "status = 1";
	$array = array();
	$res = mysqli_query($db,$sql);
	$xtotal = 0;
	while($rs = mysqli_fetch_array($res)){
		$sup = $rs['billno'];
		//echo  $rs['billno'];
		$xtotal += $rs['billvat'];
		$s ="SELECT patientname FROM tbl_billing WHERE billno = '$sup' and del_status != 1";
		$result2 = mysqli_query($db,$s);
		$r = mysqli_fetch_array($result2);
		
		$billvat = $rs['billvat'];
		$array[] = array("date"=> date('d/m/Y', strtotime($rs['datentime'])), "billno"=>$rs['billno'],"patientname"=>$r['patientname'], "amount"=>$rs['amount'],  "vat" => number_format($billvat,2,".","")); 
	}
	$array[] = array("tamt"=>number_format($xtotal,2,".",""));
	echo json_encode($array);
?>