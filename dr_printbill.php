<?php error_reporting(0)?>
<?php
	session_start();
	$user_nm = $_SESSION['phar-username'];
	$billno = $_REQUEST['billno'];

	require('fpdf/fpdf.php');
	require_once("config.php");
	
	class PDF extends FPDF {
		function Header() {
		    $this->SetFont('Times','',16);
		    $this->SetY(0.25);
	//		$this->Image("images/hycare.jpg", 2.25, .25, 4, .75);
//		    $this->SetY(1);
			// $this->Image("images/NEWIMG.jpg", 2.90, 4, 4, 2);
		}
		function Footer() {
	//	    $this->Image("images/address.jpg", 2.30, 10.8, 4, .75);
		}
	}
$pdf=new PDF("P","in",array(9.9,10));
$pdf->SetMargins(0.5,0,1);
$pdf->setAutopagebreak(true);
$pdf->AddPage();
//$pdf->setAutopagebreak(true);
$pdf->SetFont('Times','B',20);

$pdf->MultiCell(8.6, 0.25, "Murugan Pharmacy" , '0', "C");
$pdf->SetFont('Times','B',12);
$pdf->MultiCell(8.6, 0.25, "(Unit of Murugan Hospitals)" , '0', "C");
$pdf->SetFont('Times','I',10);
$pdf->MultiCell(8.6, 0.25, "No.264/125, Kilpauk Garden Road," , '0', "C");
$pdf->MultiCell(8.6, 0.25, "Kilpauk, Chennai-600 010." , '0', "C");
$pdf->MultiCell(8.6, 0.25, "ph.No.26448989/26440519" , '0', "C");
$pdf->MultiCell(8.6, 0.25, "E-mail : muruganhospitals@gmail.com" , '0', "C");
$pdf->MultiCell(8.6, 0.25, "Website : www.muruganhospitals.in" , '0', "C");
$pdf->SetFont('Times','',10);
$pdf->MultiCell(8.6, 0.25, "DL No. 2501/MZII/21" , '0', "C");
$pdf->SetFont('Times','BU',16);
$pdf->MultiCell(8.6, 0.26, "Drug Return" , '0', "C");

$pdf->Ln(.35);

$cmd = mysql_query("SELECT datentime, patientname, drname, billno, paidamt FROM tbl_drug_return_billing WHERE billno = $billno");
$rs = mysql_fetch_array($cmd);

$amount = $rs['paidamt'];
$pdf->SetFont('Times','B',14);
//$pdf->Cell(6, 0.25, "Patient Name   : ".$rs['patientname'], '0','0', "L");
$pdf->Cell(8.0, 0.25, "GST No  : 33AAVPS4957R1ZE", '0','0', "R");

$pdf->Ln();
$pdf->SetFont('Times','',16);
$pdf->Cell(6, 0.25, "Patient Name   : ".$rs['patientname'], '0','0', "L");
$pdf->Cell(1.8, 0.25, "Date  : ".$rs['datentime'], '0','0', "L");
$pdf->Ln();
$pdf->Cell(6, 0.25, "Doctor's Name : ".$rs['drname'], '0','0', "L");
$pdf->Cell(1.8, 0.25, "Bill # : ".$rs['billno'], '0','0', "L");
$pdf->Ln();
$pdf->Cell(6, 0.25, "Billed by          : ".$user_nm, '0','0', "L");

$pdf->Ln(.35);

$i = 1;
$pdf->SetFont('Times','B',16);
$pdf->Cell(0.5, 0.25, "S.No", '1','0', "C");
$pdf->Cell(4, 0.25, "Particulars", '1','0', "C");
$pdf->Cell(0.6, 0.25, "Qty", '1','0', "C");
$pdf->Cell(1.2, 0.25, "Batch #", '1','0', "C");
$pdf->Cell(1, 0.25, "Expiry", '1','0', "C");

$pdf->Cell(1.5, 0.25, "Amount", '1','0', "C");
$pdf->Ln();
$pdf->SetFont('Times','',16);
///$sql = mysql_query("SELECT * FROM tbl_billing_items WHERE billno = $billno AND status = 1");  --- changed on 20th nov
//selecting the header from drug return table  -- added on 20th nov
$sql = mysql_query("SELECT * FROM tbl_drug_return_billing_items  WHERE billno = $billno ");
while($r = mysql_fetch_array($sql)){

	$code = $r['code'];
	$q =  mysql_query("SELECT * FROM tbl_productlist WHERE id = $code");
	$r1 = mysql_fetch_array($q);
//	$desc = substr($r1['stocktype'],0,3) . '. ' .$r1['productname'];
	$desc = $r1['productname'];
		
	$expirydate = implode("/",array_reverse(explode("-",$r['expirydate'])));
	$expirydate = substr($expirydate,3);
		
	$pdf->Cell(0.5, 0.25, $i++, 'L','0', "C");
	$pdf->Cell(4, 0.25, $desc, 'L','0', "L");
	$pdf->Cell(0.6, 0.25, $r['qty'], 'L','0', "C");
	$pdf->Cell(1.2, 0.25, $r['batchno'], 'L','0', "C");
	$pdf->Cell(1, 0.25, $expirydate, 'L','0', "C");
	
	$pdf->Cell(1.5, 0.25, $r['amount'], 'LR','0', "C");
	
	$pdf->Ln();
}
$b =  mysql_query("SELECT * FROM tbl_drug_return_billing WHERE billno =".$rs['billno']);
	$r2 = mysql_fetch_array($b);
$pdf->Cell(7.3, 0.25, 'Total Amount  ', '1','0', "R");
$pdf->Cell(1.5, 0.25, $r2['totalamt'], '1','0', "C");
$pdf->Ln();
if($discount!='0'){
	$pdf->Cell(7.3, 0.25, 'Discount Amount  ', '1','0', "R");
$pdf->Cell(1.5, 0.25, $r2['discount'], '1','0', "C");
$pdf->Ln();


	$pdf->Cell(7.3, 0.25, 'Total  ', '1','0', "R");
$pdf->Cell(1.5, 0.25, $r2['totalamt'], '1','0', "C");
$pdf->Ln();
}
$pdf->Cell(7.3, 0.25, 'Payment Mode  ', '1','0', "R");
$pdf->Cell(1.5, 0.25, $r2['paymentmode'], '1','0', "C");
$pdf->Ln(.35);

$pdf->MultiCell(7.8, 0.25, "Thank You. Get Well Soon." , '0', "C");
$pdf->MultiCell(7.8, 0.25, "" , '0', "C");
	$pdf->Output();
?>
