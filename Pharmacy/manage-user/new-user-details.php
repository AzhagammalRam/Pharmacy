<?php
	include("../config.php");
	
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
	$opt18 = $_REQUEST['opt18'];
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

	if (!empty($_FILES["photo"]["name"])) {
		$fileTempName = $_FILES['photo']['tmp_name'];
		$imgData = addslashes(file_get_contents($_FILES['photo']['tmp_name']));
	}else
		$imgData = "";
		
 $sql = "INSERT INTO tbl_users (id, username, userid, password, role, image, mp, mm, ms , mst, md, pfrep,iprep, sc, cc,purretrep,storep, mu, bill,dreturn, sr, pe, pr, sa, ise, stka, srep, prep, doc, vat, sch,sttra,exrep, status,storeid,preturot,dgrep,dispose_report,ustock,clearstock,cmrep) VALUES (NULL, '$username', '$userid', '$pass', '$role', '{$imgData}', '$opt1', '$opt2', '$opt3', '$opt22' ,'$opt23' ,'$opt24','$opt25' , '$opt20' ,'$opt21' ,'$opt26' ,'$opt27' , '$opt4', '$opt28', '$opt5', '$opt6', '$opt7', '$opt8', '$opt9', '$opt10', '$opt11', '$opt12', '$opt13','$opt14', '$opt15', '$opt16','$opt19','$opt18','1','$store','$opt29','$opt30','$opt31','$opt32','$opt33','$opt34');";
	if(mysqli_query($db,$sql))
		echo 'New User Added!';
		//echo $sql;	
	else
		echo 'Username already exists';
?>
 
