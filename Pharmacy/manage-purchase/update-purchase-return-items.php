<?php
	session_start();
	$data = $_REQUEST['data'];
	include("../config.php");

$amount=0;
for($i=0;$i<count($data);$i++)
{

$amount+=$data[$i]['price'] * $data[$i]['qty'];	
}
for($i=0;$i<count($data);$i++)
{
	include("../config.php");
	$price=$data[$i]['price'];
	$pname=$data[$i]['pname'];
	$invoice=$data[$i]['invoice'];
	
	$qty=$data[$i]['qty'];
	$reason=$data[$i]['reason'];
	$supplierid=$data[$i]['supplierid'];
	$pid=$data[$i]['pid'];

	$q=("SELECT * from tbl_supplier where id=$supplierid");
	$sn1=mysqli_query($db,$q);
	$sn=mysqli_fetch_array($sn1);
	$suppliername=$sn['suppliername'];

	$query=mysqli_query($db,"SELECT * from tbl_productlist where productname = '$pname' ");
	$res=mysqli_fetch_array($query);
	$prod_id=$res['id'];

if ($i==0)
{

  $query = mysqli_query($db,"SELECT id FROM `tbl_purchase_return` ORDER BY id DESC LIMIT 1"); 


  while ($row = mysqli_fetch_object($query)) {
    $lastId =  $row->id;
  }


  $Id = ($lastId + 1);
  $return_invoice = 're-'.$Id;

  

	$query1 = mysqli_query($db,"INSERT INTO tbl_purchase_return (invoiceno,  supplierid, datentime, totalamount, return_invoice) VALUES ( '$invoice', '$supplierid', CURRENT_TIMESTAMP, '$amount', '$return_invoice')") or  die(mysqli_error($db));
	$lastid=mysqli_insert_id($db);
}

	$query2 = mysqli_query($db,"INSERT INTO tbl_purchase_return_items (purchase_return_id,  productid, qty, reason, price, datentime) VALUES ('$lastid', '$prod_id', '$qty','$reason', '$price', CURRENT_TIMESTAMP)") or  die(mysqli_error($db));

	$query3 = mysqli_query($db,"UPDATE tbl_supplier SET credit = credit+ '$amount' WHERE id= '$supplierid'") or  die(mysqli_error($db));

	$query4 = mysqli_query($db,"UPDATE tbl_purchaseitems SET aval = aval-$qty WHERE id= '$pid'") or  die(mysqli_error($db));
}
$array[] = array("return_invoice"=>$return_invoice,"lastid"=>$lastid);
echo json_encode($array);

?>