<?php
	session_start();
	$username = $_SESSION['phar-username'];
	$pname = $_REQUEST['pname'];
	$dname = $_REQUEST['dname'];
	if($_REQUEST['phno'] != ''){
		$phno = $_REQUEST['phno'];
	} else {
		$phno = '';
	}
	if($_REQUEST['bill'] != ''){
		$bill =$_REQUEST['bill'];
	} else {
		$bill = '';
	}
	
	
	$bill=date("Y-m-d" ,strtotime($bill));
	// echo $bill;
	include("../config.php");
	
	$cmd = "INSERT INTO tbl_billing (patientid, patientname, drname, totalamt, discount, netamt, paidamt, balanceamt, datentime, username, status,phno) VALUES ( '', '$pname', '$dname', '0.00', '0.00', '0.00', '0.00', '0.00', '$bill', '$username', '2','$phno');";
	
	mysqli_query($db,$cmd) or die("Unable to create bill");
	$last_id = mysqli_insert_id($db);
	echo '+'.$last_id;
	include('../config-db1.php');

	 $sql= "select * from `$dps_patients`.`prescriptiondetail` where patientid = '$phno' AND status='2' and id=(SELECT MAX(id))";
	$result=mysqli_query($db1,$sql);
	while($row=mysqli_fetch_array($result))
	{

     $tab=$row['tablet'];
      $order_quantity=$row['order_quantity'];
     include("../config.php");
     $sql1= "select * from `$pharmacydb`.`tbl_productlist` where productname = '$tab'";
     $result1=mysqli_query($db,$sql1);
	$row1=mysqli_fetch_array($result1);
	 $unit = $row1['unitdesc'];
		$prid=$row1['id'];
        $sql2= "select * from `$pharmacydb`.`tbl_purchaseitems` where productid = '$prid'";
     $result2=mysqli_query($db,$sql2);
	while($row2=mysqli_fetch_array($result2))
	{
	  $mrp=$row2['mrp'];
		$aval=$row2['id'];
		$batchno=$row2['batchno'];
		$expirydate=$row2['expirydate'];
		$vat=$row2['vat'];
		$tax_amount=$row2['tax_amount'];
		$taxpercentage=$row2['tax_percentage'];
		$taxtype=$row2['tax_type'];
		$purchaseid=$row2['purchaseid'];
		$amount=0;
		$amount = $amount + ($order_quantity * ($row2['mrp'] / $unit));
        $amount =sprintf('%0.2f', round($amount,2));
        } 

      $cmd = "INSERT INTO tbl_billing_items (billno, bid, code, qty, batchno, expirydate,tax_percentage,tax_type,tax_amount, amount, vatval, purchaseid, datentime, username,status) VALUES ('', '$last_id', '$prid', '$order_quantity', '$batchno', '$expirydate','$taxpercentage','$taxtype','$tax_amount', '$amount', '$vat', '$purchaseid' , CURRENT_TIMESTAMP, '$username', '2');";


	
	mysqli_query($db,$cmd) or die("Unable to create bill");
   

	}
	
?>