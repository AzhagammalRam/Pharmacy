<?php
	include("../config.php");
	$fromdate = $_REQUEST['fromdate'];
	$fromto = $_REQUEST['fromto'];
	//$paymentmode = $_REQUEST['paymentmode'];
	//$billtype = $_REQUEST['billtype'];
	
	// $d1 = implode("-", array_reverse(explode("/",$fromdate)));
	// if($fromto == "")	$d2 = $d1;
	// else $d2 = implode("-", array_reverse(explode("/",$fromto)));
	$d1arr = explode("/",$fromdate);
	$d1 = $d1arr[2].'-'.$d1arr[1].'-'.$d1arr[0];
	if($fromto == "")	$d2 = $d1;
	else 
	$d2arr = explode("/",$fromto);
	$d2 = $d2arr[2].'-'.$d2arr[1].'-'.$d2arr[0];
	
 	$sql = "select sum(tax_amount) as tax_amount,netamt,purchaseid, invoiceno,datentime FROM tbl_purchaseitems where (datentime BETWEEN '$d1' AND '$d2') AND status = 1 group by invoiceno";
		$array = array();
		$res = mysqli_query($db,$sql);
		$xtotal = 0;
		while($rs = mysqli_fetch_array($res)){
		$rsv = $rs['purchaseid'];
		$xtotal += $rs['tax_amount'];
 		$sql2 = "select supplierid,invoiceno from tbl_purchase where (datentime BETWEEN '$d1' AND '$d2') AND purchaseid = $rsv";
		$resu = mysqli_query($db,$sql2); 
	 	$rse1 = mysqli_fetch_array($resu);
		$supplierid= $rse1['supplierid'];
		$sep = "select * from tbl_supplier WHERE id = '$supplierid'";
		$result2 = mysqli_query($db,$sep);
		$r = mysqli_fetch_array($result2);
		// $rese= $r['suppliername'];
		$supplier = $r['suppliername'] . '<br />'. $r['gstnumber'];
		$array[] = array("date"=> date('d/m/Y', strtotime($rs['datentime'])), "billno"=>$rse1['invoiceno'], "gstnumber"=>$r['gstnumber'], "suppliername"=>$r['suppliername'],  "vat" => $rs['tax_amount'],"netamt" => $rs['netamt']); 
	
}
//echo $xtotal;
$array[] = array("tamt"=>number_format($xtotal,2,".",""));
	echo json_encode($array);
?>