<?php
	include("../config.php");
	
	$id = $_REQUEST['DBid'];
	$currency = $_REQUEST['ucurrency'];				$currency = mysql_escape_string($currency);
	$base_currency = $_REQUEST['ubase_currency'];				$base_currency = mysql_escape_string($base_currency);
	if($base_currency==1){
		mysql_query("UPDATE `tbl_currency` SET `base_currency`='0' ");
	}
	$sql = "UPDATE `tbl_currency` SET `currency` = '$currency',`base_currency`='$base_currency' WHERE id = $id";
	
	if(mysql_query($sql))
		echo 'Currency Information Updated!';
	else
		echo mysql_error();
?>