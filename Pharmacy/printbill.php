<?php 
session_start();
$user_nm = $_SESSION['phar-username'];
$billno = $_REQUEST['billno'];
$type = $_REQUEST['type'];
if(isset($_REQUEST['payment']))
{
$ip_id = $_REQUEST['payment'];
}
if($type==1){
$status=1;
$typename = 'Billing';
}
else if ($type==2) {
$status=0;
$typename = 'Sales Return';
$sale_ret_id = $_REQUEST['sale_ret'];
}

include('fpdf/fpdf.php');
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
function myCell($w,$h,$x,$t)
{
	$height = $h/3;
	$first = $height+0.5;
	$second = $height+$height+$height+0.5;
	$len = strlen($t);
	if($len > 50)
	{
		$txt = str_split($t,40);
		$this->SetX($x);
		$this->Cell($w,$first-0.4,$txt[0],'','LTRB','C');
		$this->SetX($x);
		$this->Cell($w,$second-0.3,$txt[1],'','LTRB','C');
		$this->SetX($x);
		$this->Cell($w,$h,'','LTRB',0,'L',0);
	}
	else{
		$this->SetX($x);
		$this->Cell($w,$h,$t,'LTRB',0,'C',0);
	}
}

}
include("config-db1.php");
if($ip_id==''){
$sqlpater= "select * from `$dps_patients`.`patientdetails` where `ip_id` = '' order by id desc limit 1";
$resultpater=mysqli_query($db1,$sqlpater);
$num=mysqli_num_rows($resultpater);
$rowpater=mysqli_fetch_array($resultpater);
$insurance_type=$rowpater['insurance_type'];
$patientid=$rowpater['patientid'];
$paymode="Cash";

}else{
// $sqlpat= "select * from `$dps_patients`.`patientdetails` where `ip_id` = '$ip_id' order by id desc limit 1";
$resultpat=mysqli_query($db1,"select * from `$dps_patients`.`billing` where `ip_id` = '$ip_id' order by id desc limit 1");
// $resultpat=mysqli_query($db,$sqlpat);
$num=mysqli_num_rows($resultpat);
$stat = 1;
if($num == 0)
{	

	$resultpat=mysqli_query($db1,"select * from `$dps_patients`.`patientdetails` where `ip_id` = '$ip_id' order by id desc limit 1");
    $stat = 0;
}
$num=mysqli_num_rows($resultpat);
$rowpat=mysqli_fetch_array($resultpat);
if($stat == 0)
{
	$insurance_type=$rowpat['insurance_type'];
}elseif ($stat == 1) {
	$insurance_type=$rowpat['insurance'];
}


$patientid=$rowpat['patientid'];
include("config-db2.php");
$sqlpate= "select * from `$dps_master`.`insurance_creation` where `id` = '$insurance_type' order by id desc limit 1";
$resultpate=mysqli_query($db2,$sqlpate);
$num=mysqli_num_rows($resultpate);
$rowpate=mysqli_fetch_array($resultpate);
$name=$rowpate['name'];
if($insurance_type != '1')
{
$paymode=$name;
}
}	


$pdf=new PDF("P","in",array(9.9,10));
$pdf->SetMargins(0.5,0,1);
$pdf->setAutopagebreak(true);
$pdf->AddPage();
//$pdf->setAutopagebreak(true);
$pdf->SetFont('Times','B',20);

$pdf->MultiCell(8.6, 0.25, "Murugan Pharmacy" , '0', "C");
$pdf->SetFont('Times','B',16);
$pdf->MultiCell(8.6, 0.25, "(Unit of Murugan Hospitals)" , '0', "C");
$pdf->SetFont('Times','I',10);
$pdf->MultiCell(8.6, 0.2, "No.264/125, Kilpauk Garden Road," , '0', "C");
$pdf->MultiCell(8.6, 0.2, "Kilpauk, Chennai-600 010." , '0', "C");
$pdf->MultiCell(8.6, 0.2, "ph.No.26448989/26440519" , '0', "C");
$pdf->MultiCell(8.6, 0.2, "E-mail : muruganhospitals@gmail.com" , '0', "C");
$pdf->MultiCell(8.6, 0.2, "Website : www.muruganhospitals.in" , '0', "C");
$pdf->SetFont('Times','',10);
$pdf->MultiCell(8.6, 0.25, "DL No. 2501/MZII/21" , '0', "C");
$pdf->SetFont('Times','U',16);
$pdf->SetFont('Times','BU',16);
$pdf->MultiCell(8.6, 0.26, $typename, '0', "C");
$pdf->Ln(.35);

$cmd = mysqli_query($db,"SELECT datentime, patientname, drname, billno, paidamt,username FROM tbl_billing WHERE billno = '$billno' and del_status != 1");
$rs = mysqli_fetch_array($cmd);

$datentime=date("d-m-Y" ,strtotime($rs['datentime']));

$amount = $rs['paidamt'];
$pdf->SetFont('Times','B',14);
//$pdf->Cell(6, 0.25, "Patient Name   : ".$rs['patientname'], '0','0', "L");
$pdf->Cell(8.7, 0.25, "GST No  : 33AAVPS4957R1ZE", '0','0', "R");

$pdf->Ln();
$pdf->SetFont('Times','',16);
$pdf->Cell(6, 0.25, "Patient Name     : ".$rs['patientname'], '0','0', "L");
$pdf->Cell(1.8, 0.25, "Date        : ".$datentime, '0','0', "L");
$pdf->Ln();
$pdf->Cell(6, 0.25, "Doctor's Name   : ".$rs['drname'], '0','0', "L");



$pdf->Cell(1.8, 0.25, "Bill #       : ".$rs['billno'], '0','0', "L");
$pdf->Ln();
$pdf->Cell(6, 0.25, "Billed by            : ".$rs['username'], '0','0', "L");
if($num != 0 && $insurance_type != NULL && $insurance_type != "1"){
	$pdf->Ln();
$pdf->Cell(6, 0.25, "Insurance Name : ".$paymode, '0','1', "L");
}


$pdf->Ln(.35);

$w =0.5;
$h =0.35;
$x = $pdf->GetX(); 

$i = 1;
$pdf->SetFont('Times','B',14);
$pdf->Cell(0.5, 0.25, "S.No", '1','0', "C");
if($num != 0 && $insurance_type != NULL && $insurance_type != "1")
{
	$pdf->Cell(3.5, 0.25, "Particulars", '1','0', "C");
// $pdf->Cell(0.6, 0.25, "Claim", '1','0', "C");
}else
{
	$pdf->Cell(3.5, 0.25, "Particulars", '1','0', "C");
}

$pdf->Cell(0.6, 0.25, "Qty", '1','0', "C");
$pdf->Cell(1.2, 0.25, "Batch #", '1','0', "C");
$pdf->Cell(1, 0.25, "Expiry", '1','0', "C");
$pdf->Cell(1, 0.25, "Tax%", '1','0', "C");

$pdf->Cell(1.5, 0.25, "Amount", '1','0', "C");
$pdf->Ln();
$pdf->SetFont('Times','',16);
if($type==1){

$sql = mysqli_query($db,"SELECT * FROM tbl_billing_items WHERE billno = '$billno' and del_status != 1 " );
// echo "SELECT * FROM tbl_billing_items WHERE billno = $billno AND status = '$status'";
}
else if ($type==2) {
$sql = mysqli_query($db,"SELECT * FROM tbl_sales_return_billing_items WHERE billno = '$billno' AND status =1 AND bid = '$sale_ret_id'");
}

while($r = mysqli_fetch_array($sql)){

$code = $r['code'];
$qty = $r['qty'];
$returnqty = $r['returnqty'];
$amount = $r['amount'];
// $totalqty=$qty-$returnqty;
// $perprice=$amount/$qty;
// $totalprice=$perprice*$returnqty;
$q =  mysqli_query($db,"SELECT * FROM tbl_productlist WHERE id = $code");
$r1 = mysqli_fetch_array($q);
//	$desc = substr($r1['stocktype'],0,3) . '. ' .$r1['productname'];
$desc = $r1['productname'];
$isClaim = $r1['claimtype'];
if($isClaim == 'NCM')
{
	$clm = "No";
}elseif($isClaim == 'CM')
{
	$clm = "Yes";
}elseif($isClaim == '')
{
	$clm = '';
}

$expirydate = implode("/",array_reverse(explode("-",$r['expirydate'])));
$expirydate = substr($expirydate,3);	
// $pdf->Cell(0.5, 0.25, $i++, '1','0', "C");
$pdf->myCell($w,$h-0.1,0.5, $i++);

if($num != 0 && $insurance_type != NULL && $insurance_type != "1")
{
	$pdf->myCell($w+3,$h-0.1,1,$desc);
	// $pdf->myCell($w+0.1,$h-0.1,3.9,$clm);
}else{
	$pdf->myCell($w+3,$h-0.1,1,$desc);
}

// $pdf->Cell(3.5, 0.25, $desc, '1','0', "L");

if($type==1){

	$pdf->myCell($w+0.1,$h-0.1,4.5,$qty);
	// $pdf->Cell(0.6, 0.25, $qty, '1','0', "C");
	}else
	if($type==2){
	
	$pdf->myCell($w+0.1,$h-0.1,4.5,$returnqty);
	// $pdf->Cell(0.6, 0.25, $returnqty, '1','0', "C");	
	}
	
	$pdf->myCell($w+0.7,$h-0.1,5.1,$r['batchno']);
	$pdf->myCell($w+0.5,$h-0.1,6.3,$expirydate);
	$pdf->myCell($w+0.5,$h-0.1,7.3,$r['tax_percentage']);
	$pdf->myCell($w+1,$h-0.1,8.3,$amount);
	// $pdf->Cell(1.2, 0.25, $r['batchno'], '1','0', "C");
	// $pdf->Cell(1, 0.25, $expirydate, '1','0', "C");
	// $pdf->Cell(1, 0.25, $r['tax_percentage'], '1','0', "C");  
	// $pdf->Cell(1.5, 0.25, $amount, '1','0', "C");
	
	$pdf->Ln();
	}
	if($type==1){
		$b =  mysqli_query($db,"SELECT * FROM tbl_billing WHERE billno ='$billno' AND del_status != 1");
	}
	else if ($type==2) {
	$b =  mysqli_query($db,"SELECT * FROM tbl_sales_return_billing WHERE billno ='$billno'AND id = '$sale_ret_id'");
	
	}
	$r2 = mysqli_fetch_array($b);
	
	$exchange_rate_id=$r2['exchange_rateid'];
	if($exchange_rate_id=='0'){
	$exchange_rate=1;
	
	}
	else{
		
	include("config-db2.php");
	$exchange_rate_query=mysqli_query($db2,"SELECT * FROM `dps_master`.`currency_exchange` WHERE `id`='$exchange_rate_id'");
	$exchange_rate_res=mysqli_fetch_array($exchange_rate_query);
	$exchange_rate=$exchange_rate_res['exchange_rate'];
	}
	$pdf->Cell(7.8, 0.25, 'Total Amount  ', '1','0', "R");
	if($type==1){
	$pdf->Cell(1.5, 0.25, $r2['netamt']*$exchange_rate, '1','0', "C");
	}
	else if ($type==2) {
	
	$pdf->Cell(1.5, 0.25, $r2['totalamt']*$exchange_rate, '1','0', "C");
	
	}
	$pdf->Ln();
	if($r2['discount']!='0'){
	$pdf->Cell(7.8, 0.25, 'Discount Amount  ', '1','0', "R");
	$pdf->Cell(1.5, 0.25, $r2['discount']*$exchange_rate, '1','0', "C");
	$pdf->Ln();
	$pdf->Cell(7.8, 0.25, 'Total  ', '1','0', "R");
	if($type==1){
	$pdf->Cell(1.5, 0.25, $r2['totalamt']*$exchange_rate, '1','0', "C");
	}
	else if ($type==2) {
		$pdf->Cell(1.5, 0.25, $r2['finalamt']*$exchange_rate, '1','0', "C");
	}
	$pdf->Ln();
	}
	$pdf->Cell(7.8, 0.25, 'Payment Mode  ', '1','0', "R");
	$pdf->Cell(1.5, 0.25, $r2['paymentmode'], '1','0', "C");
	$pdf->Ln(.35);
	$pdf->Ln(.35);
	if($type==1){
	$query=mysqli_query($db,"select Distinct(tax_percentage), tax_type from `tbl_billing_items` where `billno` = '$billno' and del_status != 1");
	while($result=mysqli_fetch_array($query)){
	$percentage = $result['tax_percentage'];
	$tax_type=$result['tax_type'];
	if($tax_type!='0'){
		$pdf->SetFont('Times','B',14);
	$pdf->Cell(6, 0.25, "Tax Summary", '0','0', "L");
	$pdf->Ln(.35);
	$i = 1;
	
	$pdf->Cell(1.3, 0.25, "Type", '1','0', "C");
	$pdf->Cell(3.5, 0.25, "Tax Amount", '1','0', "C");
	// $pdf->Cell(1.5, 0.25, "Amount", '1','0', "C");
	$pdf->Ln();
	$pdf->SetFont('Times','',12);
	$query1 = mysqli_query($db,"select sum(tax_amount) as amount from `tbl_billing_items` where `billno` = '$billno' AND `tax_percentage`='$percentage' AND `tax_type`='$tax_type' and del_status != 1");
	$result1=mysqli_fetch_array($query1);
	$amt=$result1['amount'];
	if($result['tax_type'] == 2){
	$gstval=$result['tax_percentage'];
	$type='IGST '.$gstval.'%';
	$pdf->Cell(1, 0.25, $type, 'LRB','0', "C");
	$pdf->Cell(3.5, 0.25, number_format($amt*$exchange_rate,2), 'LRB','0', "C");
	$pdf->Ln();
	}
	if($result['tax_type'] == 1){
	$gstval=($result['tax_percentage']/2);
	$type='CGST '.$gstval.'%';
	$type1='SGST '.$gstval.'%';
	$pdf->Cell(1.3, 0.25, $type, 'L','0', "C");
	$pdf->Cell(3.5, 0.25, number_format($amt/2,2), 'LR','0', "C");
	$pdf->Ln();
	$pdf->Cell(1.3, 0.25, $type1, 'LRB','0', "C");
	$pdf->Cell(3.5, 0.25, number_format($amt/2,2), 'LRB','0', "C");
	$pdf->Ln();
	}
	
	}
	}
	}else if ($type==2){
	$query=mysqli_query($db,"select Distinct(tax_percentage), tax_type from `tbl_sales_return_billing_items` where `billno` = '$billno' AND bid = '$sale_ret_id'");
	while($result=mysqli_fetch_array($query)){
	$percentage = $result['tax_percentage'];
	$tax_type=$result['tax_type'];
	if($tax_type!='0'){
	$pdf->Cell(6, 0.25, "Tax Summary", '0','0', "L");
	$pdf->Ln(.35);
	$i = 1;
	$pdf->SetFont('Times','B',16);
	$pdf->Cell(1.3, 0.25, "Type", '1','0', "C");
	$pdf->Cell(3.5, 0.25, "Tax Amount", '1','0', "C");
	// $pdf->Cell(1.5, 0.25, "Amount", '1','0', "C");
	$pdf->Ln();
	$pdf->SetFont('Times','',16);
	$query1 = mysqli_query($db,"select sum(taxamount) as amount from `tbl_sales_return_billing_items` where `billno` = '$billno' AND `tax_percentage`='$percentage' AND `tax_type`='$tax_type'  AND bid = '$sale_ret_id'");
	$result1=mysqli_fetch_array($query1);
	$amt=$result1['amount'];
	if($result['tax_type'] == 2){
	$gstval=$result['tax_percentage'];
	$type='IGST '.$gstval.'%';
	$pdf->Cell(1, 0.25, $type, 'LRB','0', "C");
	$pdf->Cell(3.5, 0.25, number_format($amt*$exchange_rate,2), 'LRB','0', "C");
	$pdf->Ln();
	}
	if($result['tax_type'] == 1){
	$gstval=($result['tax_percentage']/2);
	$type='CGST '.$gstval.'%';
	$type1='SGST '.$gstval.'%';
	$pdf->Cell(1.3, 0.25, $type, 'L','0', "C");
	$pdf->Cell(3.5, 0.25, number_format($amt/2,2), 'LR','0', "C");
	$pdf->Ln();
	$pdf->Cell(1.3, 0.25, $type1, 'LRB','0', "C");
	$pdf->Cell(3.5, 0.25, number_format($amt/2,2), 'LRB','0', "C");
	$pdf->Ln();
	}
	
	}
	}
	
	}
	$pdf->Ln();
	$pdf->MultiCell(8.6, 0.25, "Thank You. Get Well Soon." , '0', "C");
	if($_REQUEST['type']==1){
		$pdf->MultiCell(8.6, 0.25,  "Goods once sold are not returnable." , '0', "C");
	
	}
	$pdf->MultiCell(7.8, 0.25, "" , '0', "C");
	

$pdf->Output();
?>