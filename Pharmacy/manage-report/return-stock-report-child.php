<?php
	require_once("config.php");
	$invoice = $_REQUEST['invoice'];
	$sql= "select * from tbl_stock_transfer_item where id=$invoice";
	$array = array();
	$res = mysqli_query($db,$sql);
	// while($rs = mysqli_fetch_array($res)){
	// 		$array[] = array("invoice"=> $rs['id'],"batchno"=> $rs['batchno'], "expiry"=>$rs['expiry']);
	// }
	// $header="<tr><th>Invoice</th><th>batchno</th><th>expiry</th></tr>";
	// $row=json_encode($array);
	
?>
<table>
	<tr><th>Invoice</th><th>Batch #</th><th>Expiry</th><th>Product name</th><th>Quantity</th><th>User</th><th>Mrp</th><th>Pprice</th></tr>
<?php
	while($rs = mysqli_fetch_array($res)){ ?>
<td><?php echo $rs['id'] ?></td><td><?php echo $rs['batchno'] ?></td><td><?php echo $rs['expiry'] ?></td><td><?php echo $rs['product_name'] ?></td><td><?php echo $rs['qty'] ?></td><td><?php echo $rs['user'] ?></td><td><?php echo $rs['mrp'] ?></td><td><?php echo $rs['pprice'] ?></td>
	<?php } ?>

</table>