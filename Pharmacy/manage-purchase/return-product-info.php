<?php
	$product = urldecode($_REQUEST['product']);
	include("../config.php");
	$sql = "SELECT * FROM tbl_productlist WHERE productname = '$product'";
	$res = mysqli_query($db,$sql);
	$rs = mysqli_fetch_array($res);
	
	$array = array("productname"=>$rs['productname'],"mrp"=>$rs['mrp'],"vat"=>$rs['salestax'],"unitdec"=>$rs['unitdesc']);
	
	print json_encode($array);
?>