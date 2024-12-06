<?php
	$product = urldecode($_REQUEST['product']);
	$supplierid = $_REQUEST['supplierid'];
	$intqty = $_REQUEST['intqty'];
	$intpepprice = $_REQUEST['intpepprice'];
	// $newsingleprice=$intpepprice/$intqty;
	// echo $newsingleprice;
	include("../config.php");
	 $sql = "SELECT * FROM tbl_productlist WHERE productname = '$product'";
	$res = mysqli_query($db,$sql);
	$rs = mysqli_fetch_array($res);
	$pid =  $rs['id'];
	$rese = mysqli_query($db,"SELECT * FROM tbl_purchase WHERE supplierid = '$supplierid' order by id desc LIMIT 1");
	$rse = mysqli_fetch_array($rese);
	$purchaseid = $rse['purchaseid'];
	// $fer="select * from tbl_purchaseitems where purchaseid='$purchaseid' and productid='$pid' order by id desc LIMIT 1";
	$fer = "select b.supplierid,a.* from tbl_purchaseitems a join tbl_purchase b on a.purchaseid = b.purchaseid where a.productid = '$pid' and b.supplierid='$supplierid' order by a.id desc  LIMIT 1 ";
	$ser= mysqli_query($db,$fer);
	$fs= mysqli_fetch_array($ser);
	$pprice =  $fs['pprice'];
	$qty =  $fs['qty'];
	// if($qty!=''){
	// 		$singleprice=$pprice/$qty;
	// echo $singleprice;
	// }
	if($pprice==''){
		echo "Empty";
	}
	else{
		echo "Previous Purchase price ".$pprice;
	}
?>