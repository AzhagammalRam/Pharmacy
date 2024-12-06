<?php

$fromdate = $_REQUEST['fromdate'];
	$fromto = $_REQUEST['fromto'];
	
	
	
	require('fpdf/fpdf.php');
	include("../config.php");
	
	class PDF extends FPDF {
		function Header() {
		    $this->SetFont('Times','',16);
		    $this->SetY(0.25);
	//		$this->Image("images/hycare.jpg", 2.25, .25, 4, .75);
//		    $this->SetY(1);
			// $this->Image("NEWIMG.jpg", 2.90, 4, 4, 2);
		}
		function Footer() {
	//	    $this->Image("images/address.jpg", 2.30, 10.8, 4, .75);
		}
	}


	
	
	
	/*$d1 = implode("-", array_reverse(explode("/",$fromdate)));
	if($fromto == "")	$d2 = $d1;
	else $d2 = implode("-", array_reverse(explode("/",$fromto)));*/
	

		$d1 = $fromdate;
	if($fromto == "")	$d2 = $d1;
	$d2 = $fromto;




$pdf=new PDF("P","in",array(9.8,10));
$pdf->SetMargins(0.2,0,5);
$pdf->AddPage();
$pdf->SetFont('Times','B',20);

$pdf->MultiCell(8.6, 0.25, "Murugan Pharmacy" , '0', "C");
$pdf->SetFont('Times','B',12);
$pdf->MultiCell(8.6, 0.25, "(Unit of Murugan Hospitals)" , '0', "C");
$pdf->SetFont('Times','I',12);
$pdf->MultiCell(8.6, 0.25, "No.264/125, Kilpauk Garden Road," , '0', "C");
$pdf->MultiCell(8.6, 0.25, "Kilpauk, Chennai-600 010." , '0', "C");
$pdf->MultiCell(8.6, 0.25, "ph.No.26448989/26440519" , '0', "C");
$pdf->MultiCell(8.6, 0.25, "E-mail : muruganhospitals@gmail.com" , '0', "C");
$pdf->MultiCell(8.6, 0.25, "Website : www.muruganhospitals.in" , '0', "C");
$pdf->SetFont('Times','',10);
$pdf->MultiCell(8.6, 0.25, "DL No. 2501/MZII/21" , '0', "C");


$pdf->Ln(.35);
$i = 1;
$pdf->SetFont('Times','B',14);
$pdf->Cell(0.4, 0.25, "S.No", '1','0', "C");
$pdf->Cell(3.5, 0.25, "Drug Name", '1','0', "C");
$pdf->Cell(2.5, 0.25, "Batch No", '1','0', "C");
$pdf->Cell(1.0, 0.25, "expiry", '1','0', "C");
//$pdf->Cell(1.0, 0.25, "Qty", '1','0', "C");
$pdf->Cell(1.0, 0.25, "avail", '1','0', "C");
$pdf->Cell(1.0, 0.25, "MRP", '1','0', "C");

$pdf->Ln();



$sql = "SELECT tbl_productlist.productname,tbl_productlist.stocktype, batchno, expirydate, qty, aval, tbl_purchaseitems.mrp
FROM tbl_purchaseitems
JOIN tbl_productlist ON tbl_productlist.id = tbl_purchaseitems.productid ORDER BY tbl_productlist.stocktype"; 
$res = mysql_query($sql);		
while($rs = mysql_fetch_array($res)){
$pdf->SetFont('Times','B',10);
	$pdf->Cell(0.4, 0.25, $i++, '1','0', "C");
	$pdf->Cell(3.5, 0.25, $rs['productname'], '1','0', "L");
	
	$pdf->Cell(2.5, 0.25, $rs['batchno'], '1','0', "L");
	$pdf->Cell(1.0, 0.25, $rs['expirydate'], '1','0', "C");
	//$pdf->Cell(1.0, 0.25, $rs['qty'], '1','0', "C");
$pdf->Cell(1.0, 0.25, '', '1','0', "L");
	//$pdf->Cell(1.0, 0.25, $rs['aval'], '1','0', "L");
	
	$pdf->Cell(1.0, 0.25, $rs['mrp'], '1','0', "L");
	
	
	
	$pdf->Ln();

}



	$pdf->Output();




		
/*	$array = array();
	$res = mysql_query($sql);
	
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=schedule_Report.xls");
header("Pragma: no-cache");
header("Expires: 0");

	$header = array("Drug Name","S.Type","Patient Name","Bill#","Qty", "BatchNo","Expirydate");
	echo implode("\t",$header). "\r\n";
	
	while($rs = mysql_fetch_array($res)){
		//$xtotal += $rs['totalamt'];

		echo $rs['productname'] . "\t" . $rs['scheduletype'] . "\t" . $rs['patientname'] . "\t" . $rs['billno'] . "\t" . $rs['qty'] . "\t" . $rs['batchno'] . "\t" .$rs['expirydate'] . "\t" . "\r\n";		
		
	}
	//echo "\t\t\t\tTotal\t" . number_format($xtotal,2,".","")  . "\r\n";*/

?>