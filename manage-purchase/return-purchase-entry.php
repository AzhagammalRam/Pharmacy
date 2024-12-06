<?php
	$pur = $_REQUEST['pur'];
	$inv = $_REQUEST['inv'];
	include("../config.php");
	$res = mysqli_query($db,"SELECT * FROM tbl_purchaseitems WHERE purchaseid = $pur AND invoiceno = $inv");
	$array = array();
	while($rs = mysqli_fetch_array($res)){
		$code = $rs['productid'];
		$q =  mysqli_query($db,"SELECT * FROM tbl_productlist WHERE id = $code");
		$r = mysqli_fetch_array($q);
		
		$expirydate = implode("/",array_reverse(explode("-",$rs['expirydate'])));
		$expirydate = substr($expirydate,3);
		
		$array[] = array("id"=>$rs['id'], "code"=>$rs['productid'],"stocktype"=>$r['stocktype'], "descrip"=>$r['productname'], "qty"=>$rs['qty'], "free"=>$rs['freeqty'], "batch"=>$rs['batchno'], "expiry"=>$expirydate, "price"=>$rs['pprice'],  "mrp"=>$rs['mrp'], "vat"=>$rs['tax_percentage'],  "gross"=>$rs['tax_amount'], "net"=>$rs['netamt']);
	}
	echo json_encode($array);
?>
