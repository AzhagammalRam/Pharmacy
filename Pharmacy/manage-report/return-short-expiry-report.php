<?php
	include("../config.php");
	$fromdate = $_REQUEST['fromdate'];
	$dtto = $_REQUEST['fromto'];
	$product = $_REQUEST['product'];
	$Supplier = $_REQUEST['supplier'];
	$d1 = $fromdate;
	$d1 = date("Y-m", strtotime($d1));
	$d2 = $dtto;
	$d2 = date("Y-m", strtotime($d2));
	if($dtto == "")	$d2 = $d1;
	
	if($product != ""){
		$cmd="SELECT * FROM `tbl_productlist` WHERE productname = '$product'";
		$result = mysqli_query($db,$cmd);
		$row = mysqli_fetch_array($result);
		$pr_id=$row['id'];
		}
		if($Supplier){
		$cmd1="SELECT * FROM `tbl_supplier` WHERE suppliername = '$Supplier'";
		$result1 = mysqli_query($db,$cmd1);
		$row1 = mysqli_fetch_array($result1);
		$sp_id=$row1['id'];
		}

	$sql = "select * from tbl_purchaseitems where DATE_FORMAT(expirydate,'%Y-%m') BETWEEN '$d1' and '$d2' ";
	if($product != '')
		{
			$sql .= "AND productid = $pr_id ";
		}
		$sql .="ORDER BY expirydate";
	$result = mysqli_query($db,$sql);
	$res = mysqli_fetch_array($result);
	
	while($res = mysqli_fetch_array($result)){
		
		$sql1 = "SELECT * from tbl_purchase where purchaseid = ".$res['purchaseid'];
		if($Supplier != ""){
			$sql1 .= " AND supplierid = '$sp_id'";	
		}
		$result1 = mysqli_query($db,$sql1);
		while($res1 = mysqli_fetch_array($result1)){
			$sql2="select * from tbl_productlist where id = ".$res['productid'];;
			$result2 = mysqli_query($db,$sql2);
			$res2= mysqli_fetch_array($result2);
			$sql3="select * from tbl_supplier where id = ".$res1['supplierid'];
			$result3 = mysqli_query($db,$sql3);
			$res3= mysqli_fetch_array($result3);
			
			$originalDate = $res['expirydate'];
$newDate = date("Y-m", strtotime($originalDate));
			
			$array[] = array("stocktype" => $res2['stocktype'],"productname" => $res2['productname'], "batchno" => $res['batchno'],"supplier" => $res3['suppliername'],"expirydate" => $newDate, "aval" => $res['aval'],"shelf" => $res2['shelf'],"rack" => $res2['rack'], "mrp" => $res['mrp']);
			}
		}
		echo json_encode($array);
?>