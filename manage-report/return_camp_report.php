

<?php
	include("../config.php");
	$fromdate = $_REQUEST['fromdate'];
	$fromto = $_REQUEST['fromto'];
	$d1 = $fromdate;
	if($fromto == "")	$d2 = $d1;
	$d2 = $fromto;
	
	$sql = "select a.*, b.suppliername, c.genericname, c.productname from campmedicine a join tbl_supplier b on a.supplier_id = b.id join tbl_productlist c on c.id = a.prod_code WHERE (a.datentime BETWEEN '$d1' AND '$d2')  ";
			
	$array = array();
	$res = mysql_query($sql);
	$xtotal = 0;
	$result='';
	$i = 1;
	while($rs = mysql_fetch_array($res)){
		$xtotal += $rs['amount'];
		$result.= "<tr>
	      <td>".$i."</td>
				<td>".$rs['datentime']."</td>
				<td>".$rs['suppliername']."</td>
				<td>".$rs['genericname']."</td>
				<td>".$rs['productname']."</td>
				<td>".$rs['batchno']."</td>
				<td>".$rs['qty']."</td>
				<td>".$rs['amount']."</td>
				<td>".$rs['remarks']."</td>
				
	</tr>";
	$i++;

	}
 

	

	$result.="<tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th style='text-align: right;'>Total Sales</th><th style='text-align:center;'>".$xtotal."</th><th>&nbsp;</th></tr>";
	// $result.="<tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th style='text-align: right;'>Grand Total</th><th style='text-align:center;'>".$GrandTotal."</th></tr>";

	echo $result;

?>