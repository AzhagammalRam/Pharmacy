<?php
	
	require_once("config.php");
	$username = $_SESSION['phar-username'];
	$peproductname = $_REQUEST['prod'];
	$pebatch = $_REQUEST['batch'];
	$storeid=$_SESSION['storeid'];
	
	
		$sql1 = "SELECT * FROM tbl_productlist WHERE productname = '$peproductname'";
		//echo $sql1 ;
	$res1 = mysqli_query($db,$sql1);
	$rs1 = mysqli_fetch_array($res1);
	
	$productid = $rs1['id'];
		
	
	$sql = "SELECT * FROM tbl_purchaseitems WHERE productid = '$productid' and batchno = '$pebatch' and branch_id = 1";
	//echo 	$sql;
	$res = mysqli_query($db,$sql);
	$rs = mysqli_fetch_array($res);
	
	$idstore = $rs['id'];
	$purchaseid = $rs['purchaseid'];
	$invoiceno = $rs['invoiceno'];
	$productid = $rs['productid'];
	//$qty = $rs['qty'];
	$freeqty = $rs['freeqty'];
	$batchno = $rs['batchno'];
	$expirydate = $rs['expirydate'];
	$pprice = $rs['pprice'];
	$mrp = $rs['mrp'];
	$vat = $rs['tax_amount'];
	$grossamt = $rs['grossamt'];
	$netamt = $rs['netamt'];
	$aval = $rs['aval'];
	$status = $rs['status'];
	$category_id = $rs['branch_id'];
	$branch_id = $_REQUEST['type'];
	$availstore =$rs['aval'] - $_REQUEST['qty'];
	$avail = $_REQUEST['qty'];
	$s = mysqli_query($db,"SELECT AUTO_INCREMENT FROM information_schema.tables WHERE TABLE_SCHEMA = '".DATABASE."' AND TABLE_NAME = 'tbl_purchaseitems'");
	$r = mysqli_fetch_array($s);
	$id = $r['AUTO_INCREMENT'];

	$strfrm=mysqli_query($db,"select * from branch where id=$storeid");
	$strfrmname=mysqli_fetch_array($strfrm);
	$fname=$strfrmname['name'];

	$strto=mysqli_query($db,"select * from branch where id=$branch_id");
	$strtoname=mysqli_fetch_array($strto);
	$tname=$strtoname['name'];

	$getstfmname=mysqli_query($db,"select name from branch where id=$storeid");
	$fmname=mysqli_fetch_array($getstfmname);
	$fname=$fmname['name'];

	$getsttoname=mysqli_query($db,"select name from branch where id=$branch_id");
	$toname=mysqli_fetch_array($getsttoname);
	$tname=$toname['name'];

	mysqli_query($db,"INSERT INTO tbl_stock_transfer(store_from,store_to,datestamp,user) VALUES ('$fname','$tname',now(),'$username')");
	mysqli_query($db,"INSERT INTO tbl_stock_transfer_item(id,batchno,expiry,product_name,qty,user,mrp,pprice) VALUES (LAST_INSERT_ID(),'$batchno','$expirydate','$peproductname','$avail','$username','$mrp','$pprice')");

	$cmd = "INSERT INTO tbl_purchaseitems (purchaseid, invoiceno, productid, qty, freeqty, batchno, expirydate, pprice, mrp, tax_amount, grossamt, netamt, aval, username, datentime, status,category_id,branch_id) VALUES ('$purchaseid', '$invoiceno', '$productid', '$avail', '$freeqty', '$batchno', '$expirydate', '$pprice', '$mrp', '$vat', '$grossamt', '$netamt', '$avail', '$username', CURRENT_TIMESTAMP, '2','$category_id','$branch_id')";
	if(mysqli_query($db,$cmd)){
		mysqli_query($db,"UPDATE tbl_purchaseitems SET aval=$availstore WHERE id=$idstore");
		$array = array("id"=>$id, "code"=>$productid, "descrip"=>$peproductname, "qty"=>$avail,"remain" =>$availstore, "free"=>$free, "batch"=>$batchno, "expiry"=>$expirydate, "price"=>$pprice,  "mrp"=>$mrp, "vat"=>$vat, "gross"=>$gross, "net"=>$netamt);
		echo json_encode($array);

	}else
		echo mysqli_error($db);
?>