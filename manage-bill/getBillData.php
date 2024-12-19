<?php
	
    require_once("../config.php");

  if (isset($_REQUEST['opt'])) {

    $opt = $_REQUEST['opt'];

      $result = mysqli_query($db, "SELECT * FROM tbl_billing WHERE billno = '$opt' OR phno = '$opt' OR patientname = '$opt'");

      $row['res_arr'] = mysqli_fetch_all($result,MYSQLI_ASSOC);
      echo json_encode($row);
}      
  else {
      echo "error";
  }
  ?>