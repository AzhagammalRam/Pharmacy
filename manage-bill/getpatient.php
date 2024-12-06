<?php
	$phno = $_REQUEST['phno'];
	$chk =  $_REQUEST['chk'];
		require_once("../config.php");
	
	//$r1 = mysqli_fetch_array(mysqli_query($db,"SELECT * FROM tbl_productlist WHERE id = $code"));
   if($chk==1)
   {
   
	$rs = mysqli_fetch_array(mysqli_query($db,"SELECT patientname FROM tbl_billing WHERE phno = '$phno' and del_status != 1 order by id desc limit 1"));
	$name = $rs['patientname'];
	
	//$r1 = mysqli_fetch_array(mysqli_query($db,"SELECT * FROM tbl_productlist WHERE id = $code"));

	$array = array();
	
	if (is_null($name) or strlen($name) <= 0){
		include("../config-db1.php");
		$rs1 = mysqli_fetch_array(mysqli_query($db1,"SELECT patientname, reference FROM `$dps_patients`.`patientdetails` WHERE patientid = '$phno' or contactno = '$phno' or altcontactno = '$phno' order by id desc limit 1"));
		$name = $rs1['patientname'];
		$dname = $rs1['reference'];
		
	}
	
	array_push($array, array("patientname"=>$name,"reference"=>$dname));
	

	echo json_encode($array);
	}
	else if($chk==2)
   {
	$array1 = array();
	
	if (is_null($name) or strlen($name) <= 0){
		include("../config-db1.php");
		$rs2 = mysqli_fetch_array(mysqli_query($db1,"SELECT patientname, reference,insurance_type FROM `$dps_patients`.`patientdetails` WHERE ip_id = '$phno'or contactno = '$phno' order by id desc limit 1"));
		$name1 = $rs2['patientname'];
		$docname1 = $rs2['reference'];
		include("../config-db2.php");
		$rs3 =  mysqli_fetch_array(mysqli_query($db,"SELECT * FROM `$dps_master`.`doctor_creation` WHERE id = '$docname1'"));
		$dname1 = $rs3['doctor_name'];
		include("../config-db1.php");
		$insurance_type=$rs2['insurance_type'];
		if($insurance_type == '1')
		{
			$paymode="Cash";
		}
		else if($insurance_type != '1')
		{
			$paymode="Credit-Claim";
		}
		
	}
	
	array_push($array1, array("patientname1"=>$name1,"reference1"=>$dname1,"paymode"=>$paymode));
	
     
	echo json_encode($array1);
	}
?>