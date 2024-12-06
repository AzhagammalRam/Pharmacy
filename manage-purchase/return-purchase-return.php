<?php
	include("../config.php");
	$dtfrom = $_REQUEST['dtfrom'];
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
	

	$sql = "SELECT * FROM tbl_purchase WHERE ";
	if($supplier != "")
		$sql .= "supplierid ='$supplierid1' AND ";
	if($invoice != "")
		$sql .= "invoiceno = '$invoice' AND ";

	if ($dtfrom!='')
	{
		$sql .= " (invoicedate BETWEEN '$dtfrom' AND '$dtto') AND";
	}
		
	$sql .= " status = 1";

	$res = mysqli_query($db,$sql);
	$array = array();
	while($rs = mysqli_fetch_array($res)){
		
			$sid=$rs["supplierid"];
			$getsupid=mysqli_query($db,"select * from tbl_supplier where id=$sid");
			$supid = mysqli_fetch_array($getsupid);
			$supplierid1=$supid['id'];
			$supplier=$supid['suppliername'];
		
		
		$res1 = mysqli_query($db,"SELECT * FROM tbl_supplier WHERE id = $supplierid1");
		$r1 = mysqli_fetch_array($res1);
		$supplier = $r1['suppliername'];
		
		
		$array[] = array("date"=>$rs['invoicedate'],"id"=>$rs['id'], "invoiceno"=>$rs['invoiceno'],"supplierid"=>$supplierid1, "supplier"=>$supplier, "invoiceamt"=>$rs['invoiceamt']);
	}
	echo json_encode($array);
?>