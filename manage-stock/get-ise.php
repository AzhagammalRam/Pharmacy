<?php
	$id = $_REQUEST['id'];
	include("../config.php");
	$sql = "SELECT * FROM tbl_purchaseitems WHERE id = '$id'";
	$res = mysqli_query($db,$sql);
	$rs = mysqli_fetch_array($res);
    $productid = $rs['productid'];


    $qry = mysqli_query($db,"SELECT * FROM tbl_productlist WHERE id='$productid'");
	$q=mysqli_fetch_array($qry);
	$productname = $q['productname'];

    $expdt1 = $rs['expirydate'];
    $tt = explode("-",$expdt1);
    $expdt = $tt[1].'/'.$tt[0];
    // $expirydate = implode("-",array_reverse(explode("/",$peexpiry)));

	
	$array = array("productname"=>$productname,"qty"=>$rs['qty'],"batchno"=>$rs['batchno'],"expirydate"=>$expdt,"pprice"=>$rs['pprice'],"mrp"=>$rs['mrp'],"tax_type"=>$rs['tax_type'],"tax_amount"=>$rs['tax_amount'],"tax_percentage"=>$rs['tax_percentage']);
	
	print json_encode($array);
?>