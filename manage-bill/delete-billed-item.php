<?php
	$id = $_REQUEST['id'];
	include("../config.php");

	$r = mysqli_query($db,"SELECT purchaseid, amount, bid FROM tbl_billing_items WHERE id = $id  and del_status != 1");
	$rs = mysqli_fetch_array($r);
	$pid = $rs['purchaseid'];
	$amt = $rs['amount'];
	$bid = $rs['bid'];
	$ids = explode(";",$pid);
	for($i=0 ; $i<count($ids); $i++){
		$val =  explode("-",$ids[$i]);
		$q = "UPDATE tbl_purchaseitems SET aval = aval + $val[1] WHERE id = $val[0]";
		mysqli_query($db,$q);
	}
	
	$cmd = "DELETE FROM tbl_billing_items WHERE id = $id  and del_status != 1";
	if(mysqli_query($db,$cmd))
	{
		$qry1 =mysqli_fetch_array(mysqli_query($db,"select sum(amount) as amount from tbl_billing_items where bid= '$bid' and prod_cm_stat = 'CM' ")); 
		$cm_amt = $qry1['amount'];
		$qry2 =mysqli_fetch_array(mysqli_query($db,"select sum(amount) as amount from tbl_billing_items where bid= '$bid' and prod_cm_stat = 'NCM' ")); 
		$ncm_amt = $qry2['amount'];
		if($ncm_amt == '')
		{
			$ncm_amt = 0;
		}
		if($cm_amt == '')
		{
			$cm_amt = 0;
		}
		echo 'Deleted !~'.$amt."~".$rs['bid']."~".$cm_amt."~".$ncm_amt;
	}		
	else
	{
		echo mysqli_error($db);
	}
?>
