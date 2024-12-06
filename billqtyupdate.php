<?php
	include("config.php");
	 $id = $_REQUEST['id'];
	 $qty = $_REQUEST['qty'];
	 $total = $_REQUEST['total'];
	 $code = $_REQUEST['code'];
	 $sql1="select * from tbl_billing_items where bid='$id' AND code='$code' and del_status != 1";
	 $result1=mysqli_query($db,$sql1);
	 $row=mysqli_fetch_array($result1);
	 $amount=$row['amount'];
	 $sql="update tbl_billing_items set qty='$qty',amount='$total' where bid='$id' AND code='$code' and del_status != 1";
	mysqli_query($db,$sql);
	$qry1 =mysqli_fetch_array(mysqli_query($db,"select sum(amount) as amount from tbl_billing_items where bid= '$id' and prod_cm_stat = 'CM' ")); 
		$cm_amt = $qry1['amount'];
		$qry2 =mysqli_fetch_array(mysqli_query($db,"select sum(amount) as amount from tbl_billing_items where bid= '$id' and prod_cm_stat = 'NCM' ")); 
		$ncm_amt = $qry2['amount'];
	$qry3 =mysqli_fetch_array(mysqli_query($db,"select sum(amount) as amount from tbl_billing_items where bid= '$id' ")); 
		$amt = $qry3['amount'];
	//echo $amount;
	$final=$amt;
	echo $final."~".$cm_amt."~".$ncm_amt;
	?>
	