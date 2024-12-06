<?php
	require_once("../config.php");
	
	$branch = $_REQUEST['branch'];				$branch = mysqli_escape_string($db,$branch);
	$status = $_REQUEST['status'];		$status = mysqli_escape_string($db,$status);
	
	
	$cmd_name_exist = mysqli_query($db,"SELECT `name` FROM `branch` WHERE name='$branch' LIMIT 1");
			if(mysqli_num_rows($cmd_name_exist) !=0){
				echo 'Branch name Already Exist';
				mysqli_close($db);
				exit;
		    	}

	$sql = "INSERT INTO branch (id,name, status) VALUES (NULL, '$branch', '$status')";
	if(mysqli_query($db,$sql))
		echo 'New Store Added!';
	else
		echo mysqli_error($db);
?>
 
