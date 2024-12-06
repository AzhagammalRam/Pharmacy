<?php
	$id = $_REQUEST['id'];
	include("../config.php");
	$sql = "SELECT * FROM tbl_users WHERE id = ".$id;
	$res = mysqli_query($db,$sql);
	$rs = mysqli_fetch_array($res);
	$role = $rs['role'];
	$status = $rs['status'];
	$store = $rs['storeid'];

	$sq = "SELECT name FROM branch WHERE id = '$store'";
	$rse = mysqli_query($db,$sq);
	$rsv = mysqli_fetch_array($rse);
	$storename = $rsv['name'];

	$roletype = ($role == 1) ? "Admin" : "User";
	$statustype = ($status == 1) ? "<span class='label label-sm label-success arrowed-in arrowed-in-right'>Active</span>" : "<span class='label label-sm label-arrowed arrowed-in arrowed-in-right'>Expired</span>";
	echo $rs['username'] . '~' . $rs['userid'] . '~' . $roletype . '~' . $statustype. '~' . $storename . '~' . $rs['id'];
	
	if($rs['mp']) echo '~<span class="label label-info arrowed-right arrowed-in">Manage Product</span>';
	else echo '~<span class="label arrowed">Manage Users</span>';
		
	if($rs['mm']) echo '~<span class="label label-info arrowed-right arrowed-in">Manage Manufacturer</span>';
	else echo '~<span class="label arrowed">Manage Manufacturer</span>';
		
	if($rs['ms']) echo '~<span class="label label-info arrowed-right arrowed-in">Manage Supplier</span>';
	else echo '~<span class="label arrowed">Manage Supplier</span>';
		
	if($rs['mu']) echo '~<span class="label label-info arrowed-right arrowed-in">Manage User</span>';
	else echo '~<span class="label arrowed">Manage User</span>';

	if($rs['md']) echo '~<span class="label label-info arrowed-right arrowed-in">Manage Doctor</span>';
	else echo '~<span class="label arrowed">Manage Doctor</span>';

	if($rs['mst']) echo '~<span class="label label-info arrowed-right arrowed-in">Manage Store</span>';
	else echo '~<span class="label arrowed">Manage Store</span>';	

	if($rs['sc']) echo '~<span class="label label-info arrowed-right arrowed-in">Supplier Credit</span>';
	else echo '~<span class="label arrowed">Supplier Credit</span>';

	if($rs['cc']) echo '~<span class="label label-info arrowed-right arrowed-in">Customer Credit</span>';
	else echo '~<span class="label arrowed">Customer Credit</span>';

	if($rs['bill']) echo '~<span class="label label-info arrowed-right arrowed-in">Billing</span>';
	else echo '~<span class="label arrowed">Billing</span>';

	if($rs['dreturn']) echo '~<span class="label label-info arrowed-right arrowed-in">Drug Return</span>';
	else echo '~<span class="label arrowed">Drug Return</span>';
		
	if($rs['sr']) echo '~<span class="label label-info arrowed-right arrowed-in">Sales Return</span>';
	else echo '~<span class="label arrowed">Sales Return</span>';
	
	if($rs['pe']) echo '~<span class="label label-info arrowed-right arrowed-in">Purchase Entry</span>';
	else echo '~<span class="label arrowed">Purchase Entry</span>';
		
	if($rs['pr']) echo '~<span class="label label-info arrowed-right arrowed-in">Purchase Return</span>';
	else echo '~<span class="label arrowed">Purchase Return</span>';

	if($rs['preturot']) echo '~<span class="label label-info arrowed-right arrowed-in">Purchase Return-Others</span>';
	else echo '~<span class="label arrowed">Purchase Return-Others</span>';
		
	if($rs['sa']) echo '~<span class="label label-info arrowed-right arrowed-in">Stock Availability</span>';
	else echo '~<span class="label arrowed">Stock Availability</span>';

	if($rs['sttra']) echo '~<span class="label label-info arrowed-right arrowed-in">Stock Transfer</span>';
	else echo '~<span class="label arrowed">Stock Transfer</span>';

	if($rs['ustock']) echo '~<span class="label label-info arrowed-right arrowed-in">Stock Clearance</span>';
	else echo '~<span class="label arrowed">Stock Clearance</span>';

	if($rs['clearstock']) echo '~<span class="label label-info arrowed-right arrowed-in">Disposed Stocks</span>';
	else echo '~<span class="label arrowed">Disposed Stocks</span>';

	if($rs['ise']) echo '~<span class="label label-info arrowed-right arrowed-in">Initial Stock Entry</span>';
	else echo '~<span class="label arrowed">Initial Stock Entry</span>';
		
	if($rs['stka']) echo '~<span class="label label-info arrowed-right arrowed-in">Stock Adjustment</span>';
	else echo '~<span class="label arrowed">Stock Adjustment</span>';
	
	if($rs['srep']) echo '~<span class="label label-info arrowed-right arrowed-in">Sales Report</span>';
	else echo '~<span class="label arrowed">Sales Report</span>';
		
	if($rs['prep']) echo '~<span class="label label-info arrowed-right arrowed-in">Purchase Report</span>';
	else echo '~<span class="label arrowed">Purchase Report</span>';
	
	if($rs['doc']) echo '~<span class="label label-info arrowed-right arrowed-in">Doctor Report</span>';
	else echo '~<span class="label arrowed">Doctor Report</span>';

	if($rs['pfrep']) echo '~<span class="label label-info arrowed-right arrowed-in">PF Report</span>';
	else echo '~<span class="label arrowed">PF Report</span>';

	if($rs['purretrep']) echo '~<span class="label label-info arrowed-right arrowed-in">Purchase Retun Report</span>';
	else echo '~<span class="label arrowed">Purchase Retun Report</span>';

	if($rs['storep']) echo '~<span class="label label-info arrowed-right arrowed-in">Store Report</span>';
	else echo '~<span class="label arrowed">Store Report</span>';
	
	if($rs['iprep']) echo '~<span class="label label-info arrowed-right arrowed-in">Ip Bill Summary Report</span>';
	else echo '~<span class="label arrowed">Ip Bill Summary Report</span>';

	if($rs['vat']) echo '~<span class="label label-info arrowed-right arrowed-in">Tax Report</span>';
	else echo '~<span class="label arrowed">Tax Report</span>';
	
	if($rs['sch']) echo '~<span class="label label-info arrowed-right arrowed-in">Schedule Report</span>';
	else echo '~<span class="label arrowed">Schedule Report</span>';

	if($rs['exrep']) echo '~<span class="label label-info arrowed-right arrowed-in">Short Expiry Report</span>';
	else echo '~<span class="label arrowed">Short Expiry Report</span>';

	if($rs['dgrep']) echo '~<span class="label label-info arrowed-right arrowed-in">Drug Return Report</span>';
	else echo '~<span class="label arrowed">Drug Return Report</span>';

	if($rs['dispose_report']) echo '~<span class="label label-info arrowed-right arrowed-in">Disposed report</span>';
	else echo '~<span class="label arrowed">Disposed report</span>';

	if($rs['cmrep']) echo '~<span class="label label-info arrowed-right arrowed-in">Camp Medicine Report</span>';
	else echo '~<span class="label arrowed">Camp Medicine Report</span>';
		
		
?>