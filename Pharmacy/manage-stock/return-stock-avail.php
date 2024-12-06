<?php
	require_once("../config.php");
	$format = 'Y/m/d '; 
	$d = date ( $format, strtotime ( '+90 days' ) );
	$x = date ( $format);
	$sql = "SELECT I.productid, L.productname,L.genericname, L.stocktype, I.batchno, I.expirydate, I.mrp, L.shelf, L.rack, L.manufacturer, I.pprice,M.manufacturername, S.suppliername, K.name, sum(I.aval) 
	 FROM tbl_purchaseitems I JOIN tbl_productlist L ON I.productid = L.id 
	 JOIN tbl_manufacturer M ON M.id = L.manufacturer 
	 JOIN tbl_purchase P on P.purchaseid= I.purchaseid 
	 JOIN tbl_supplier S on S.id= P.supplierid JOIN branch K on K.id= I.branch_id 
	 WHERE I.aval!=0 and I.expirydate!=0000-00-00 and I.expirydate >= '$x' GROUP BY I.productid, I.batchno, I.expirydate, I.mrp, L.productname, L.stocktype";

	$res = mysqli_query($db,$sql);
	$i = 1;
	$data = array();
	while($rs = mysqli_fetch_array($res)){
	$id = $rs['id'];
	$ee = $rs['expirydate'];
	$quantity=$rs['sum(I.aval)'];
	$expirydate = implode("/",array_reverse(explode("-",$rs['expirydate'])));
	$expirydate = substr($expirydate,3);
	$start_date = date('Y-m-d');
	$end_date = date('Y-m-d', strtotime("+60 days"));
	if(strtotime($ee) <= strtotime($end_date))
	$alert = 1;
	else
	$alert = 0;
    $x = array('#'=>$i++,
	'type'=>$rs['stocktype'], 
	'product'=>$rs['productname'],
	'generic'=>$rs['genericname'], 
	'batch'=>$rs['batchno'],
	'supplier'=>$rs['suppliername'],
	'pharma'=>$rs['manufacturername'],  
	'expiry'=>$expirydate, 
	'avail'=>round($quantity), 
	'shelf'=>$rs['shelf'], 
	'rack'=>$rs['rack'],
	'mrp'=>$rs['mrp'],
	'cost'=>$rs['pprice'],
	'branch'=>$rs['name'],
	'alrt'=>$alert);
	array_push($data, $x);
	}
	$results = array(
	"sEcho" => 1,
	"iTotalRecords" => count($data),
	"iTotalDisplayRecords" => count($data),
	"aaData"=>$data);
	echo json_encode($results);
?>