<?php
	session_start();
	// session_destroy();
		unset($_SESSION['phar-username']);
	header('location:login.php');
?>