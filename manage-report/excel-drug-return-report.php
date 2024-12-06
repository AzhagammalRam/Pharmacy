<?php
	include("../config.php");



	$d1 = $_REQUEST['fromdate'];
	$d1 = date("Y-m-d",strtotime($_REQUEST['fromdate'])).' '.'00:00:00';
	$d2 = $_REQUEST['fromto'];
	

	
	$sql = "select * from tbl_drug_return_billing  WHERE ";
	

	if ($d1!='')
	{
		 $sql .= " (datentime BETWEEN '$d1' AND '$d2') ";
	}
		

	$res = mysql_query($sql);
	$array = array();
	$result='';

	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename= Drug_Return_Report.xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	$header = array("Date","Patient Id","Batch No","Quantity","Amount");
	echo implode("\t",$header). "\r\n";
	while($rs = mysql_fetch_array($res)){
		$id = $rs['id'];

		 
		
			$pat_id= $rs['phno'];
			
			$sql2 = "SELECT  cast(datentime as date) as billdate, batchno, qty, amount FROM tbl_drug_return_billing_items WHERE bid='$id' AND `datentime` BETWEEN '$d1' AND '$d2'";
			$result2 = mysql_query($sql2);


	

		while($r_s2 = mysql_fetch_array($result2))
		{
			echo implode("/", array_reverse(explode("-",$r_s2['billdate']))). "\t" . $pat_id . "\t" . $r_s2['batchno'] . "\t" . $r_s2['qty'] . "\t" . number_format($r_s2['amount'],2,".","") . "\r\n";	
			
			}
			

		}
	

			
	
	
?>