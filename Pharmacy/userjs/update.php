<?php
	include("../config.php");
	$key =$_REQUEST['pkey'];
	$name=$_REQUEST['pname'];
    $client=$_REQUEST['client'];
	$valid=$_REQUEST['valid'];
	$upto= strtotime($valid);
	
	
	$sql = "UPDATE test SET status = 0";	
	mysql_query($sql);
	$cmd="insert into test(client,product_name,product_key,register_date,status) values('$client','$name','$key','$upto',1)";
	 if(mysql_query($cmd))
	 	echo 'success';
		else
		echo mysql_error();
	
		?>