<?php
	session_start();
	$username = $_SESSION['phar-username'];
	$peinvoiceno = $_REQUEST['peinvoiceno'];
	$pepurchaseno = $_REQUEST['pepurchaseno'];
	$storid=$_SESSION['storeid'];
	$peproductname = $_REQUEST['peproductname'];
	$peqty = $_REQUEST['peqty'];
	$pefree = $_REQUEST['pefree'];
	$pebatch = $_REQUEST['pebatch'];
	$avail=$_REQUEST['avail'];
	
	$peexpiry = $_REQUEST['peexpiry'];
	$peexpiry1 = $peexpiry;
	$peexpiry = "27/" . $peexpiry;
	$peexpiry = implode("-",array_reverse(explode("/",$peexpiry)));
	
	$pepprice = $_REQUEST['pepprice'];
	$pemrp = $_REQUEST['pemrp'];
	require_once("../config.php");
	$sql = "SELECT * FROM tbl_productlist WHERE productname = '$peproductname'";
	$res = mysqli_query($db,$sql);
	$rs = mysqli_fetch_array($res);
	$hsncode = $rs['hsncode'];
	// echo $hsncode;
	$productid = $rs['id'];
	$type = $rs['stocktype'];
	$taxtype = $_REQUEST['taxtype'];
	$tax = $_REQUEST['pevatp'];
	$gross = $_REQUEST['pevat'];
	$vatamount=$peqty * $pepprice * ($tax/100);
/*	$vat = $rs['salestax'];
	$gross = $peqty * $pepprice * $vat / 100;	*/
	$netamt = $peqty * $pepprice + $vatamount;
	
	$s = mysqli_query($db,"SELECT AUTO_INCREMENT FROM information_schema.tables WHERE TABLE_SCHEMA = '".DATABASE."' AND TABLE_NAME = 'tbl_purchaseitems'");
	$r = mysqli_fetch_array($s);
	$id = $r['AUTO_INCREMENT'];
	
	$cmd = "INSERT INTO tbl_purchaseitems (purchaseid, invoiceno, productid,hsncode, qty, freeqty, batchno, expirydate, pprice, mrp, tax_type, tax_amount, tax_percentage, grossamt, netamt, aval, username, datentime, status,category_id,branch_id) VALUES ('$pepurchaseno', '$peinvoiceno', '$productid','$hsncode', '$peqty', '$pefree', '$pebatch', '$peexpiry', '$pepprice', '$pemrp','$taxtype', '$gross','$tax', '$vatamount', '$netamt', '$avail', '$username', CURRENT_TIMESTAMP, '2',1,'	$storid')";
	if(mysqli_query($db,$cmd)){
		mysqli_query($db,"UPDATE tbl_productlist mrp = $pemrp SET id = $productid");
		$array = array("id"=>$id, "code"=>$productid, "hsncode"=>$hsncode,"type"=>$type, "descrip"=>$peproductname, "qty"=>$peqty, "free"=>$pefree, "batch"=>$pebatch, "expiry"=>$peexpiry1, "price"=>$pepprice,  "mrp"=>$pemrp, "vat"=>$tax, "gross"=>$vatamount, "net"=>$netamt);
		echo json_encode($array);
	}else
		echo mysqli_error($db);
?>