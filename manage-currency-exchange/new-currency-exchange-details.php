<?php
	include("../config.php");

	$currency = $_REQUEST['currency'];
	$currency_amnt = $_REQUEST['currency_amnt'];
	$exchange_currency = $_REQUEST['exchange_currency'];
	$exchange_value = $_REQUEST['exchange_value'];
	$status = $_REQUEST['status'];

   	$sql = "INSERT INTO `tbl_currency_exchange` (`id`, `base_currency`, `base_currency_amnt`, `exchange_currency`, `exchange_rate`, `status`) VALUES (NULL, '$currency', '$currency_amnt', '$exchange_currency', '$exchange_value', '$status');";
	if(mysql_query($sql))
		echo 'sucess';
	else
		echo mysql_error();
?>
 
