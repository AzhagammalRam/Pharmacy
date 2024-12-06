<?php
  include("../config.php");
  $fromdate = $_REQUEST['fromdate'];
  $fromto = $_REQUEST['fromto'];
  // $paymentmode = $_REQUEST['paymentmode'];
  $billtype = $_REQUEST['billtype'];
  
  $d1 = $fromdate;
  if($fromto == "") $d2 = $d1;
  $d2 = $fromto;
  
  $array = array();
  $sql = mysql_query("SELECT * FROM stockwastage WHERE status=0 and (datentime BETWEEN '$d1' AND '$d2') and `dispose_status`=0");
  $result='';
  while($rs = mysql_fetch_array($sql)){
    $product = $rs['product_name'];
    $qty = $rs['qty'];
    $batch = $rs['batch'];
    $expiry= $rs['expiry'];
    array_push($array, array('product'=> $product, 'qty' => $qty,'batch' => $batch,'expiry' => $expiry) );
  }
  // $array[] = array("total"=> number_format($total,2,".",""));
  echo json_encode($array);
?>