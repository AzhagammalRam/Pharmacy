<?php
	session_start();
	$username = $_SESSION['phar-username'];
	$pname = $_REQUEST['pname'];
	$dname = $_REQUEST['dname'];
	$phno = $_REQUEST['phno'];
	$billda =$_REQUEST['billda'];
	$billda=date("Y-m-d" ,strtotime($billda));
	
	$dob = $_REQUEST['dob'];
	$dob=date("Y-m-d" ,strtotime($dob));
	$age =$_REQUEST['age'];
	// echo $billda;
	include("../config.php");
	
	$cmd = "INSERT INTO tbl_billing (patientid, patientname, drname, totalamt, discount, netamt, paidamt, balanceamt, datentime, username, status,phno,dob,age) VALUES ('', '$pname', '$dname', '0.00', '0.00', '0.00', '0.00', '0.00', '$billda', '$username', '2','$phno','$dob','$age');";
	
	mysqli_query($db,$cmd) or die("Unable to create bill");
	$last_id = mysqli_insert_id($db);
	echo '+'.$last_id;
	include('../config-db1.php');
	$sql= "select * from `$dps_patients`.`prescriptiondetail` where ip_id = '$phno' AND status='2'";
	$result=mysqli_query($db1,$sql);
	while($row=mysqli_fetch_array($result))
	{

     $tab=$row['tablet'];
      $order_quantity=$row['order_quantity'];
      // $batchno=$row['batch'];
     include("../config.php");
     $sql1= "select * from `$pharmacydb`.`tbl_productlist` where productname = '$tab'";
     $result1=mysqli_query($db,$sql1);
	$row1=mysqli_fetch_array($result1);
	 $unit = $row1['unitdesc'];
		$prid=$row1['id'];
		$clm_type = $row1['claimtype'];
        $sql2= "select * from `$pharmacydb`.`tbl_purchaseitems` where productid = '$prid' ";
     $result2=mysqli_query($db,$sql2);
	while($row2=mysqli_fetch_array($result2))
	{
	  $mrp=$row2['mrp'];
		$aval=$row2['id'];
		$batchno=$row2['batchno'];
		$expirydate=$row2['expirydate'];
		$vat=$row2['tax_amount'];
		$tax_amount=$row2['tax_amount'];
		$taxpercentage=$row2['tax_percentage'];
		$taxtype=$row2['tax_type'];
		$purchaseid=$row2['id'].'-'.$order_quantity;
		$amount=0;
		$amount = $amount + ($order_quantity * ($row2['mrp'] / $unit));
        $amount =sprintf('%0.2f', round($amount,2));
        } 

     $cmd = "INSERT INTO tbl_billing_items (billno, bid, code, qty, batchno, expirydate,tax_percentage,tax_type,tax_amount, amount, vatval, purchaseid, datentime, username,status,prod_cm_stat) VALUES ('', '$last_id', '$prid', '$order_quantity', '$batchno', '$expirydate','$taxpercentage','$taxtype','$tax_amount', '$amount', '$vat', '$purchaseid' , CURRENT_TIMESTAMP, '$username', '2','$clm_type');";


	
	mysqli_query($db,$cmd) or die("Unable to create bill");
   

	}
	
?>
