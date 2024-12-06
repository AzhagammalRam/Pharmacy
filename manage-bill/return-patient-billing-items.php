<?php
	$id = $_REQUEST['id'];
	include('../config.php');
	$array = array();
	$sql = mysqli_query($db,"SELECT * FROM tbl_billing_items WHERE (status = 2 or status = 3) AND bid = $id and del_status != 1 ORDER BY id asc");
	$tot = 0;
	while($rs = mysqli_fetch_array($sql)){
		$code = $rs['code'];
		$expirydate = implode("/",array_reverse(explode("-",$rs['expirydate'])));
		$exp = substr($expirydate,3);
		$cmd = mysqli_query($db,"SELECT * FROM tbl_productlist WHERE id = '$code'");
		$r = mysqli_fetch_array($cmd);
		$desc = $r['productname'];
//		$desc1 =  substr($r['stocktype'],0,3) . '. ' . $r['productname'];
		$type = $r['stocktype'];
		$tot += $rs['amount'];
		$q = mysqli_query($db,"SELECT * FROM tbl_requestmedicine WHERE drugtype = '$type' AND drugname = '$desc'");
		$x = mysqli_fetch_array($q);
		if($x['frequency'])
			$array[] = array("code"=>$code,"desc"=>$desc,"freq"=>$x['frequency'],"dur"=>$x['duration'],"spec"=>$x['specification'],"qty"=>$rs['qty'],"batch"=>$rs['batchno'],"expi"=>$exp,"amt"=>$rs['amount'],"id"=>$rs['id']);
		else
			$array[] = array("code"=>$code,"desc"=>$desc,"freq"=>'-',"dur"=>'-',"spec"=>'-',"qty"=>$rs['qty'],"batch"=>$rs['batchno'],"expi"=>$exp,"amt"=>$rs['amount'],"id"=>$rs['id']);
	}
	$cmdx = mysqli_query($db,"SELECT * FROM  tbl_outofstock WHERE billingid = $id");
	while($rx = mysqli_fetch_array($cmdx)){
		$pid = $rx['reqpid'];
		$qx = mysqli_query($db,"SELECT * FROM tbl_requestmedicine WHERE id = '$pid'");
		$s = mysqli_fetch_array($qx);
		$desc = $s['drugname'];
//		$desc = substr($s['drugtype'],0,3) . '. ' . $s['drugname'];
		$array[] = array("code"=>'-',"desc"=>$desc,"freq"=>$s['frequency'],"dur"=>$s['duration'],"spec"=>$s['specification'],"qty"=>'-',"batch"=>'-',"expi"=>'-',"amt"=>'-',"id"=>'-',"vatval"=>'-');
	}
	$array[] = array("tot"=>$tot);
	echo json_encode($array);	
?>