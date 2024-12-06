<?php
	session_start();
	$username = $_SESSION['phar-username'];
	include("../config.php");
	$assets = $_REQUEST['assets'];
 	$sql = "select * from stockwastage WHERE `status`=0 and `dispose_status`=1";
	$rst= mysql_query($sql);
	while($rse = mysql_fetch_array($rst)){
		$batch=$rse['batchno'];
foreach($assets as $asset => $key){
	// echo $key;
	if ($key[0]==1)
	// $key[3]==$batch; 
	{
   $cmd = "UPDATE stockwastage SET `dispose_status`=0 and `updated_by`='$username' WHERE `status`=0 and `expiry`='$key[4]' and batch='$key[3]' and id='$key[6]'";
	if(mysql_query($cmd))
		echo 'Stock Disposed';
	else
		mysql_error();
	}
		}
		}
?>