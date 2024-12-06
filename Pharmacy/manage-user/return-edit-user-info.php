<?php
	$id = $_REQUEST['id'];
	include("../config.php");
	$sql = "SELECT * FROM tbl_users WHERE id = ".$id;
	$res = mysqli_query($db,$sql);
	$rs = mysqli_fetch_array($res);
	$role = $rs['role'];
	$status = $rs['status'];
	$store = $rs['storeid'];
  echo $rs['username'] . '~' . $rs['userid'] . '~' . $role . '~' . $status .  '~' . $rs['id'] . '~' . $rs['mp'] . '~' .	$rs['mm'] . '~' .	$rs['ms'] . '~' .	$rs['mu'] . '~' .	$rs['bill'] . '~' .	$rs['sr'] . '~' .	$rs['pe'] . '~' .	$rs['pr'] . '~' .	$rs['sa'] . '~' .	$rs['ise'] . '~' .	$rs['stka'] . '~' .	$rs['srep'] . '~' .	$rs['prep'] . '~' .	$rs['doc']. '~' .	$rs['vat']. '~' .	$rs['sch'] . '~' . $rs['exrep']. '~' . $rs['sc'] . '~' . $rs['cc']. '~' . $rs['mst']. '~' . $rs['md']. '~' . $rs['pfrep']. '~' . $rs['iprep']. '~' . $rs['purretrep']. '~' . $rs['storep']. '~' . $rs['sttra']. '~' . $rs['dreturn']. '~' . $rs['preturot']. '~' . $rs['password'].'~' . $store. '~' . $rs['dgrep']. '~' . $rs['dispose_report'].'~' . $rs['ustock']. '~' . $rs['clearstock']. '~' . $rs['cmrep'];
?>