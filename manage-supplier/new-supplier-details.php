<?php
	include("../config.php");
	
	$supplier = $_REQUEST['supplier'];				$supplier = mysqli_escape_string($db,$supplier);
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
	$tin = $_REQUEST['tin'];
	$cst = $_REQUEST['cst'];
	$gstnumber = $_REQUEST['gstnumber'];

	$cmd_supply_tin_exist = mysqli_query($db,"SELECT * FROM `tbl_supplier` WHERE suppliername='$supplier' And tin = '$tin' OR suppliername='$supplier' And cst = '$cst' ORDER BY `id` desc LIMIT 1 ");
			
			if(mysqli_num_rows($cmd_supply_tin_exist) !=0){
				$res = mysqli_fetch_array($cmd_supply_tin_exist);
				$tin = $res['tin'];
				$cst = $res['cst'];

				if($tin=='' && $cst =='')
				{
					echo 'supplier Name Already Exist';
				}
				elseif($tin !='' && $cst =='')
					{echo 'Supplier Name and tin number Already Exist';}
				else
				{
					echo 'Supplier Name and cst Already Exist';
				}
				mysqli_close($db);
				exit;
		    	}
	
	$sql = "INSERT INTO tbl_supplier (id, suppliername, addressline1, addressline2, addressline3, city, state, country, pincode, contactno1, contactno2, emailid, tin, cst,gstnumber, status) VALUES (NULL, '$supplier', '$addressline1', '$addressline2', '$addressline3', '$city', '$state', '$country', '$pincode', '$contact1', '$contact2', '$email', '$tin', '$cst','$gstnumber', '1')";
	if(mysqli_query($db,$sql))
		echo 'New Supplier Added!';
	else
		echo mysqli_error($db);
?>
 
