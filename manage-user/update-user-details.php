<?php
	include("../config.php");
	
	$id = $_REQUEST['id'];
	$username = $_REQUEST['username'];
	$userid = $_REQUEST['userid'];
	$pass = $_REQUEST['pass'];
	$role = $_REQUEST['role'];
	$store = $_REQUEST['store'];
	$opt1 = $_REQUEST['opt1'];
	$opt2 = $_REQUEST['opt2'];
	$opt3 = $_REQUEST['opt3'];
	$opt4 = $_REQUEST['opt4'];
	$opt5 = $_REQUEST['opt5'];
	$opt6 = $_REQUEST['opt6'];
	$opt7 = $_REQUEST['opt7'];
	$opt8 = $_REQUEST['opt8'];
	$opt9 = $_REQUEST['opt9'];
	$opt10 = $_REQUEST['opt10'];
	$opt11 = $_REQUEST['opt11'];
	$opt12 = $_REQUEST['opt12'];
	$opt13 = $_REQUEST['opt13'];
	$opt14 = $_REQUEST['opt14'];
	$opt15 = $_REQUEST['opt15'];
	$opt16 = $_REQUEST['opt16'];
	$opt17 = $_REQUEST['opt17'];
	$opt19 = $_REQUEST['opt19'];
	$opt20 = $_REQUEST['opt20'];
	$opt21 = $_REQUEST['opt21'];
	$opt22 = $_REQUEST['opt22'];
	$opt23 = $_REQUEST['opt23'];
	$opt24 = $_REQUEST['opt24'];
	$opt25 = $_REQUEST['opt25'];
	$opt26 = $_REQUEST['opt26'];
	$opt27 = $_REQUEST['opt27'];
	$opt28 = $_REQUEST['opt28'];
	$opt29 = $_REQUEST['opt29'];
	$opt30 = $_REQUEST['opt30'];
	$opt31 = $_REQUEST['opt31'];
	$opt32 = $_REQUEST['opt32'];	
	$opt33 = $_REQUEST['opt33'];
	$opt34 = $_REQUEST['opt34'];
	$cmd = "";
	 $sql = "UPDATE tbl_users SET username = '$username', userid = '$userid', role = '$role', mp = '$opt1', mm = '$opt2', ms = '$opt3', mu = '$opt4', mst = '$opt22', md = '$opt23', pfrep = '$opt24', iprep = '$opt25', sc = '$opt20', cc = '$opt21', purretrep ='$opt26',storep ='$opt27',  bill = '$opt5',sr = '$opt6', pe = '$opt7', pr = '$opt8', sa = '$opt9', ise = '$opt10', stka = '$opt11', srep = '$opt12', prep = '$opt13', doc = '$opt14', vat = '$opt15', sch = '$opt16', exrep= '$opt17', sttra= '$opt19', dreturn= '$opt28', preturot= '$opt29' , storeid='$store' ,dgrep = '$opt30',`dispose_report`='$opt31',`ustock`='$opt32',`clearstock`='$opt33', `cmrep` = '$opt34' WHERE id = $id";
	if($pass != ""){
		$cmd = ", password = '$pass'";
		$sql = "UPDATE tbl_users SET username = '$username', userid = '$userid', mp = '$opt1', mm = '$opt2', ms = '$opt3', mu = '$opt4', mst = '$opt22', md = '$opt23', sc = '$opt20', cc = '$opt21', pfrep = '$opt24', iprep = '$opt25',  purretrep ='$opt26',storep ='$opt27', bill = '$opt5', sr = '$opt6', pe = '$opt7',	pr = '$opt8', sa = '$opt9',	ise = '$opt10',	stka = '$opt11', srep = '$opt12', prep = '$opt13', doc = '$opt14', vat = '$opt15', sch = '$opt16', sttra= '$opt19', dreturn= '$opt28', preturot= '$opt29' , exrep= '$opt17', storeid='$store',dgrep = '$opt30',`dispose_report`='$opt31',`ustock`='$opt32',`clearstock`='$opt33', `cmrep` = '$opt34', role = '$role' ".$cmd." WHERE id = $id";
	}
	if (!empty($_FILES["photo"]["name"])) {
		$fileTempName = $_FILES['photo']['tmp_name'];
		$imgData =addslashes(file_get_contents($_FILES['photo']['tmp_name']));
		$cmd = ", image = '{$imgData}'";
		$sql = "UPDATE tbl_users SET username = '$username', userid = '$userid', mp = '$opt1', mm = '$opt2', ms = '$opt3', mu = '$opt4', mst = '$opt22', md = '$opt23', sc = '$opt20', cc = '$opt21', pfrep = '$opt24', iprep = '$opt25',  purretrep ='$opt26',storep ='$opt27', bill = '$opt5', sr = '$opt6', pe = '$opt7',	pr = '$opt8', sa = '$opt9',	ise = '$opt10',	stka = '$opt11', srep = '$opt12', prep = '$opt13', doc = '$opt14', vat = '$opt15', sch = '$opt16',sttra= '$opt19',dreturn= '$opt28',preturot= '$opt29',exrep= '$opt17',dgrep = '$opt30',`dispose_report`='$opt31',`ustock`='$opt32',`clearstock`='$opt33', `cmrep` = '$opt34',`role` = '$role' ".$cmd." WHERE id = $id";
	}
	
	if(mysqli_query($db,$sql))
		echo 'User Information Updated!';
	else
		echo mysqli_error($db);
?>