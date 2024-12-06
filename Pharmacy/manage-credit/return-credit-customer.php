<?php
	require_once("../config.php");
	$fromdate = $_REQUEST['fromdate'];
	$fromto = $_REQUEST['fromto'];
	$invoiceno = $_REQUEST['invoiceno'];
	$patientid = $_REQUEST['supplier'];
	
//	$sqlsupp = mysqli_query($db,"SELECT * FROM tbl_supplier WHERE suppliername = '$supplier'");
//	$ressup = mysqli_fetch_array($sqlsupp);
//	$supplierid=$ressup['id'];
	
	/*$d1 = implode("-", array_reverse(explode("/",$fromdate)));
	if($fromto == "")	$d2 = $d1;
	else $d2 = implode("-", array_reverse(explode("/",$fromto)));*/
	
	
	$d1 = $fromdate .' 00:00:00';
	$d2 = $fromto .' 23:59:59';
	if($fromto == "")
	{
	
		$d2 = $fromdate .' 23:59:59';
	}
	
	
	$sql = "SELECT cast(datentime as date) as invoicedate, id, billno,netamt, balanceamt  FROM tbl_billing WHERE   paymentmode='Credit' AND balanceamt > 0 and del_status != 1";
	if ($supplier!='')
	{
	$sql .= " AND phno='$patientid'";
	}
	if ($invoiceno!='')
	{
	$sql .= " AND billno='$invoiceno'";
	}
	
	if ($fromdate!='')
	{
	$sql .= " AND (datentime BETWEEN '$d1' AND '$d2')";
	}
	
	//echo $sql;
	$array = array();
	$res = mysqli_query($db,$sql);
	
	while($rs = mysqli_fetch_array($res)){
		$invoice=str_replace(' ', '_', $rs['billno']);
		$invoiceid='payrem_'.$rs['id'];
	$payrem = "<input type='text' id='$invoiceid'>";
	$payremfun='<a class="btn btn-default" onClick=payremamount("'.$rs['id'].'","'.$rs['balanceamt'].'")>Pay</a>';
		//$xtotal += $rs['totalamt'];
		$array[] = array("date"=> implode("/", array_reverse(explode("-",$rs['invoicedate']))), "invoiceno"=>$rs['billno'], "invoiceamt" => $rs['netamt'], "balanceamt" => $rs['balanceamt'], "payremfun" => $payremfun, "totalamt" => $payrem); 
	}
	//$array[] = array("tamt"=>number_format($xtotal,2,".",""));
	echo json_encode($array);
?>