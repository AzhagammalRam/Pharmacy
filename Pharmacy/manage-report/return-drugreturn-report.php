<?php
	include("../config.php");
	$dtfrom = $_REQUEST['fromdate'];
	$dtfrom = date("Y-m-d",strtotime($_REQUEST['fromdate'])).' '.'00:00:00';
	$dtto = $_REQUEST['fromto'];
	

	$sql = "select * from tbl_drug_return_billing  WHERE ";
	

	if ($dtfrom!='')
	{
		 $sql .= " (datentime BETWEEN '$dtfrom' AND '$dtto') ";
	}
		

	$res = mysql_query($sql);
	$array = array();
	$result='';
	while($rs = mysql_fetch_array($res)){
		$id = $rs['id'];

		 
		
			$pat_id= $rs['phno'];
			
			 $sql2 = "SELECT  cast(datentime as date) as billdate, batchno, qty, amount FROM tbl_drug_return_billing_items WHERE bid='$id' AND `datentime` BETWEEN '$dtfrom' AND '$dtto'";
			$result2 = mysql_query($sql2);
		while($r_s2 = mysql_fetch_array($result2))
		{

			
			$result.= "<tr>
	      	<td>".$r_s2['billdate']."</td>
	     	<td>".$pat_id ."</td>
				<td>". $r_s2['batchno']."</td>				
				<td>".$r_s2['qty']."</td>
				<td>".$r_s2['amount']."</td></tr>";
			}
			

		}

		echo $result;
?>

