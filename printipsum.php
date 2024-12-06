<?php

	
	$d1 = $_REQUEST['d1'];
	$d2 = $_REQUEST['d2'];
	$ipno = $_REQUEST['ipno'];
	$paymentmode = $_REQUEST['pm'];

	
	
	error_reporting(0);

	require('fpdf/fpdf.php');
	//require_once("config.php");
	
	class PDF extends FPDF {
	var $javascript; 
		var $n_js; 
	
	function IncludeJS($script) { 
			$this->javascript=$script; 
		} 
		function _putjavascript() { 
			$this->_newobj(); 
			$this->n_js=$this->n; 
			$this->_out('<<'); 
			$this->_out('/Names [(EmbeddedJS) '.($this->n+1).' 0 R]'); 
			$this->_out('>>'); 
			$this->_out('endobj'); 
			$this->_newobj(); 
			$this->_out('<<'); 
			$this->_out('/S /JavaScript'); 
			$this->_out('/JS '.$this->_textstring($this->javascript)); 
			$this->_out('>>'); 
			$this->_out('endobj'); 
		} 
	function _putresources() { 
			parent::_putresources(); 
			if (!empty($this->javascript)) { 
				$this->_putjavascript(); 
			} 
		} 
	
		function _putcatalog() { 
			parent::_putcatalog(); 
			if (!empty($this->javascript)) { 
				$this->_out('/Names <</JavaScript '.($this->n_js).' 0 R>>'); 
			} 
		} 
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
$pdf=new PDF("P","in",array(9.8,12));
$pdf->AliasNbpages();
$pdf->SetMargins(0.5,0,1);
$pdf->AddPage();
	$pdf->SetAutoPageBreak(true);
	$pdf->SetY(0.25);
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
$pdf->SetFont('Times','B',18);
$pdf->MultiCell(8.6, 0.25, "DL No  : 2501/MZII/21" , '0', "C");

$pdf->Ln(.35);
$pdf->SetFont('Times','B',14);

$pdf->MultiCell(8.6, 0.25, "IP BILL SUMMARY" , '0', "C");
$pdf->Ln(.35);
require_once("config.php");
$cmd = mysqli_query($db,"SELECT  patientname, drname FROM tbl_billing WHERE phno='$ipno' and del_status != 1 ");
$rs = mysqli_fetch_array($cmd);

$amount = $rs['paidamt'];
$pdf->SetFont('Times','',16);
$pdf->Cell(5.5, 0.25, "Patient Name   : ".$rs['patientname'], '0','0', "L");
$pdf->Cell(1.5, 0.25, "From Date  : ".date("d-M-Y" ,strtotime($d1)), '0','0', "L");
$pdf->Ln();
$pdf->Cell(5.5, 0.25, "Doctor's Name : ".$rs['drname'], '0','0', "L");
$pdf->Cell(1.5, 0.25, "To Date      : ".date("d-M-Y" ,strtotime($d2)), '0','0', "L");

$pdf->Ln(.35);

$i = 1;
$pdf->SetFont('Times','B',16);
$pdf->Cell(0.5, 0.25, "S.No", '1','0', "C");
$pdf->Cell(1.5, 0.25, "Bill Date", '1','0', "C");
$pdf->Cell(3.0, 0.25, "Bill Number", '1','0', "C");
$pdf->Cell(2.0, 0.25, "IP No", '1','0', "C");


$pdf->Cell(1, 0.25, "Amount", '1','0', "C");
$pdf->Ln();
$pdf->SetFont('Times','',16);

$sql1 = "SELECT cast(datentime as date) as billdate, phno, patientname,  billno, totalamt, paymentmode FROM tbl_billing WHERE (datentime BETWEEN '$d1' AND '$d2') AND phno='$ipno' and del_status != 1 ";
	if($paymentmode == "all")
		$sql1 .= "";
	else
		$sql1 .= "AND paymentmode = '$paymentmode' ";
$sql = mysqli_query($db,$sql1);
while($rs = mysqli_fetch_array($sql)){

			$xtotal += $rs['totalamt'];
	$pdf->Cell(0.5, 0.25, $i++, 'L','0', "C");
	$pdf->Cell(1.5, 0.25, $rs['billdate'], 'L','0', "L");
	$pdf->Cell(3.0, 0.25, $rs['billno'], 'L','0', "C");
	$pdf->Cell(2.0, 0.25, $rs['phno'], 'L','0', "C");
	$pdf->Cell(1.0, 0.25, $rs['totalamt'], 'LR','0', "C");
	$pdf->Ln();
}

$sql_return = "SELECT cast(datentime as date) as billdate, phno, patientname,  billno, totalamt, paymentmode FROM tbl_drug_return_billing WHERE (datentime BETWEEN '$d1' AND '$d2') AND phno='$ipno' ";
$sql_ret = mysqli_query($db,$sql_return);
while($rs_return = mysqli_fetch_array($sql_ret)){
$xtotal_return += $rs_return['totalamt'];
		
	$pdf->Cell(0.5, 0.25, $i++, 'L','0', "C");
	$pdf->Cell(1.5, 0.25, $rs_return['billdate'], 'L','0', "L");
	$pdf->Cell(3.0, 0.25, $rs_return['billno'].'(return)', 'L','0', "C");
	$pdf->Cell(2.0, 0.25, $rs_return['phno'], 'L','0', "C");
	$pdf->Cell(1.0, 0.25, -$rs_return['totalamt'], 'LR','0', "C");
	$pdf->Ln();
}

	$pdf->Cell(7, 0.25, 'Total Credit Bill Amount  ', '1','0', "R");
$pdf->Cell(1, 0.25, $xtotal, '1','0', "C");
$pdf->Ln();

	$pdf->Cell(7, 0.25, 'Total Return Bill Amount  ', '1','0', "R");
$pdf->Cell(1, 0.25, $xtotal_return, '1','0', "C");
$pdf->Ln();

if($paymentmode!='Credit-Claim')
{
$pdf->Cell(7, 0.25, 'Paid Amount  ', '1','0', "R");
//$pdf->Cell(1, 0.25, '5671', '1','0', "C");
$pdf->Cell(1, 0.25, $xtotal-$xtotal_return, '1','0', "C");
$pdf->Ln(0.35);
$pdf->MultiCell(9, 0.25, "Patient has cleared all IP Credit Bills." , '0', "C");
$pdf->MultiCell(9, 0.25, "" , '0', "C");
}
// $pdf->IncludeJS("print('true');");
	$pdf->Output();
?>
