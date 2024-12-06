<?php
	session_start();
	$username = $_SESSION['phar-username'];
	$peinvoiceno = 0;
	$pepurchaseno = 0;
	$peproductname = $_REQUEST['peproductname'];
	$peqty = $_REQUEST['peqty'];
	$pefree = 0;
	$pebatch = $_REQUEST['pebatch'];
	$storid=$_SESSION['storeid'];
	$peexpiry = $_REQUEST['peexpiry'];
	$peexpiry1 = $peexpiry;
	$peexpiry = "27/" . $peexpiry;
	$peexpiry = implode("-",array_reverse(explode("/",$peexpiry)));
	 
	$taxtype = $_REQUEST['taxtype'];
	$tax_percentage = $_REQUEST['pevatp'];
	$pepprice = $_REQUEST['pepprice'];
	$pemrp = $_REQUEST['pemrp'];
	$avail = $peqty + $pefree;

	include("../config.php");
	$sql = "SELECT * FROM tbl_productlist WHERE productname = '$peproductname'";
	$res = mysqli_query($db,$sql);
	$rs = mysqli_fetch_array($res);
	
	$productid = $rs['id'];
	$vat = $_REQUEST['pevat'];
	$gross = 0;
	$avail = $avail * $rs['unitdesc'];
	$netamt = $peqty * $pepprice;
	$qry = mysqli_query($db,"SELECT * FROM tbl_purchase WHERE supplierid=67 AND invoiceno='GENERAL'");
	$q=mysqli_fetch_array($qry);
	$pid = $q['purchaseid'];
	$invoivenum = $q['id'];


	$s = mysqli_query($db,"SELECT AUTO_INCREMENT FROM information_schema.tables WHERE TABLE_SCHEMA = '".DATABASE."' AND TABLE_NAME = 'tbl_purchaseitems'");
	$r = mysqli_fetch_array($s);
	$id = $r['AUTO_INCREMENT'];

	$qry1 = mysqli_query($db,"SELECT * FROM tbl_purchaseitems WHERE purchaseid='$pid' AND batchno='$pebatch' AND productid='$productid' AND invoiceno='$invoivenum' ");
	if(mysqli_num_rows($qry1) > 0)
	{
		$row = mysqli_fetch_array($qry1);
		$mrp = $row['mrp'];
		$avl = $row['aval'];
		$avl = $avl + $avail;
		$qt_y = $row['qty'];
		$qt_y = $qt_y + $peqty;
		if($mrp == $pemrp)
		{
			$cmd = "UPDATE tbl_purchaseitems SET qty='$qt_y', aval='$avl' WHERE  purchaseid='$pid' AND batchno='$pebatch' AND productid='$productid' AND invoiceno='$invoivenum' ";
		}

	}

	else
	{
		$cmd = "INSERT INTO tbl_purchaseitems (purchaseid, invoiceno, productid, qty, freeqty, batchno, expirydate, pprice, mrp, tax_type, tax_amount, tax_percentage, grossamt, netamt, aval, username, datentime, status,branch_id) VALUES ('$pid', '$invoivenum', '$productid', '$peqty', '$pefree', '$pebatch', '$peexpiry', '$pepprice', '$pemrp','$taxtype', '$vat', '$tax_percentage','$gross', '$netamt', '$avail', '$username', CURRENT_TIMESTAMP, '3','$storid')";
	}
	
	// $cmd="INSERT INTO tbl_purchase (id, supplierid, invoiceno, purchaseid, username, datentime, status) VALUES (NULL,'65','$peinvoiceno', '$pepurchaseno','$username', CURRENT_TIMESTAMP, '3')";


	if(mysqli_query($db,$cmd)){
//		mysqli_query($db,"UPDATE tbl_productlist mrp = $pemrp SET id = $productid");
		$array = array("id"=>$id, "code"=>$productid, "descrip"=>$peproductname, "qty"=>$peqty, "batch"=>$pebatch, "expiry"=>$peexpiry1, "mrp"=>$pemrp, "net"=>$netamt,"taxp"=> $tax_percentage,"tax_amount"=> $vat,"pepprice"=> $pepprice);
		echo json_encode($array);
	}else
		echo mysqli_error($db);
?>