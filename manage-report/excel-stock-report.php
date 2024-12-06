<?php
	include("../config.php");
	$storid=$_SESSION['storeid'];
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=stock_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
	$header = array("Product Type","Product Name","Batch","Supplier","Pharma","Expiry","Unit Desc","Availability", "Shelf","Rack","Cost","MRP","Store");
			echo implode("\t",$header). "\r\n";
// $sql = mysqli_query($db,"SELECT * FROM `tbl_productlist` ORDER BY `productname` asc");
// while($res = mysqli_fetch_array($sql)){
//    $id = $res['id'];
// 	 if ($storid==1)
//  		{
// 		$q = mysqli_query($db,"SELECT `productid`, `batchno`, `purchaseid`,`expirydate`, sum(aval) as `avail`, `pprice`, `mrp`,`branch_id` FROM `tbl_purchaseitems` WHERE `productid` = '$id'  AND  `status` = 1");
// 	 	}
// 	 else 
// 	 	{
// 		$q = mysqli_query($db,"SELECT `productid`, `batchno`, `purchaseid`,`expirydate`, sum(aval) as `avail`, `pprice`, `mrp`, `branch_id` FROM `tbl_purchaseitems` WHERE `productid` = '$id'  AND  `status` = 1 AND `branch_id`= '$storid'");
// 		 }
 $sql = "SELECT I.productid,L.unitdesc, L.productname,L.genericname, L.stocktype, I.batchno, I.expirydate, I.mrp, L.shelf, L.rack, L.manufacturer, I.pprice,M.manufacturername, S.suppliername, K.name, sum(I.aval) 
	 FROM tbl_purchaseitems I JOIN tbl_productlist L ON I.productid = L.id 
	 JOIN tbl_manufacturer M ON M.id = L.manufacturer 
	 JOIN tbl_purchase P on P.purchaseid= I.purchaseid 
	 JOIN tbl_supplier S on S.id= P.supplierid JOIN branch K on K.id= I.branch_id 
	 WHERE I.aval!=0 and I.expirydate!=0000-00-00 GROUP BY I.productid, I.batchno, I.expirydate, I.mrp, L.productname, L.stocktype";
	$res = mysqli_query($db,$sql);
	while($rs = mysqli_fetch_array($res)){
			// $productid= $rs['id'];
		$quantity=$rs['sum(I.aval)'];
// $purchaseid = $rs['purchaseid'];
// $productid=$rs['productid'];
// $se = mysqli_query($db,"SELECT `supplierid` FROM `tbl_purchase` WHERE `purchaseid` = '$purchaseid'");
// $re = mysqli_fetch_array($se);
// $sup = $re['supplierid'];
// $s = mysqli_query($db,"SELECT * FROM `tbl_supplier` WHERE id = '$sup'");
// $r = mysqli_fetch_array($s);
// $ser = mysqli_query($db,"SELECT `stocktype`,`productname`,`manufacturer`,`shelf`,`rack`,`unitdesc` FROM `tbl_productlist` WHERE `id`= '$productid'");
// $ref = mysqli_fetch_array($ser);
// $mid=$ref['manufacturer'];
// $pname=$ref['productname'];
// $mname=mysqli_query($db,'select * from tbl_manufacturer where id='.$mid);
// while($gmname=mysqli_fetch_array($mname)){
// $pharma=$gmname['manufacturername'];
echo $rs['stocktype'] . "\t" .$rs['productname'] . "\t" . $rs['batchno'] . "\t" . $rs['suppliername'] . "\t"  . $rs['manufacturername'] .  "\t" . $rs['expirydate']. "\t" . $rs['unitdesc'] . "\t" . $quantity . "\t" . $rs['shelf'] . "\t" .$rs['rack'] . "\t" . $rs['pprice'] . "\t" . $rs['mrp'] . "\t" . $storid . "\t". "\r\n";
			}
		// }
	// }
?>