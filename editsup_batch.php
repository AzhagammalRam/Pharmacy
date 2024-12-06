<?php
	include("config.php");
	 $id = $_REQUEST['id'];
	 $sup_id = $_REQUEST['sup_id'];
	 $code = $_REQUEST['code'];
	 $format = 'Y/m/d '; 
	$d = date ( $format, strtotime ( '+90 days' ) );
	$x = date ( $format);

	$rs = mysqli_fetch_array(mysqli_query($db,"select * from tbl_billing_items where id = '$id' "));
	 $pid = split('-', $rs['purchaseid']);
	 $pid = $pid[0];
	 $q_ty = $rs['qty'];
 
    $sql1="select a.batchno, a.expirydate, b.id, a.id as pur_itm_id from tbl_purchaseitems a join tbl_purchase b on a.purchaseid= b.purchaseid join tbl_supplier c on b.supplierid=c.id where a.productid = '$code' and b.supplierid = '$sup_id' and a.aval >= $q_ty and a.expirydate >= '$x'";
	 $result1=mysqli_query($db,$sql1);
	 $row=mysqli_fetch_array($result1);
	 $batchno=$row['batchno'];
	 $pur_itm_id = $row['pur_itm_id'];
	 $exp_dt = $row['expirydate'];
 	 $purid_qty = $pur_itm_id.'-'.$q_ty;
	if(mysqli_num_rows($result1) > 0)
	{
		$sql="update tbl_billing_items set batchno='$batchno',purchaseid = '$purid_qty', expirydate = '$exp_dt' where id='$id' and del_status != 1";

		mysqli_query($db,$sql);	
		echo $exp_dt.'~~';
	}else{
		echo ('1~~');
	}
	
	?>
	
	<select >

<?php

  $sql1=mysqli_query($db,"select distinct(b.id), a.batchno, a.expirydate, a.id as pur_id  from tbl_purchaseitems a join tbl_purchase b on a.purchaseid= b.purchaseid join tbl_supplier c on b.supplierid=c.id where a.productid = '$code' and b.supplierid = '$sup_id' and a.aval >= $q_ty and a.expirydate >= '$x' ");
  if(mysqli_num_rows($sql1) > 0){
 while ($res = mysqli_fetch_array($sql1))
	{
		$purbt_id = $res['id'];
		$bat_no = $res['batchno']; 
		$pur_id = $res['pur_id']; ?>
    <option value="<?php echo $pur_id; ?>" ><?php echo $bat_no; ?></option>
<?php } 
 $sql2  = mysqli_query($db,"update tbl_purchaseitems set aval = (aval + $q_ty) where id = $pid ");
 $sql3  = mysqli_query($db,"update tbl_purchaseitems set aval = (aval - $q_ty) where id = $pur_itm_id ");
}
?>
</select>
	
	