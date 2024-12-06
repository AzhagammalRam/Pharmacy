<?php
	session_start();
	$user_nm = $_SESSION['phar-username'];
	$rid = $_REQUEST['rid'];
	
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
$pdf->SetFont('Times','B',20);

$pdf->MultiCell(8.6, 0.25, "RaagaaMed" , '0', "C");
$pdf->SetFont('Times','B',16);
$pdf->MultiCell(8.6, 0.25, "(Unit of RaagaaMed Hospitals)" , '0', "C");
$pdf->SetFont('Times','I',10);
$pdf->MultiCell(8.6, 0.25, "No.4/68, II Floor, C1," , '0', "C");
$pdf->MultiCell(8.6, 0.25, "Viduthalai Nagar 11th Street,S.Kulathur Chennai-600 117." , '0', "C");
$pdf->MultiCell(8.6, 0.25, "Phone:+91 9551122260" , '0', "C");
$pdf->MultiCell(8.6, 0.25, "E-mail : info@raagaamed.com" , '0', "C");

$pdf->MultiCell(8.6, 0.26, "Purchase Return" , '0', "C");
$pdf->Ln(.35);

$pdf->SetFont('Times','B',14);
$pdf->Cell(8.0, 0.25, "TIN No  : 33276375881", '0','0', "R");

$pdf->Ln();
$pdf->SetFont('Times','',16);

$sql1 = mysqli_query($db,"SELECT * FROM tbl_purchase_return WHERE id = '$rid'");
$rs = mysqli_fetch_array($sql1);
$admindate=$rs['datentime'];

$pdf->Cell(1.8, 0.25, "Date :".date("d-m-Y " ,strtotime($admindate)), '0', '0', "L");
$pdf->Ln();
$pdf->Cell(6, 0.25, "Billed by: ".$user_nm, '0','0', "L");

$pdf->Ln();

$pdf->Ln(.35);

$i = 1;
$pdf->SetFont('Times','B',16);
$pdf->Cell(0.5, 0.25, "S.No", '1','0', "C");
$pdf->Cell(4, 0.25, "Particulars", '1','0', "C");
$pdf->Cell(0.6, 0.25, "Qty", '1','0', "C");
$pdf->Cell(1.2, 0.25, "Reason #", '1','0', "C");
$pdf->Cell(1.5, 0.25, "Amount", '1','0', "C");
$pdf->Ln();
$pdf->SetFont('Times','',16);
$sql = mysqli_query($db,"SELECT * FROM tbl_purchase_return_items WHERE purchase_return_id = '$rid'");
while($r = mysqli_fetch_array($sql)){

	$query=mysqli_query($db,"SELECT * from tbl_productlist where id=".$r['productid']);
	$res=mysqli_fetch_array($query);
	$pname=$res['productname'];
	$pdf->Cell(0.5, 0.25, $i++, 'L','0', "C");
	$pdf->Cell(4, 0.25, $pname  , 'L','0', "C");
	$pdf->Cell(0.6, 0.25, $r['qty'], 'L','0', "C");
	$pdf->Cell(1.2, 0.25, $r['reason'], 'L','0', "C");
	$pdf->Cell(1.5, 0.25, $r['price'], 'LR','0', "C");
	$pdf->Ln();
}
$pdf->Cell(7.8, 0.25, $r2['paymentmode'], '1','0', "C");
$pdf->Output();
?>
