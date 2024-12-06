<?php
	$id = $_REQUEST['id'];
 $storid=$_SESSION['storeid'];
	include('../config.php');
	
	$sql = mysql_query("SELECT distinct batchno FROM tbl_purchaseitems WHERE status = 1 AND productid = $id AND aval > 0 AND branch_id='$storid' ");
	$array = array();
	while($r = mysql_fetch_array($sql)){
		array_push($array, array("batch"=>$r['batchno']));
	}
	echo json_encode($array);
?>