<?php
	include("../config.php");
	
	$id = $_REQUEST['DBid'];
	$product = $_REQUEST['uproduct'];			$product = mysqli_escape_string($db,$product);
	$generic = $_REQUEST['ugeneric'];			$generic = mysqli_escape_string($db,$generic);
	$manufacturername = $_REQUEST['umanufact'];	$manufacturername = mysqli_escape_string($db,$manufacturername);
	
	$q = mysqli_query($db,"SELECT id FROM tbl_manufacturer WHERE manufacturername = '$manufacturername'");
	$rs = mysqli_fetch_array($q);
	$manufacturer = $rs['id'];
	
	$schedule = $_REQUEST['uschedule'];
	$producttype = $_REQUEST['uproducttype'];	
	$unitdesc = $_REQUEST['uunitdesc'];
	$stocktype = $_REQUEST['ustocktype'];
	$ptax = $_REQUEST['uptax'];
	$stax = $_REQUEST['ustax'];
	//$mrp = $_REQUEST['umrp'];
	//$price = $_REQUEST['uprice'];
	$minqty = $_REQUEST['uminqty'];
	$maxqty = $_REQUEST['umaxqty'];
	$shelf = $_REQUEST['ushelf'];
	$rack = $_REQUEST['urack'];
	$hsncode = $_REQUEST['uhsncode'];
	$claimtype = $_REQUEST['ucliam_type'];
	
	$sql = "UPDATE tbl_productlist SET productname = '$product', genericname = '$generic', scheduletype = '$schedule', producttype = '$producttype', manufacturer = '$manufacturer', unitdesc = '$unitdesc', stocktype = '$stocktype', purchasetax = '$ptax', salestax = '$stax', minqty = '$minqty', maxqty = '$maxqty', shelf = '$shelf', rack = '$rack', hsncode = '$hsncode', claimtype = '$claimtype' WHERE id = $id";
	
	if(mysqli_query($db,$sql))
		echo 'Product Information Updated!';
	else
		echo mysqli_error($db);
?>