<?php
	include("../config.php");

	$currency = $_REQUEST['currency'];
	$base_currency = $_REQUEST['base_currency'];
	if($base_currency == 1){
		mysql_query("UPDATE tbl_currency SET base_currency =0");
	}
   	$sql = "INSERT INTO tbl_currency (id, currency,base_currency, status) VALUES (NULL, '$currency', '$base_currency','1');";
	if(mysql_query($sql))
		echo 'sucess';
	else
		echo mysql_error();
?>
 
