<?php
	session_start();
	if(!isset($_SESSION['phar-username']) || (trim($_SESSION['phar-username']) == '')) {
		header("location:login.php");
		exit();
	}
	      if( $_SESSION['days'] <=-0)
    {
         echo '<script> alert("Your licence expired please contact Raagaamed admin"); window.open("", "_self").close(); </script>';
        header("location:license-expired.php");
        exit();
    }
	
	require_once("config.php");
	if(isset($_REQUEST['billno'])){
		mysql_query("UPDATE tbl_billing set status = 8 WHERE billno = '".$_REQUEST['billno']."' AND status = 1 and del_status != 1");
		mysql_query("UPDATE tbl_billing_items set status = 8 WHERE billno = '".$_REQUEST['billno']."' AND status = 1 and del_status != 1");
		$sql = "SELECT * FROM tbl_billing WHERE billno = '".$_REQUEST['billno']."' AND status = 8 and del_status != 1";
	}else
		$sql = "SELECT * FROM tbl_billing WHERE status = 8 and del_status != 1";
	$res = mysql_query($sql);
	if(mysql_num_rows($res) != 0){
		$r = mysql_fetch_array($res);
		$billno = $r['billno'];			$flag1 = 'readonly';	$paidamt = $r['paidamt'];	$flag11 = '';
		$billingid = $r['billingid'];	$flag2 = 'disabled';	$pm = $r['paymentmode'];	$flag22 = '';
		if($pm == 'Cash'){ $cash = 'selected'; $card = ''; }
		else if($pm == 'Card'){ $card = 'selected'; $cash = ''; }
	}else{
		$billno = '';	$flag1 = '';	$flag2 = '';	$cash = '';	$card = '';		$flag11 = 'readonly';	$flag22 = 'disabled';
		$pm = '';	$paidamt = 0;	$$billingid = '';
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta charset="utf-8" />
<title>Sales Return</title>
<meta name="description" content="top menu &amp; navigation" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<!-- bootstrap & fontawesome -->
<link rel="stylesheet" href="dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="font/font-awesome.min.css" />
<!-- page specific plugin styles -->
<!-- text fonts -->
<!--<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />-->
<!-- ace styles -->
<link rel="stylesheet" href="dist/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
<link rel="icon" href="favicon.ico" type="image/x-icon"/>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
<script src="dist/js/ace-extra.min.js"></script>
<script src="dist/js/shortcuts.js"></script>
</head>
<body class="no-skin">
<div id="navbar" class="navbar navbar-default    navbar-collapse       h-navbar">
  <script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>
  <div class="navbar-container" id="navbar-container">
    <div class="navbar-header pull-left"> <a href="#" class="navbar-brand"> <small> <img height="80" width="130" src="images/logo.png" /> Pharmacy </small> </a>
      <button class="pull-right navbar-toggle navbar-toggle-img collapsed" type="button" data-toggle="collapse" data-target=".navbar-buttons,.navbar-menu"> <span class="sr-only">Toggle user menu</span> <img src="return-user-img.php?id=<?php echo $_SESSION['phar-loginid']; ?>" alt="<?php echo $_SESSION['phar-username']; ?>" /> </button>
      <button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#sidebar"> <span class="sr-only">Toggle sidebar</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    </div>
    <div class="navbar-buttons navbar-header pull-right  collapse navbar-collapse" role="navigation">
      <ul class="nav ace-nav">
        <li class="light-blue user-min"> <a id="usermenu" data-toggle="dropdown" href="#" class="dropdown-toggle"> <img class="nav-user-photo" src="return-user-img.php?id=<?php echo $_SESSION['phar-loginid']; ?>" alt="<?php echo $_SESSION['mp-username']; ?>" /> <span class="user-info"> <small>Welcome,</small> <?php echo $_SESSION['phar-username']; ?> </span> <i class="ace-icon fa fa-caret-down"></i> </a>
          <ul style="margin-top: 25px;" class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
            <!--<li> <a href="#"> <i class="ace-icon fa fa-cog"></i> Settings </a> </li>
            <li class="divider"></li> -->
            <li> <a href="logout.php"> <i class="ace-icon fa fa-power-off"></i> Logout </a> </li>
          </ul>
        </li>
      </ul>
    </div>
  </div >
  <style>
	#usermenu{
		margin-top: 25px;
	}
	.form-group {
    	margin-bottom: 5px;
	}
	@media only screen and (max-width:992px){
		#usermenu {
			margin-top: 0px;
		}
	}
	</style>
  <!-- /.navbar-container -->
</div>
 <?php include('navigate.php'); ?>
    <!-- /.nav-list -->
    <script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
  </div>
  <div class="main-content">
    <div class="main-content-inner">
      <div class="page-content">
        <div class="page-header">
          <h1> Sales <small> <i class="ace-icon fa fa-angle-double-right"></i> Sales Return </small> </h1>
        </div>
        <!-- /.page-header -->
        <div class="row">
          <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="center"> <br />
              <form class="form-horizontal" id="frmBilling">
                <div class="form-group">
      <?php include('manage-bill/includebill.php'); ?>
<div class="modal fade" tabindex="-1" role="dialog" id="mdlQuickBill">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header no-padding">
		<div class="table-header">Billing Information : </div>
	  </div>
	  <div class="modal-body no-padding" style="  max-height: 450px; min-height: 400px; overflow-y: auto;">
		<div class="col-xs-12"> <br />
		  <form class="form-horizontal">
			<div class="form-group">
			  <label class="col-xs-2 control-label">Product Type</label>
			  <div class="col-xs-2">
				<select class="form-control input-sm" name="ptype" id="ptype">
				  <option>SELECT</option>
				  <?php
						$q = mysql_query("SELECT distinct stocktype FROM tbl_productlist");
						while($r = mysql_fetch_array($q)){
							echo '<option>'.$r['stocktype'].'</option>';
						}
					?>
				</select>
			  </div>
			  <label class="col-xs-2 control-label">Product Name</label>
			  <div class="col-xs-3">
				<input type="text" class="form-control input-sm" name="pname" id="pname" placeholder="Product Name" list="lstProducts" onBlur="retBatchNo()">
			  </div>
			  <label class="col-xs-1 control-label">Batch #</label>
			  <div class="col-xs-2">
				<select class="form-control input-sm" name="batch" id="batch" onChange="retExpiry()">
				  <option>SELECT</option>
				</select>
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-xs-2 control-label">Expiry</label>
			  <div class="col-xs-2">
				<select class="form-control input-sm" name="expiry" id="expiry">
				  <option>SELECT</option>
				</select>
			  </div>
			  <label class="col-xs-1 control-label">Quantity</label>
			  <div class="col-xs-1">
				<input type="text" class="form-control input-sm mand number" name="qty" id="qty" placeholder="0" onBlur="validateQty()">
			  </div>
			  <input type="button" class="btn btn-sm btn-info col-xs-1" value="Add" onClick="addBillingItems()" />
			</div>
			<table id="tbl-list" class="table table-striped">
			  <thead>
				<tr>
				  <th style="text-align:center">Code</th>
				  <th style="text-align:center">Description</th>
				  <th style="text-align:center">Qty.</th>
				  <th style="text-align:center">Batch#</th>
				  <th style="text-align:center">Expiry</th>
				  <th style="text-align:center">Amount</th>
				  <th></th>
				</tr>
			  </thead>
			  <tbody>
			  </tbody>
			</table>
		  </form>
		</div>
	  </div>
	  <div class="modal-footer no-margin-top">
		<label class="pull-left col-xs-2">Total Amount : </label>
		<label class="pull-left col-xs-1" id="lblAmount">0.00</label>
		<div class="pull-left col-xs-2">
		  <select id="paymentmode" name="paymentmode" class="form-control input-sm">
			<option>SELECT</option>
			<option>Cash</option>
			<option>Card</option>
		  </select>
		</div>
		<button type="button" class="btn btn-primary btn-sm" onClick="closeBill('0')">Close Bill</button>
		<button type="button" class="btn btn-primary btn-sm" onClick="closeBill('1')">Close Bill & Print</button>
		<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">X</button>
	  </div>
	</div>
  </div>
</div>

            <!-- PAGE CONTENT ENDS -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.page-content -->
    </div>
  </div>
  <!-- /.main-content -->
  <?php
  include('footer.php'); 
  ?>
  <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"> <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i> </a> </div>
<!-- /.main-container -->
<!-- basic scripts -->
<!--[if !IE]> -->
<script src="libs/jquery/2.1.1/jquery.min.js"></script>
<!-- <![endif]-->
<!--[if IE]>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<![endif]-->
<!--[if !IE]> -->
<script type="text/javascript">
			window.jQuery || document.write("<script src='dist/js/jquery.min.js'>"+"<"+"/script>");
		</script>
<!-- <![endif]-->
<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='dist/js/jquery1x.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='dist/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
<script src="bootstrap/3.3.1/js/bootstrap.min.js"></script>
<!-- page specific plugin scripts -->
<!-- ace scripts -->
<script src="dist/js/ace-elements.min.js"></script>
<script src="dist/js/ace.min.js"></script>
<!-- inline scripts related to this page -->
<script src="manage-bill/sales-return.js"></script>
<script>
</script>
</body>
<!-- Mirrored from responsiweb.com/themes/preview/ace/1.3.3/top-menu.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 May 2015 06:07:38 GMT -->
</html>
