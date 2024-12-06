<?php
	$id = $_REQUEST['id'];
    $opt = $_REQUEST['opt'];
	include("../config.php");

    if($opt == 'stc'){
        $sql = "UPDATE tbl_purchaseitems SET dbstcstatus =1 WHERE id = ".$id;
    } else if($opt == 'exp'){
        $sql = "UPDATE tbl_purchaseitems SET dbexpstatus =1 WHERE id = ".$id;
    }

	// $sql = "DELETE FROM tbl_productlist WHERE id = ".$id;
	if(mysqli_query($db,$sql))
		echo 'ok';
	else
		echo mysqli_error($db);
?>