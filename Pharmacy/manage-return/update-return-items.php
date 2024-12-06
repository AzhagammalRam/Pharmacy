<?php
	session_start();
	include("../config.php");

	$price= $_REQUEST['price'];
	$prproductname= $_REQUEST['pname'];
	$qty= $_REQUEST['qty'];
	$reason= $_REQUEST['reason'];
	$id= $_REQUEST['id'];
	$purchaseid= $_REQUEST['purchaseid'];
	$amount=$price*$qty;
	$sql = "SELECT * FROM tbl_productlist WHERE productname = '$prproductname'";
	$res = mysqli_query($db,$sql);
	$rs = mysqli_fetch_array($res);
	$pid=$rs['id'];
	$query1 = mysqli_query($db,"UPDATE tbl_purchase_return SET `invoiceno` = '0', `totalamount` = totalamount+'$amount', `status` = '2' where id = '$id' ");

	$query2 = mysqli_query($db,"INSERT INTO tbl_purchase_return_items (purchase_return_id, productid, qty, reason, price, datentime, status) VALUES ('$id', '$pid', '$qty','$reason', '$price', CURRENT_TIMESTAMP, '2')") or  die(mysqli_error($db));
	$lid = mysqli_insert_id($db);

	$array[] = array("pname"=>$rs['productname'],"id"=>$lid, "qty"=>$qty, "reason"=>$reason, "price"=>$price,"purchaseid"=>$purchaseid );
	echo json_encode($array);

?>