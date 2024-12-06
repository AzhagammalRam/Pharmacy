<?php 
include('config.php');
$currency=$_REQUEST['currency'];

$base_currency_query=mysqli_query($db,"SELECT * from `tbl_currency` where `base_currency`='1' and `status` = 1");
$base_currency_res=mysqli_fetch_array($base_currency_query);
$base_currency=$base_currency_res['id'];

$exchange_rate_query=mysqli_query($db,"SELECT * FROM `tbl_currency_exchange` WHERE `base_currency`='$base_currency' AND `exchange_currency`='$currency' AND  `status`=1");
$exchange_rate_res=mysqli_fetch_array($exchange_rate_query);
$exchange_rate=$exchange_rate_res['exchange_rate'];
$id=$exchange_rate_res['id'];

$result=array('id'=>$id,'exchange_rate'=>$exchange_rate);
echo json_encode($result);
?>