<?php
	// $id = $_REQUEST['id'];
	include("../config.php");
	$sql = "SELECT * FROM `tbl_currency` where `status` = '1'";
	$res = mysql_query($sql);

	while($rs = mysql_fetch_array($res)){
		$id=$rs['id'];
		$name=$rs['currency'];
		$option.="<option value='$id'>$name</option>";
	}
	
	$base_currency_query = mysql_query("SELECT * FROM `tbl_currency` where `base_currency` = '1'");
	$base_currency_query_res_rs = mysql_fetch_array($base_currency_query);
	$base_currency=$base_currency_query_res_rs['currency'];
	$array = array("id"=>$base_currency_query_res_rs['id'],"base_currency"=>$base_currency_query_res_rs['currency']);
	
	echo json_encode($array);
?>