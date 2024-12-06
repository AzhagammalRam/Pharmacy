<?php
require_once("config.php");
	$echeck="select * from tbl_purchase where invoiceno =(".$_POST['invoiceno'].") AND supplierid =(".$_POST['supplierid'].")";
   $echk=mysqli_query($db,$echeck);
   $ecount=mysqli_num_rows($echk);
   // echo $echeck;
  if($ecount!=0)
   {
      echo "Sucess";
   }else{
      echo"failure";
   }
   
  
?>