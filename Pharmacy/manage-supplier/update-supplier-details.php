<?php
	include("../config.php");
	
	$id = $_REQUEST['DBid'];
	$supplier = $_REQUEST['usupplier'];				$supplier = mysqli_escape_string($db,$supplier);
	$addressline1 = $_REQUEST['uaddressline1'];		$addressline1 = mysqli_escape_string($db,$addressline1);
	$addressline2 = $_REQUEST['uaddressline2'];		$addressline2 = mysqli_escape_string($db,$addressline2);
	$addressline3 = $_REQUEST['uaddressline3'];		$addressline3 = mysqli_escape_string($db,$addressline3);

	$city = $_REQUEST['ucity'];	
	$state = $_REQUEST['ustate'];
	$pincode = $_REQUEST['upincode'];
	$country = $_REQUEST['ucountry'];
	$contact1 = $_REQUEST['ucontact1'];
	$contact2 = $_REQUEST['ucontact2'];
	$email = $_REQUEST['uemail'];
	$tin = $_REQUEST['utin'];
	$cst = $_REQUEST['ucst'];
	$gstnumber = $_REQUEST['ugstnumber'];
	
	$sql = "UPDATE tbl_supplier SET suppliername = '$supplier', addressline1 = '$addressline1', addressline2 = '$addressline2', addressline3 = '$addressline3', city = '$city', state = '$state', country = '$country', pincode = '$pincode', contactno1 = '$contact1', contactno2 = '$contact2', emailid = '$email', tin = '$tin', cst = '$cst',gstnumber = '$gstnumber' WHERE id = $id";
	
	if(mysqli_query($db,$sql))
		echo 'Supplier Information Updated!';
	else
		echo mysqli_error($db);
?>