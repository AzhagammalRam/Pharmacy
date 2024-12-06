<?php
	include("../config.php");
	$sql = "SELECT distinct stocktype FROM tbl_productlist";
	$res = mysql_query($sql);
	$data = array();
	while($rs = mysql_fetch_array($res)){
		$x = array('stocktype'=>$rs['stocktype']);
		array_push($data, $x);
	}
	echo json_encode($data);
?>