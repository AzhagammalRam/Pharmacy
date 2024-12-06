<?php
	
	require_once('../config.php');
	$prod = urldecode($_REQUEST['prod']);
	$prod = mysqli_escape_string($db,$prod);
	$batch = $_REQUEST['batch'];
	 $storid=$_SESSION['storeid'];
	
	$cmd = mysqli_query($db,"SELECT id FROM tbl_productlist WHERE productname = '$prod'");
	$rs = mysqli_fetch_array($cmd);
	if($rs['id']){
		$id = $rs['id'];
		
		$sql = mysqli_query($db,"SELECT sum(aval) as aval FROM tbl_purchaseitems WHERE status = 1 AND productid = $id AND batchno = '$batch' AND branch_id='$storid' AND aval > 0");
		
		/*$array = array();
		while($r = mysqli_fetch_array($sql)){
			
			$aval = $r['aval'];
			
			array_push($array, array("aval"=>$aval));
		}*/
		 $r=mysqli_fetch_array($sql);
		echo $r['aval'];
	}else{
		echo "error1";
	}
	
?>