<?php
	$id = $_REQUEST['id'];
	// require_once("../config.php");
	include("../config.php");
	$se = mysql_query("SELECT * FROM stockwastage WHERE status =1 and `id`='$id'");
	$re = mysql_fetch_array($se);
	$productnames=$re['product_name'];
	$batch_stock=$re['batch'];
	$expiry_date=$re['expiry'];
	$quantity=$re['qty'];

	$cmd = mysql_query("SELECT * FROM tbl_productlist WHERE productname = '$productnames'");
	// echo "SELECT * FROM tbl_productlist WHERE productname = '$productnames'";
	$rs = mysql_fetch_array($cmd);
	$code = $rs['id'];
	$sqlr = mysql_query("SELECT * FROM tbl_purchaseitems WHERE status = 1 AND productid = '$code' AND batchno = '$batch_stock' AND expirydate = '$expiry_date' AND branch_id='1' order by productid asc limit 1");
	// echo "SELECT * FROM tbl_purchaseitems WHERE status = 1 AND productid = '$code' AND batchno = '$batch_stock' AND expirydate = '$expiry_date' AND branch_id='1' order by productid asc limit 1";
		$res = mysql_fetch_array($sqlr);
		$pid = $res['id'];
	$cmde = "UPDATE tbl_purchaseitems SET aval = aval + $quantity WHERE `id` = $pid";
			mysql_query($cmde);
	
	$sql = "UPDATE stockwastage SET status=3 WHERE `id`='$id' AND `status` = 1";
	if(mysql_query($sql))

	$s = mysql_query("SELECT * FROM stockwastage WHERE status =1");
	while($r = mysql_fetch_array($s)){
	$qty=$r['qty'];
	$id=$r['id'];
	$product_name=$r['product_name'];
	$batchs=$r['batch'];
	$expirydate=$r['expiry'];

		

$result.= "<tr> <td>".$r['product_name']."</td>
				<td>".$r['batch']."</td>
				<td>". $r['expiry']."</td>
				<td>".$r['qty']."</td>
				<td><a onclick='deleteclearance($id)' style='text-decoration:none;cursor:pointer;'>Delete</a></td></tr>";
	}
	echo $result;
?>