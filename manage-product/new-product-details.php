<?php
	include("../config.php");
	
	$product = $_REQUEST['product'];			$product = mysqli_escape_string($db,$product);

$product = preg_replace('!\s+!', ' ', $product);

	$generic = $_REQUEST['generic'];			$generic = mysqli_escape_string($db,$generic);
	$manufacturername = $_REQUEST['manufact'];	$manufacturername = mysqli_escape_string($db,$manufacturername);
	
	$q = mysqli_query($db,"SELECT id FROM tbl_manufacturer WHERE manufacturername = '$manufacturername'");
	$rs = mysqli_fetch_array($q);
	$manufacturer = $rs['id'];
	
	$schedule = $_REQUEST['schedule'];
	$producttype = $_REQUEST['producttype'];	
	$unitdesc = $_REQUEST['unitdesc'];
	$stocktype = $_REQUEST['stocktype'];
	$ptax = $_REQUEST['ptax'];
	$stax = $_REQUEST['stax'];
	//$mrp = $_REQUEST['mrp'];
	//$price = $_REQUEST['price'];
	$minqty = $_REQUEST['minqty'];
	$maxqty = $_REQUEST['maxqty'];
	$shelf = $_REQUEST['shelf'];
	$rack = $_REQUEST['rack'];
	$hsncode = $_REQUEST['hsncode'];
	$claimtype = $_REQUEST['cliam_type'];
	
	$sql = "INSERT INTO tbl_productlist (id, productname, genericname, scheduletype, producttype, manufacturer, unitdesc, stocktype, purchasetax, salestax, minqty, maxqty, shelf, rack,hsncode, claimtype, status) VALUES (NULL, '$product', '$generic', '$schedule', '$producttype', '$manufacturer', '$unitdesc', '$stocktype', '$ptax', '$stax', '$minqty', '$maxqty', '$shelf', '$rack','$hsncode','$claimtype','1')";
	if(mysqli_query($db,$sql))
		echo 'New Product Added!';
	else
		echo mysqli_error($db);
?>
 
