<?php
	$id = $_REQUEST['id'];
	include("../config.php");
	
	$r = mysqli_query($db,"SELECT purchaseid FROM tbl_billing_items WHERE bid = $id  and del_status != 1");
	while($rs = mysqli_fetch_array($r)){
		$pid = $rs['purchaseid'];
		
		$ids = explode(";",$pid);
		for($i=0 ; $i<count($ids); $i++){
			$val =  explode("-",$ids[$i]);
			$q = "UPDATE tbl_purchaseitems SET aval = aval + $val[1] WHERE id = $val[0]";
			mysqli_query($db,$q);
		}
	}
	
	$cmd = mysqli_query($db,"DELETE FROM tbl_billing_items WHERE bid = $id  and del_status != 1");
	// $cmd = mysqli_query($db,"DELETE FROM tbl_billing WHERE id = $id");
	$cmd = "DELETE FROM tbl_billing WHERE id = $id and del_status != 1";
	if(mysqli_query($db,$cmd))
		echo 'Deleted !';
	else
		echo mysqli_error($db);
?>
