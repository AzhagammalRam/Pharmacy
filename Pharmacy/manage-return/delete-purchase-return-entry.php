<?php
	$id = $_REQUEST['id'];
	$amount = $_REQUEST['amt'];
	include("../config.php");
	
	mysqli_query($db,"UPDATE tbl_purchase_return SET  `totalamount` = totalamount-'$amount' where id = '$id' AND status= 2 ");
	 $sql = mysqli_query($db,"DELETE FROM tbl_purchase_return_items WHERE purchase_return_id = $id AND status = 2 ");
	if(mysqli_query($db,$sql)){
		echo 'ok';
	} else {
		mysqli_error($db);
	}
?>