<?php
	include('../config.php');
	if(isset($_REQUEST['editbatch']))
	{
		$prod = urldecode($_REQUEST['prod']);
	$prod = mysqli_escape_string($db,$prod);
	$aval = 0;
	$id = $_REQUEST['batch'];
					$sql = mysqli_query($db,"SELECT  aval FROM tbl_purchaseitems WHERE id = $id ");
		$r = mysqli_fetch_array($sql);
		echo $aval = $r['aval'];
			
	}
	else{
		$prod = urldecode($_REQUEST['prod']);
	$prod = mysqli_escape_string($db,$prod);
	$batch = $_REQUEST['batch'];
	 $storid=$_SESSION['storeid'];
	
	$cmd = mysqli_query($db,"SELECT id FROM tbl_productlist WHERE productname = '$prod'");
	$rs = mysqli_fetch_array($cmd);
	if($rs['id']){
		$id = $rs['id'];
		$sql = mysqli_query($db,"SELECT distinct aval FROM tbl_purchaseitems WHERE status = 1 AND productid = $id AND batchno = '$batch' AND branch_id='$storid' ");
		$array = array();
		while($r = mysqli_fetch_array($sql)){
			
			$aval = $r['aval'];
			
			array_push($array, array("aval"=>$aval));
		}
		echo json_encode($array);
	}else{
		echo "error1";
	}
	}
	
?>