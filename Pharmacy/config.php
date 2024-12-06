<?php
$pharmacydb='pharmacy';
	define("HOST", "localhost");
	define("USER", "root");
	define("PASS", "");
	define("DATABASE", "pharmacy");
	error_reporting(0);

	$config['module']['quickBillip']=true;
	$config['module']['currency']=false;
	$config['module']['murugan']=true;

	$db = mysqli_connect(HOST, USER, PASS) or die("Unable to connect !");		
	mysqli_select_db($db,DATABASE);
	session_start();
?>