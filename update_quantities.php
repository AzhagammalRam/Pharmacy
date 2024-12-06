<?php
	include("config.php");
	 $id = $_REQUEST['id'];
	 $qty = $_REQUEST['qty'];
	 $total = $_REQUEST['amount'];
	 $code = $_REQUEST['code'];
     $returnqty = $_REQUEST['returnQty'];
     $billno = $_REQUEST['billno'];

	 
	 $sql="update tbl_billing_items set qty='$qty',returnqty='$returnqty', amount='$total' where id='$id' AND code='$code' and del_status != 1";
	if(mysqli_query($db,$sql)){
        echo "Success";
    }
	?>
	