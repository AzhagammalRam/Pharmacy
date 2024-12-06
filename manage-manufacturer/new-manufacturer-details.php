<?php
	include("../config.php");
	
	$manufacturer = $_REQUEST['manufacturer'];		$manufacturer = mysqli_escape_string($db,$manufacturer);
	$addressline1 = $_REQUEST['addressline1'];		$addressline1 = mysqli_escape_string($db,$addressline1);
	$addressline2 = $_REQUEST['addressline2'];		$addressline2 = mysqli_escape_string($db,$addressline2);
	$addressline3 = $_REQUEST['addressline3'];		$addressline3 = mysqli_escape_string($db,$addressline3);

	$city = $_REQUEST['city'];	
	$state = $_REQUEST['state'];
	$pincode = $_REQUEST['pincode'];
	$country = $_REQUEST['country'];
	$contact1 = $_REQUEST['contact1'];
	$contact2 = $_REQUEST['contact2'];
	$email = $_REQUEST['email'];

	$cmd_manufacturer_exist = mysqli_query($db,"SELECT `manufacturername` FROM `tbl_manufacturer` WHERE manufacturername='$manufacturer' LIMIT 1");
			if(mysqli_num_rows($cmd_manufacturer_exist) !=0){
				echo 'manufacturer Already Exist.';
				mysqli_close($db);
				exit;
		    	}
		
	$sql = "INSERT INTO tbl_manufacturer (id, manufacturername, addressline1, addressline2, addressline3, city, state, country, pincode, contactno1, contactno2, emailid, status) VALUES (NULL, '$manufacturer', '$addressline1', '$addressline2', '$addressline3', '$city', '$state', '$country', '$pincode', '$contact1', '$contact2', '$email', '1')";
	if(mysqli_query($db,$sql))
		echo 'New Manufacturer Added!';
	else
		echo mysqli_error($db);
?>
 
