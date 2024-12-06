<?php
session_start();
require_once("../config.php");
$quantity = $_REQUEST['quantity'];				
$expiry = $_REQUEST['expiry'];
$batch = $_REQUEST['batch'];
$prod = $_REQUEST['prod'];
$reason = $_REQUEST['reason'];
$username = $_SESSION['phar-username'];
$created_date=date('Y-m-d H:i:s');	
	$result='';

	include("../config.php");
	$cmd = mysql_query("SELECT * FROM tbl_productlist WHERE productname = '$prod'");
	// echo "SELECT * FROM tbl_productlist WHERE productname = '$prod'";
	$rs = mysql_fetch_array($cmd);
	$code = $rs['id'];
	$sqlr = mysql_query("SELECT * FROM tbl_purchaseitems WHERE status = 1 AND productid = '$code' AND batchno = '$batch' AND expirydate = '$expiry' AND branch_id='1' order by productid asc limit 1");
	// echo "SELECT * FROM tbl_purchaseitems WHERE status = 1 AND productid = '$code' AND batchno = '$batch' AND expirydate = '$expiry' AND branch_id='1' order by productid asc limit 1";
		$res = mysql_fetch_array($sqlr);
		$pid = $res['id'];

		 $cmde = "UPDATE tbl_purchaseitems SET aval = aval - $quantity WHERE id = $pid";
			mysql_query($cmde);

	 $sql = "INSERT INTO stockwastage (`id`,`product_name`,`batch`,`expiry`,`qty`,`reason`,`datentime`,`created_by`,`status`) VALUES (NULL, '$prod','$batch','$expiry', '$quantity', '$reason','$created_date', '$username', '1')";
	
 mysql_query($sql) or die("Unable to create bill");
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