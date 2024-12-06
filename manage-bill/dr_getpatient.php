<?php
	$phno = $_REQUEST['phno'];
	include("../config.php");
	$rs = mysql_fetch_array(mysql_query("SELECT patientname FROM tbl_billing WHERE phno = '$phno' and del_status != 1 order by id desc limit 1"));
	$name = $rs['patientname'];
	
	//$r1 = mysql_fetch_array(mysql_query("SELECT * FROM tbl_productlist WHERE id = $code"));

	$array = array();
	array_push($array, array("patientname"=>$name));
	

	echo json_encode($array);
	
?>