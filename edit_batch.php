<?php
	include("config.php");
	 $id = $_REQUEST['id'];
	 $bat_purid = $_REQUEST['bat_purid'];
	 $puritm = $_REQUEST['oldpur_itm'];
	 $code = $_REQUEST['code'];
	 $puritm = split('-', $puritm);
     $puritm_id = $puritm[0];

     $format = 'Y/m/d '; 
	$d = date ( $format, strtotime ( '+90 days' ) );
	$x = date ( $format);

	$bat = mysqli_fetch_array(mysqli_query($db,"select * from tbl_purchaseitems where id = '$bat_purid' and productid = '$code' "));
	  $b_no = $bat['batchno'];
	 	$bat_pitm_id    = $bat['id'];
	 	$exp = $bat['expirydate'];

	 	
	 	$rs = mysqli_fetch_array(mysqli_query($db,"select * from tbl_billing_items where id = '$id' "));
	 $pid = split('-', $rs['purchaseid']);
	 $pid = $pid[0];
	 $q_ty = $rs['qty'];
	 $sql3  = mysqli_query($db,"update tbl_purchaseitems set aval = (aval + $q_ty) where id = $pid ");
	 $purid_qty = $bat_pitm_id.'-'.$q_ty;
	
	$sql="update tbl_billing_items set batchno='$b_no',purchaseid = '$purid_qty', expirydate = '$exp' where id='$id' and del_status != 1";
	mysqli_query($db,$sql);
	
	 $sql2="select distinct(b.supplierid) as supid,c.suppliername,a.id,a.expirydate,a.aval from tbl_purchaseitems a join tbl_purchase b on a.purchaseid= b.purchaseid join tbl_supplier c on b.supplierid = c.id  where a.batchno = '$b_no' and a.productid = '$code'  and a.aval > 0 order by a.expirydate ";
	 $result2=mysqli_query($db,$sql2);
	 $res2=mysqli_fetch_array($result2);
	 echo $expiry = $res2['expirydate'].'~~';
	?>
	
	<select >

<?php

	  $sql1="select distinct(b.supplierid) as supid,c.suppliername,a.id,a.expirydate,a.aval from tbl_purchaseitems a join tbl_purchase b on a.purchaseid= b.purchaseid join tbl_supplier c on b.supplierid = c.id  where a.batchno = '$b_no' and a.productid = '$code'  and a.aval > 0 AND a.expirydate >= '$x' order by a.expirydate ";
	 $result1=mysqli_query($db,$sql1);
	
	 while($row=mysqli_fetch_array($result1))
	 {
	 $supid=$row['supid'];
	 $suppliername = $row['suppliername'];
	
	?>
	 <option value="<?php echo $supid; ?>" ><?php echo $suppliername; ?></option>
	 <?php }
     $sql4  = mysqli_query($db,"update tbl_purchaseitems set aval = (aval - $q_ty) where id = $bat_pitm_id ");	 ?>
</select>
	
		