<?php
	include("../config.php");

	$invoice = $_REQUEST['invoice'];
	$supplierid = $_REQUEST['supplierid'];

	$sql = "SELECT * FROM tbl_purchaseitems WHERE invoiceno = '$invoice' AND status = 1";

	$res = mysqli_query($db,$sql);
	$array = array();
	while($rs = mysqli_fetch_array($res)){
		$id=$rs['id'];
		$productid=$rs['productid'];

		$res1 = mysqli_query($db,"SELECT * FROM tbl_supplier WHERE id = '$supplierid'");
		$r1 = mysqli_fetch_array($res1);
		$suppliername = $r1['suppliername'];
		
		
		$res2 = mysqli_query($db,"SELECT * FROM tbl_productlist WHERE id = '$productid'");
		$r2 = mysqli_fetch_array($res2);
		$productname = $r2['productname'];

		$res3 = mysqli_query($db,"SELECT * FROM tbl_purchase WHERE id = '$invoice'");
		$r3 = mysqli_fetch_array($res3);
		$invoicenum = $r3['invoiceno'];
		
		$array[] = array("id"=>$rs['id'],"invoiceno"=>$r3['invoiceno'], "supplierid"=>$supplierid, "supplier"=>$suppliername, "productname"=>$productname, "aval"=>$rs['aval']);
	}
	echo json_encode($array);
	//echo "SELECT * FROM tbl_purchaseitems WHERE invoiceno = '$invoice' AND status = 1";
?>