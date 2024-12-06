<?php
$dps_master='dps_master';
	define("HOST", "localhost");
	define("USER", "root");
	define("PASS", "");
	define("DATABASE", "dps_master");
	error_reporting(0);

	$db2 = mysqli_connect(HOST, USER, PASS) or die("Unable to connect !");
	mysqli_select_db($db2,DATABASE);
	//session_start();
?>
