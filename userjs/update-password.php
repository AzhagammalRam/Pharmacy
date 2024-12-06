<?php
	session_start();
	$loginid = $_SESSION['phar-loginid'];
	if($loginid == '')
		die("Error : Unable to validate User!");
	$pwd = $_REQUEST['pwd'];
	include("../config.php");
	$cmd = "UPDATE tbl_users SET password = '$pwd' WHERE id = '$loginid'";
	if(mysql_query($cmd))
		echo 'Password changed successfully !';
	else
		echo mysql_error();
?>