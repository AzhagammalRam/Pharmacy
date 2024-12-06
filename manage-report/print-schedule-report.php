<?php
$fromdate = $_REQUEST['fromdate'];
	$fromto = $_REQUEST['todate'];
	$scheduletype = $_REQUEST['scheduletype'];
	
	
	require('../fpdf/fpdf.php');
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




$pdf=new PDF("P","in",array(14,21));
$pdf->SetMargins(0.1,0.01);
$pdf->AddPage();
$pdf->SetFont('Times','B',18);

$pdf->MultiCell(13.5, 0.25, "RaagaaMed" , '0', "C");
$pdf->SetFont('Times','B',12);
$pdf->MultiCell(13.5, 0.25, "(Unit of RaagaaMed Hospitals)" , '0', "C");
$pdf->SetFont('Times','I',12);
$pdf->MultiCell(13.5, 0.25, "No.4/68, II Floor, C1," , '0', "C");
$pdf->MultiCell(13.5, 0.25, "Viduthalai Nagar 11th Street,S.Kulathur Chennai-600 117." , '0', "C");
$pdf->MultiCell(13.5, 0.25, "Phone:+91 9551122260" , '0', "C");
$pdf->MultiCell(13.5, 0.25, "E-mail : info@raagaamed.com" , '0', "C");


$pdf->SetFont('Times','',14);
$pdf->Cell(3, 0.25, "Date  :" . $d1, '0','0', "L");
$pdf->Cell(1.8, 0.25, "To  :" . $d2, '0','0', "L");

$pdf->Ln(.35);
$i = 1;
$pdf->SetFont('Times','B',16);
$pdf->Cell(0.4, 0.25, "S.No", '1','0', "C");

$pdf->Cell(1.1, 0.25, "Manu", '1','0', "C");
$pdf->Cell(2.6, 0.25, "Drug Name", '1','0', "C");

$pdf->Cell(0.4, 0.25, "S.Ty", '1','0', "C");
$pdf->Cell(2.8, 0.25, "Patient Name", '1','0', "C");
$pdf->Cell(2.1, 0.25, "Dr. Name", '1','0', "C");
$pdf->Cell(1.0, 0.25, "Bill#", '1','0', "C");
$pdf->Cell(0.5, 0.25, "Qty", '1','0', "C");
$pdf->Cell(1.4, 0.25, "BatchNo", '1','0', "C");
$pdf->Cell(1.0, 0.25, "Ex. Date", '1','0', "C");
$pdf->Cell(.88, 0.25, "Sign.", '1','0', "C");
$pdf->Ln();



if($scheduletype == 'all') { $sql = "SELECT productname,tbl_manufacturer.manufacturername, scheduletype, patientname, tbl_billing.drname, tbl_billing.billno, qty, batchno, expirydate
FROM tbl_productlist
JOIN tbl_manufacturer ON tbl_manufacturer.id=tbl_productlist.manufacturer
JOIN tbl_billing_items ON tbl_productlist.id = tbl_billing_items.code
JOIN tbl_billing ON tbl_billing.billno = tbl_billing_items.billno WHERE tbl_billing.del_status != 1 AND tbl_billing.datentime BETWEEN '$d1' AND '$d2'"; }
	
	else { $sql = "SELECT productname,tbl_manufacturer.manufacturername, scheduletype, patientname, tbl_billing.drname, tbl_billing.billno, qty, batchno, expirydate
FROM tbl_productlist
JOIN tbl_manufacturer ON tbl_manufacturer.id=tbl_productlist.manufacturer
JOIN tbl_billing_items ON tbl_productlist.id = tbl_billing_items.code
JOIN tbl_billing ON tbl_billing.billno = tbl_billing_items.billno WHERE tbl_billing.del_status != 1 AND tbl_billing.datentime BETWEEN '$d1' AND '$d2' AND scheduletype='".$scheduletype."'"; }
$res = mysql_query($sql);
while($rs = mysql_fetch_array($res)){
$pdf->SetFont('Times','B',16);
	$pdf->Cell(0.4, 0.25, $i++, '1','0', "C");
$pdf->Cell(1.1, 0.25, $rs['manufacturername'], '1','0', "L");
	$pdf->Cell(2.6, 0.25, $rs['productname'], '1','0', "L");
	
	
	$pdf->Cell(0.4, 0.25, $rs['scheduletype'], '1','0', "C");
	$pdf->Cell(2.8, 0.25, $rs['patientname'], '1','0', "L");
	
	$pdf->Cell(2.1, 0.25, $rs['drname'], '1','0', "L");
	
	$pdf->Cell(1.0, 0.25, $rs['billno'], '1','0', "C");
	$pdf->Cell(0.5, 0.25, $rs['qty'], '1','0', "C");
	$pdf->Cell(1.4, 0.25, $rs['batchno'], '1','0', "L");
	$pdf->Cell(1.0, 0.25, $rs['expirydate'],'1','0', "C");
	$pdf->Cell(.88, 0.25,"",'1','0', "C");

	$pdf->Ln();

}

//$pdf->Ln(.80);
//$pdf->SetFont('Times','',15);
//$pdf->Cell(12, 0.25, "Checked By,", '0','0', "R");
//$pdf->Ln(.40);
//$pdf->SetFont('Times','',12);
//$pdf->Cell(11.8, 0.25, "(Pharmacist)", '0','0', "R");

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