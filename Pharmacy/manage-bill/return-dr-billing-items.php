<?php
	$id = $_GET['id'];
	include('../config.php');
	$array = array();
	$sql = mysql_query("SELECT * FROM tbl_drug_return_billing_items WHERE status = 8 AND bid = $id ORDER BY id asc");
	$tot = 0;
	while($rs = mysql_fetch_array($sql)){
		$code = $rs['code'];
		$de = $rs['datentime'];
		$tp = $rs['tax_percentage'];
		$expirydate = implode("/",array_reverse(explode("-",$rs['expirydate'])));
		$exp = substr($expirydate,3);
		$cmd = mysql_query("SELECT * FROM tbl_productlist WHERE id = '$code'");
		$r = mysql_fetch_array($cmd);
		$desc = $r['productname'];
//		$desc =  substr($r['stocktype'],0,3) . '. ' . $r['productname'];
		$tot += $rs['amount'];
        $type = $r['stocktype'];

		$array[] = array("code"=>$code,"desc"=>$desc,"qty"=>$rs['qty'],"batch"=>$rs['batchno'],"expi"=>$exp,"amt"=>$rs['amount'],"id"=>$rs['id'],"vatval"=>$rs['vatval']);
		
	}
	$array[] = array("tot"=>$tot);
	echo json_encode($array);	
?>