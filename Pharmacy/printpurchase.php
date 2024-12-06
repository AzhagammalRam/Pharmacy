<?php
	require_once("config.php");
	$billno = $_REQUEST['billno'];

	$cmd = mysqli_query($db,"SELECT datentime, patientname, drname, billno, paidamt FROM tbl_billing WHERE billno = '$billno' and del_status != 1 ");
$rs = mysqli_fetch_array($cmd);

$amount = $rs['paidamt'];
?>
<html>
<head></head>
<body  style="width:500px;">
<table border="0" width="100%">
<tr>
	<th colspan='6'>Murugan Pharmacy</th>
</tr>
<tr>
	<th colspan='6'>(Unit of Murugan Hospitals)</th>
</tr>
<tr>
	<th colspan='6'>No.264/125, Kilpauk Garden Road,</th>
</tr>
<tr>
	<th colspan='6'>Kilpauk, Chennai-600 010.</th>
</tr>
<tr>
	<th colspan='6'>ph.No.26448989/26440519</th>
</tr>
<tr>
	<th colspan='6'>E-mail : muruganhospitals@gmail.com</th>
</tr>
<tr>
	<th colspan='6'>Website : www.muruganhospitals.in</th>
</tr>
<tr>
	<th colspan='6'>DL No : 2501/MZII/20</th>
</tr>
<tr>
	<th colspan='6'>2501/MZII/21</th>
</tr>



<tr>
	<td colspan="5" style="text-align:center"><th>Purchase Items for Invoice No:<?php echo $billno ?></th></td>
</tr>
</table>
<table style="width:500px; border-collapse: collapse;" border="1">
<tr>
	<th>S.No</th>
	<th>Particulars</th>
	<th>Qty</th>
	<th>Batch#</th>
	<th>Expiry</th>
  	<th>MRP</th>
  	<th>TAX (%)</th>
	<th>Amount</th>
</tr>
<?php
$sql = mysqli_query($db,"SELECT * FROM tbl_purchase WHERE invoiceno = '$billno' AND status =1");
$rg = mysqli_fetch_array($sql);
	$code = $rg['id'];
	
	$q =  mysqli_query($db,"SELECT * FROM tbl_purchaseitems WHERE invoiceno = $code");
	while($r = mysqli_fetch_array($q)){ 
	$prodid = $r['productid'];
	$type = $r['tax_type'];
	$sql = mysqli_query($db,"SELECT * FROM tbl_productlist WHERE id = $prodid AND status = 1");
	$pr = mysqli_fetch_array($sql);
	$prodname = $pr['productname'];
	$expirydate = implode("/",array_reverse(explode("-",$r['expirydate'])));
	$expirydate = substr($expirydate,3);

	?>
<tr>
	<td style="text-align:center;">1</td>
	<td style="text-align:center;"><?php echo $prodname; ?></td>
	<td style="text-align:center;"><?php echo  $r['qty']; ?></td>
	<td style="text-align:center;"><?php echo $r['batchno']; ?></td>
	<td style="text-align:center;"><?php echo $expirydate; ?></td>
	<td style="text-align:center;"><?php echo $r['mrp']; ?></td>
	<?php 
	if($r['tax_type'] == 2){
		$gstval = $r['tax_percentage'];
		$type='IGST '.$gstval.'%';
		?>
	<td style="text-align:center;"><?php echo $type; ?></td>
		<?php
	}
	if($r['tax_type'] == 1){
		$gstval=($r['tax_percentage']/2);
		$type='CGST '.$gstval.'%'."\n".'SGST '.$gstval.'%';
		
		?>
	<td style="text-align:center;"><?php echo $type ?></td>
		<?php
	}
	if($r['tax_type'] == 0){
		$type=0;
		
		?>
		<td style="text-align:center;"><?php echo $type ?></td>
	<?php
	}
	?>
	<td style="text-align:center;"><?php echo $r['netamt']; ?></td>
</tr>
<?php } 
	
	?>
<tr>
	<td colspan="7" style="text-align:right;padding-right:2px;">Total Amount</td>
	<td><?php echo $rg['invoiceamt']; ?></td>
</tr>


<tr>
	<td colspan="7" style="text-align:right;padding-right:2px;">Payment Mode</td>
	<td><?php echo $rg['invoicetype']; ?></td>
</tr>

</table>
<br/><br/>
<table style="width:150px; border-collapse: collapse;" border="1">
	<tr>
		<th>Tax (%)</th>
		<th>Tax Amount</th>
	</tr>
<?php 
include("config.php");
$query=mysqli_query($db,"select Distinct(tax_percentage), tax_type from `tbl_purchaseitems` where `invoiceno` = '$code'") or die(mysqli_query($db,));

while($result=mysqli_fetch_array($query)){
	$percentage = $result['tax_percentage'];
	$tax_type=$result['tax_type'];
	
	$query1 = mysqli_query($db,"select sum(tax_amount) as amount from `tbl_purchaseitems` where `invoiceno` = '$code' AND `tax_percentage`='$percentage' AND `tax_type`='$tax_type'") or die(mysqli_query($db,));
	
	$result1=mysqli_fetch_array($query1);
	$amt=$result1['amount'];
	if($result['tax_type'] == 2){
		$gstval=$result['tax_percentage'];
		$type='IGST '.$gstval.'%';
	}
	if($result['tax_type'] == 1){
		$gstval=($result['tax_percentage']/2);
		$type='CGST '.$gstval.'%'."\n".'SGST '.$gstval.'%';
	}
	echo "<tr><td>$type</td><td>$amt</td></tr>";
}
?>
</table>
</body>
</html>


<style>
@page { size: auto;  margin: 10mm 50mm;  }
</style>

<script type="text/javascript">

window.print();

</script>