<?php
	require_once("../config.php");
	$fromdate = $_REQUEST['fromdate'];
	$fromto = $_REQUEST['fromto'];
	$ipno = $_REQUEST['ipno'];
	$paymentmode = $_REQUEST['pm'];
	
	
	//$paymentmode = $_REQUEST['paymentmode'];
	//$billtype = $_REQUEST['billtype'];
	
	/*$d1 = implode("-", array_reverse(explode("/",$fromdate)));
	if($fromto == "")	$d2 = $d1;
	else $d2 = implode("-", array_reverse(explode("/",$fromto)));*/
	
	$d1 = $fromdate;
	if($fromto == "")	$d2 = $d1;
	$d2 = $fromto;
	
	$sql = "SELECT cast(datentime as date) as billdate, phno, patientname,  billno, totalamt, paymentmode FROM tbl_billing WHERE (datentime BETWEEN '$d1' AND '$d2')  and del_status != 1  AND phno='$ipno'  ";
	if($paymentmode == "all")
		$sql .= "";
	else
		$sql .= "AND paymentmode = '$paymentmode' ";
	
	$array = array();
	$res = mysqli_query($db,$sql);
	$xtotal = 0;
	$result='';
	while($rs = mysqli_fetch_array($res)){
		$xtotal += $rs['totalamt'];
		//$array[] = array("date"=> implode("/", array_reverse(explode("-",$rs['billdate']))), "billno"=>$rs['billno'], "paymentmode" => $rs['paymentmode'], "patientname" => $rs['patientname'], "phno" => $rs['phno'], "totalamt" => $rs['totalamt']); 
		
		$result.= "<tr>
	      <td>".$rs['billdate']."</td>
				<td>". $rs['phno']."</td>
				<td>". $rs['patientname']."</td>
				<td>".$rs['billdate']."</td>
				<td><a href='printbill.php?billno=".$rs['billno']."&type=1&payment=".$rs['phno']."' target='_blank' style='text-decoration:none;'>".$rs['billno']."</a></td>
				<td>".$rs['totalamt']."</td>
				
	</tr>";
	
	}
	
	$sql_return = "SELECT cast(datentime as date) as billdate, phno, patientname,  billno, totalamt, paymentmode FROM tbl_drug_return_billing WHERE (datentime BETWEEN '$d1' AND '$d2') AND phno='$ipno'  ";
	if($paymentmode == "all")
		$sql_return .= "";
	else
		$sql_return .= "AND paymentmode = '$paymentmode' ";
	
	$xtotal_return =0;
	$res_return = mysqli_query($db,$sql_return);
	while($rs_return = mysqli_fetch_array($res_return)){
		
		$xtotal_return += $rs_return['totalamt'];
		
		$result.= "<tr>
	      <td>".$rs_return['billdate']."</td>
				<td>". $rs_return['phno']."</td>
				<td>". $rs_return['patientname']."</td>
				<td>".$rs_return['billdate']."</td>
				<td><a href='dr_printbill.php?billno=".$rs_return['billno']."&type=2' target='_blank' style='text-decoration:none;'>".$rs_return['billno']."</a></td>
				<td>".-$rs_return['totalamt'].' (return)'."</td>
				
	</tr>";
		
	}
	$GrandTotal=$xtotal-$xtotal_return;
	
	$result.="<tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th style='text-align: right;'>Total Purchased</th><th style='text-align:center;'>".$xtotal."</th></tr>";
	$result.="<tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th style='text-align: right;'>Total Return</th><th style='text-align:center;'>".$xtotal_return."</th></tr>";
	$result.="<tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th style='text-align: right;'>Grand Total</th><th style='text-align:center;'>".$GrandTotal."</th></tr>";

	echo $result;
	//$array[] = array("tamt"=>number_format($xtotal,2,".",""));
	//echo json_encode($array);
	

?>