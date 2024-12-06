<?php
	$id = $_REQUEST['id'];
	include("../config.php");

	$r = mysqli_query($db,"SELECT purchaseid, amount, bid, qty FROM tbl_billing_items WHERE id = $id  and del_status != 1");
	$rs = mysqli_fetch_array($r);
	$pid = $rs['purchaseid'];
	$amt = $rs['amount'];
	$qty = $rs['qty'];
	
	if($qty > 0){
		$ids = explode(";",$pid);
		for($i=0 ; $i<count($ids); $i++){
			$val =  explode("-",$ids[$i]);
			$q = "UPDATE tbl_purchaseitems SET aval = aval + $val[1] WHERE id = $val[0]";
			mysqli_query($db,$q);
		}
	}
	
	$cmd = "DELETE FROM tbl_billing_items WHERE id = $id  and del_status != 1";
	if(mysqli_query($db,$cmd))
		echo 'Deleted !~'.$amt."~".$rs['bid'];
	else
		echo mysqli_error($db);
?>
