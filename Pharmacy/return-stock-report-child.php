<?php
	session_start();
	if(!isset($_SESSION['phar-username']) || (trim($_SESSION['phar-username']) == '')) {
		header("location:login.php");
		exit();
	}
	include("config.php");
	
	$invoice = $_REQUEST['invoice'];
	
	require('fpdf/fpdf.php');

	$sql= "select * from tbl_stock_transfer_item where id=$invoice";
	$res = mysqli_query($db,$sql);

	$query="select * from tbl_stock_transfer where id=$invoice";
	$res1=mysqli_query($db,$query);
	class PDF extends FPDF {
		function Header() {
		$this->SetFont('Times','',16);
		$this->SetY(0.25);
		// $this->Image("images/NEWIMG.jpg", 2.90, 4, 4, 2);
		}
		function Footer() {
		}
	}
	$pdf=new PDF("P","in",array(9.9,10));
	$pdf->SetMargins(0.4,1,1);
	$pdf->setAutopagebreak(true);
	$pdf->AddPage();
	$pdf->SetFont('Times','B',20);

	$pdf->MultiCell(8.6, 0.25, "RaagaaMed" , '0', "C");
	$pdf->SetFont('Times','B',16);
	$pdf->MultiCell(8.6, 0.25, "(Unit Of RaagaaMed Hospital)" , '0', "C");
	$pdf->SetFont('Times','I',10);
	$pdf->MultiCell(8.6, 0.25, "No.4/68, II Floor, C1," , '0', "C");
	$pdf->MultiCell(8.6, 0.25, "Viduthalai Nagar 11th Street,S.Kulathur Chennai-600 117." , '0', "C");
	$pdf->MultiCell(8.6, 0.25, "Phone:+91-9551122260" , '0', "C");
	$pdf->MultiCell(8.6, 0.25, "E-mail : info@raagaamed.com" , '0', "C");
	$pdf->SetFont('Times','',14);

	$pdf->Ln(.35);

	$pdf->MultiCell(8.6, 0.25, "Stock Details", '0', "C");
	$pdf->Ln();
	$pdf->Cell(1.2, 0.25, 'Invoice', '1','0', "C");
	$pdf->Cell(1.2, 0.25, 'Stock From', '1','0', "C");
	$pdf->Cell(1.2, 0.25, 'Stock To', '1','0', "C");
	$pdf->Cell(2, 0.25, 'User', '1','0', "C");
	$pdf->Ln();
	
	while($rs1 = mysqli_fetch_array($res1)){
		$pdf->Cell(1.2, 0.25, $rs1["id"], '1','0', "C");
		$pdf->Cell(1.2, 0.25, $rs1["store_from"], '1','0', "C");
		$pdf->Cell(1.2, 0.25, $rs1["store_to"], '1','0', "C");
		$pdf->Cell(2, 0.25, $rs1["user"], '1','0', "C");
		
	}
	
	$pdf->Ln(.35);
	$pdf->MultiCell(8.6, 0.25, "Items", '0', "C");
	$pdf->Ln();
	$pdf->Cell(1.2, 0.25, 'Invoice', '1','0', "C");
	$pdf->Cell(1.2, 0.25, 'Batch', '1','0', "C");
	$pdf->Cell(1.2, 0.25, 'Expiry', '1','0', "C");
	$pdf->Cell(2, 0.25, 'Product name', '1','0', "C");
	$pdf->Cell(0.8, 0.25, 'Qty', '1','0', "C");
	$pdf->Cell(1.2, 0.25, 'User', '1','0', "C");
	$pdf->Cell(0.8, 0.25, 'Mrp', '1','0', "C");
	$pdf->Cell(0.8, 0.25, 'Pprice', '1','0', "C");
	
	$pdf->Ln();

	while($rs = mysqli_fetch_array($res)){
		$pdf->Cell(1.2, 0.25, $rs["id"], '1','0', "C");
		$pdf->Cell(1.2, 0.25, $rs["batchno"], '1','0', "C");
		$pdf->Cell(1.2, 0.25, $rs["expiry"], '1','0', "C");
		$pdf->Cell(2, 0.25, $rs["product_name"], '1','0', "C");
		$pdf->Cell(0.8, 0.25, $rs["qty"], '1','0', "C");
		$pdf->Cell(1.2, 0.25, $rs["user"], '1','0', "C");
		$pdf->Cell(0.8, 0.25, $rs["mrp"], '1','0', "C");
		$pdf->Cell(0.8, 0.25, $rs["pprice"], '1','0', "C");
	}

	$pdf->Output();
?>