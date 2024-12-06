<?php
$dps_patients='dps_patients';
	define("HOST", "localhost");
	define("USER", "root");
	define("PASS", "");
	define("DATABASE", "dps_patients");
	error_reporting(0);

	$db1 = mysqli_connect(HOST, USER, PASS) or die("Unable to connect !");
	mysqli_select_db($db1,DATABASE);
	//session_start();
?>
