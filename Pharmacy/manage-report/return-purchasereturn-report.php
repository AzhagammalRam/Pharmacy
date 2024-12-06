<?php
	include("../config.php");
	$dtfrom = $_REQUEST['dtfrom']. ' 00:00:00';
	$dtto = $_REQUEST['dtto'];
	$supplier = $_REQUEST['supplier'];
	$invoice = $_REQUEST['invoice'];
if($supplier)
{
	$gsid=mysqli_query($db,"select * from tbl_supplier where suppliername = '$supplier'");
	$res2=mysqli_fetch_array($gsid);
	$supplierid1=$res2['id'];
}
if($dtto == "")
	{
	
		$dtto = date("Y-m-d") .' 23:59:59';
	}
	else
	{
		$dtto = $_REQUEST['dtto'] . ' 23:59:59';

	}

	$sql = "SELECT  cast(datentime as date) as billdate, invoiceno, supplierid, totalamount, id, return_invoice FROM tbl_purchase_return WHERE ";
	if($supplier != "")
		$sql .= "supplierid ='$supplierid1' AND ";
	if($invoice != "")
		$sql .= "return_invoice = '$invoice' AND ";

	if ($dtfrom!='')
	{
		$sql .= " (datentime BETWEEN '$dtfrom' AND '$dtto') ";
	}
		

	$res = mysqli_query($db,$sql);
	$array = array();
	while($rs = mysqli_fetch_array($res)){
		
			$sid=$rs["supplierid"];
			$getsupid=mysqli_query($db,"select * from tbl_supplier where id=$sid");
			$supid = mysqli_fetch_array($getsupid);
			$supplierid1=$supid['id'];
			$supplier=$supid['suppliername'];
		
		
		//$res1 = mysqli_query($db,"SELECT * FROM tbl_supplier WHERE id = $supplierid1");
		//$r1 = mysqli_fetch_array($res1);
		//$supplier = $r1['suppliername'];
		
		
		$array[] = array("date"=>implode("/", array_reverse(explode("-",$rs['billdate']))), "id"=>$rs['id'],"return_invoice"=>$rs['return_invoice'], "invoiceno"=>$rs['invoiceno'],"supplierid"=>$supplierid1, "supplier"=>$supplier, "totalamt"=>$rs['totalamount']);
	}
	echo json_encode($array);
	//echo $sql;
	//echo $dtfrom;
?>