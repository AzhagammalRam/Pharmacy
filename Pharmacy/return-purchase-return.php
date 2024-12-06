<?php
	include("../config.php");
	$dtfrom = $_REQUEST['dtfrom'];
	$dtto = $_REQUEST['dtto'];
	$supplier = $_REQUEST['supplier'];
	$invoice = $_REQUEST['invoice'];
if($supplier)
{
	$gsid=mysql_query("select * from tbl_supplier where suppliername = '$supplier'");
	$res2=mysql_fetch_array($gsid);
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

	$res = mysql_query($sql);
	$array = array();
	while($rs = mysql_fetch_array($res)){
		
			$sid=$rs["supplierid"];
			$getsupid=mysql_query("select * from tbl_supplier where id=$sid");
			$supid = mysql_fetch_array($getsupid);
			$supplierid1=$supid['id'];
			$supplier=$supid['suppliername'];
		
		
		
		$array[] = array("date"=>$rs['invoicedate'],"id"=>$rs['id'], "invoiceno"=>$rs['invoiceno'],"supplierid"=>$supplierid1, "supplier"=>$supplier, "invoiceamt"=>$rs['invoiceamt']);
	}
	echo json_encode($array);
?>