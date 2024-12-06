<?php
	include("../config.php");
	$fromdate = $_REQUEST['fromdate'];
	$fromto = $_REQUEST['fromto'];
	$paymentmode = $_REQUEST['paymentmode'];
	$billtype = $_REQUEST['billtype'];
	
	/*$d1 = implode("-", array_reverse(explode("/",$fromdate)));
	if($fromto == "")	$d2 = $d1;
	else $d2 = implode("-", array_reverse(explode("/",$fromto)));*/
	
	$d1 = $fromdate;
	if($fromto == "")	$d2 = $d1;
	$d2 = $fromto;
	
	$sql = "SELECT cast(datentime as date) as billdate, billno, phno, patientname, drname, totalamt, paymentmode FROM tbl_billing WHERE (datentime BETWEEN '$d1' AND '$d2')  and del_status != 1  AND ";
	if($paymentmode == "all")
		$sql .= "paymentmode like '%' AND ";
	else
		$sql .= "paymentmode = '$paymentmode' AND ";
		
	$sql .= "status != 2";
	$array = array();
	$res = mysqli_query($db,$sql);
	$xtotal = 0;
	$result='';
	while($rs = mysqli_fetch_array($res)){
		$xtotal += $rs['totalamt'];
		$result.= "<tr>
	      <td>".$rs['billdate']."</td>
				<td><a href='printbill.php?billno=".$rs['billno']."&type=1&payment=".$rs['phno']."' target='_blank' style='text-decoration:none;'>".$rs['billno']."</a></td>


				
				<td>".$rs['patientname']."</td>
				<td>".$rs['drname']."</td>
				<td>". $rs['paymentmode']."</td>
				<td>".$rs['totalamt']."</td>
				
	</tr>";
		//$array[] = array("date"=> implode("/", array_reverse(explode("-",$rs['billdate']))), "billno"=>$rs['billno'], "paymentmode" => $rs['paymentmode'], "patientname" => $rs['patientname'], "drname" => $rs['drname'], "totalamt" => $rs['totalamt']); 
	}
 $sql_return = "SELECT cast(datentime as date) as billdate,drname , phno, patientname,  billno, totalamt, paymentmode FROM tbl_sales_return_billing WHERE (datentime BETWEEN '$d1' AND '$d2') ";
	if($paymentmode == "all")
		$sql_return .= "";
	else
		$sql_return .= "AND paymentmode = '$paymentmode' ";
	
	$xtotal_return =0;
	$res_return = mysqli_query($db,$sql_return);
	while($rs_return = mysqli_fetch_array($res_return)){
		
		$xtotal_return += $rs_return['totalamt'];
	}

	$sql_returns = "SELECT cast(datentime as date) as billdate,drname , phno, patientname,  billno, totalamt, paymentmode FROM tbl_drug_return_billing WHERE (datentime BETWEEN '$d1' AND '$d2') ";
	if($paymentmode == "all")
		$sql_returns .= "";
	else
		$sql_returns .= "AND paymentmode = '$paymentmode' ";
	
	$xtotal_returns =0;
	$res_returns = mysqli_query($db,$sql_returns);
	while($rs_returns = mysqli_fetch_array($res_returns)){
		
		$xtotal_returns += $rs_returns['totalamt'];
		
		
	}
if($xtotal_return != 0){
	$result.= "<tr>
	      <td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>Total Sales return</td>
				<td>".-$xtotal_return.' (return)'."</td>		
	</tr>";
}
	$result.= "<tr>
	      <td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>Total Drug return</td>
				<td>".-$xtotal_returns.' (return)'."</td>		
	</tr>";
				





	$GrandTotal=$xtotal-$xtotal_return-$xtotal_returns;
	
	$result.="<tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th style='text-align: right;'>Total Sales</th><th style='text-align:center;'>".$xtotal."</th></tr>";
	$result.="<tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th style='text-align: right;'>Grand Total</th><th style='text-align:center;'>".$GrandTotal."</th></tr>";

	echo $result;
	//$array[] = array("tamt"=>number_format($xtotal,2,".",""));
	//echo json_encode($array);
?>