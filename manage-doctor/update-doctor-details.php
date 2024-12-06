<?php
	include("../config.php");
	
	$id = $_REQUEST['DBid'];
	$doctor = $_REQUEST['udoctor'];				$doctor = mysqli_escape_string($db,$doctor);
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
	
	
	$sql = "UPDATE tbl_doctor SET doctorname = '$doctor', addressline1 = '$addressline1', addressline2 = '$addressline2', addressline3 = '$addressline3', city = '$city', state = '$state', country = '$country', pincode = '$pincode', contactno1 = '$contact1', contactno2 = '$contact2', emailid = '$email' WHERE id = $id";
	
	if(mysqli_query($db,$sql))
		echo 'Doctor Information Updated!';
	else
		echo mysqli_error($db);
?>