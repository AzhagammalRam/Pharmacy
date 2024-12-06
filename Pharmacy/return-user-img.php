<?php 
	$id = $_REQUEST['id'];
	require_once("config.php");
	$sql = "select image from tbl_users where id=".$id;
	$result = mysqli_query($db,$sql) or die("Invalid query: " . mysqli_error($db));
	header("Content-type: image/png");
	$row = mysqli_fetch_array($result);
	$image = $row['image'];
	if($image != ''){
		echo $image;
	} else{
		$sql = "select image from tmpimage where id=1";
		$result = mysqli_query($db,$sql) or die("Invalid query: " . mysqli_error($db));
		$row = mysqli_fetch_array($result);
		$image = $row['image'];
		echo $image;
	}
	// if(mysqli_result($result, 0))
	// 	echo mysqli_result($result, 0);
	// else{
	// 	$sql = "select image from tmpimage where id=1";
	// 	$result = mysqli_query($db,$sql) or die("Invalid query: " . mysqli_error($db));
	// 	echo mysqli_result($result, 0);
	// }
	mysqli_close($db);
?>