<?php
	$id = $_REQUEST['id'];
	include("../config.php");
	$sql = "SELECT * FROM tbl_currency WHERE id = ".$id;
	$res = mysql_query($sql);
	$rs = mysql_fetch_array($res);
	$status = ($rs['status'] == 1) ? "<span class='label label-sm label-success arrowed-in arrowed-in-right'>Active</span>" : "<span class='label label-sm label-arrowed arrowed-in arrowed-in-right'>Expired</span>";

	$array = array("id"=>$rs['id'],"currency"=>$rs['currency'],"base_currency"=>$rs['base_currency'], "status"=>$status);
	
	print json_encode($array);
?>