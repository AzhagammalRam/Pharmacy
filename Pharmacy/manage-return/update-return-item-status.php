<?php
	session_start();
	include("../config.php");
$id=$_REQUEST['id'];
$data=$_REQUEST['data'];


$query=mysqli_query($db,"UPDATE tbl_purchase_return SET status = '1' where id = $id");

$gamount=mysqli_query($db,"SELECT * from tbl_purchase_return where id = $id");
$res=mysqli_fetch_array($gamount);
$amount=$res['totalamount'];
$supplierid=$res['supplierid'];
$query1=mysqli_query($db,"UPDATE tbl_purchase_return_items SET status = '1' where purchase_return_id = $id");

$query2 = mysqli_query($db,"UPDATE tbl_supplier SET credit = credit+ '$amount' WHERE id= '$supplierid'") or  die(mysqli_error($db));

for($i=0;$i<count($data);$i++){

$qty=$data[$i]['qty'];
$purchaseid=$data[$i]['purchaseid'];
$query3 = mysqli_query($db,"UPDATE tbl_purchaseitems SET aval = aval-$qty WHERE id= '$purchaseid'") or  die(mysqli_error($db));
}


echo $id;

?>