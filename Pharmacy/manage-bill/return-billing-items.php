<?php
	$id = $_REQUEST['id'];
	include('../config.php');
	$array = array();
	$sql = mysqli_query($db,"SELECT * FROM tbl_billing_items WHERE status = 2 AND bid = $id and del_status != 1 ORDER BY id asc");
	$tot = 0;
	while($rs = mysqli_fetch_array($sql)){
		$code = $rs['code'];
		$de = $rs['datentime'];
		$tp = $rs['tax_percentage'];
		$expirydate = implode("/",array_reverse(explode("-",$rs['expirydate'])));
		$exp = substr($expirydate,3);
		$cmd = mysqli_query($db,"SELECT * FROM tbl_productlist WHERE id = '$code'");
		$r = mysqli_fetch_array($cmd);
		$desc = $r['productname'];
//		$desc =  substr($r['stocktype'],0,3) . '. ' . $r['productname'];
		$tot += $rs['amount'];
        $type = $r['stocktype'];

		$array[] = array("code"=>$code,"type"=>$type,"desc"=>$desc,"qty"=>$rs['qty'],"batch"=>$rs['batchno'],"expi"=>$exp,"tp"=>$tp,"de"=>$de,"amt"=>$rs['amount'],"id"=>$rs['id'],"vatval"=>$rs['vatval']);
	}
	$array[] = array("tot"=>$tot);
	echo json_encode($array);	
?>