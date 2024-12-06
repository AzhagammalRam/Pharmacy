<?php
	$id = $_REQUEST['id'];
	include("../config.php");
	$sql = "SELECT * FROM tbl_productlist WHERE id = ".$id;
	$res = mysqli_query($db,$sql);
	$rs = mysqli_fetch_array($res);

	$manu = $rs['manufacturer'];
	$q = mysqli_query($db,"SELECT manufacturername FROM tbl_manufacturer WHERE  id= '$manu'");
	$r = mysqli_fetch_array($q);
	$manufacturer = $r['manufacturername'];

	$status = ($rs['status'] == 1) ? "<span class='label label-sm label-success arrowed-in arrowed-in-right'>Active</span>" : "<span class='label label-sm label-arrowed arrowed-in arrowed-in-right'>Inactive</span>";
	
	$array = array("id"=>$rs['id'],"manuf"=>$manufacturer, "product"=>$rs['productname'], "generic"=>$rs['genericname'], "schedule"=>$rs['scheduletype'], "ptype"=>$rs['producttype'], "unitd"=>$rs['unitdesc'], "stype"=>$rs['stocktype'], "ptax"=>$rs['purchasetax'], "stax"=>$rs['salestax'], "mrp"=>$rs['mrp'], "price"=>$rs['unitprice'], "minqty"=>$rs['minqty'], "maxqty"=>$rs['maxqty'], "shelf"=>$rs['shelf'], "rack"=>$rs['rack'],"hsncode"=>$rs['hsncode'],"claim_type"=>$rs['claimtype'],"status"=>$status);
	
	print json_encode($array);
?>