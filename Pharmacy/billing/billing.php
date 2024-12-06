<?php
	session_start();
	if(!isset($_SESSION['phar-username']) || (trim($_SESSION['phar-username']) == '')) {
		header("location:login.php");
		exit();
	}
	//$id=$_GET['id'];

	if(isset($_GET['id']))
		$id=$_GET['id'];
		else
		$id=0;
		//echo $id;
		
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta charset="utf-8" />
<title>Billing</title>
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
<script src="libs/jquery/2.1.1/jquery.min.js"></script>
<script src="dist/js/ace-extra.min.js"></script>
</head>
<body class="no-skin">
<div id="navbar" class="navbar navbar-default    navbar-collapse       h-navbar">
  <script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>
  <div class="navbar-container" id="navbar-container">
    <div class="navbar-header pull-left"> <a href="#" class="navbar-brand"> <small> <img height="80" width="130" src="images/logoo.png" /> Pharmacy </small> </a>
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
	@media only screen and (max-width:992px){
		#usermenu {
			margin-top: 0px;
		}
	}
	</style>
  <!-- /.navbar-container -->
</div>
<div class="main-container container" id="main-container">
<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>
<div id="sidebar" class="sidebar      h-sidebar                navbar-collapse collapse">
  <script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>
  <ul class="nav nav-list">
    <li class="hover"> <a href="index.php"> <i class="menu-icon fa fa-tachometer"></i> <span class="menu-text"> Dashboard </span> </a> <b class="arrow"></b> </li>
    <?php
	if($_SESSION['bill'] == 1 || $_SESSION['sr'] == 1){
		echo '<li class="active open hover highlight"> <a href="#" class="dropdown-toggle"> <i class="menu-icon fa fa-pencil-square-o"></i> <span class="menu-text"> Sales </span> <b class="arrow fa fa-angle-down"></b> </a> <b class="arrow"></b><ul class="submenu">';
		if($_SESSION['bill'] == 1) echo '<li class="active open hover"> <a href="billing.php"> <i class="menu-icon fa fa-caret-right"></i> Billing </a> <b class="arrow"></b> </li>';
	if($_SESSION['sr'] == 1) echo '<li class="hover"> <a href="sales-return.php"> <i class="menu-icon fa fa-caret-right"></i> Sales Return</a> <b class="arrow"></b> </li>';
		if($_SESSION['sr'] == 1) echo '<li class="hover"> <a href="d_sales-return.php"> <i class="menu-icon fa fa-caret-right"></i> Drug Return</a> <b class="arrow"></b> </li>';
        echo '</ul></li>';
	}
	if($_SESSION['mp'] == 1 ||	$_SESSION['mm'] == 1 ||	$_SESSION['ms'] ==1 || $_SESSION['mu'] == 1){
		echo '<li class="hover"> <a href="#" class="dropdown-toggle"> <i class="menu-icon fa fa-desktop"></i> <span class="menu-text"> Master Entry </span> <b class="arrow fa fa-angle-down"></b> </a> <b class="arrow"></b><ul class="submenu">';
		if($_SESSION['mp'] == 1) echo '<li class="active open hover"> <a href="manage-product.php"> <i class="menu-icon fa fa-caret-right"></i> Manage Products </a> <b class="arrow"></b> </li>';
		if($_SESSION['ms'] == 1) echo '<li class="hover"> <a href="manage-supplier.php"> <i class="menu-icon fa fa-caret-right"></i> Manage Suppliers </a> <b class="arrow"></b> </li>';
		if($_SESSION['mm'] == 1) echo '<li class="hover"> <a href="manage-manufacturer.php"> <i class="menu-icon fa fa-caret-right"></i> Manage Manufacturer </a> <b class="arrow"></b> </li>';
		if($_SESSION['mu'] == 1) echo '<li class="hover"> <a href="manage-user.php"> <i class="menu-icon fa fa-caret-right"></i> Manage Users </a> <b class="arrow"></b> </li>';
		if($_SESSION['mu'] == 1) echo '<li class="hover"> <a href="manage-doctor.php"> <i class="menu-icon fa fa-caret-right"></i> Manage Doctor </a> <b class="arrow"></b> </li>';
		echo '</ul></li>';
	}
	if($_SESSION['pe'] == 1 || $_SESSION['pr'] == 1){
		echo '<li class="hover"> <a href="#" class="dropdown-toggle"> <i class="menu-icon fa fa-shopping-cart"></i> <span class="menu-text"> Purchase </span> <b class="arrow fa fa-angle-down"></b> </a> <b class="arrow"></b><ul class="submenu">';
		if($_SESSION['pe'] == 1) echo '<li class="active open hover"> <a href="purchase-entry.php"> <i class="menu-icon fa fa-caret-right"></i> Purchase Entry </a> <b class="arrow"></b> </li>';
		// if($_SESSION['pr'] == 1) echo '<li class="hover"> <a href="purchase-return.php"> <i class="menu-icon fa fa-caret-right"></i> Purchase Return </a> <b class="arrow"></b> </li>';
        echo '</ul></li>';
	}
	if($_SESSION['sa'] == 1 || $_SESSION['ise'] == 1 || $_SESSION['stka'] == 1 || $_SESSION['sttra'] == 1){
		echo '<li class="hover"> <a href="#" class="dropdown-toggle"> <i class="menu-icon fa fa-line-chart"></i> <span class="menu-text"> Stocks </span> <b class="arrow fa fa-angle-down"></b> </a> <b class="arrow"></b><ul class="submenu">';
		if($_SESSION['sttra'] == 1) echo '<li class="active open hover"> <a href="stock-transfer.php"> <i class="menu-icon fa fa-caret-right"></i> Stock Transfer </a> <b class="arrow"></b> </li>';
		if($_SESSION['sa'] == 1) echo '<li class="open hover"> <a href="stock-availability.php"> <i class="menu-icon fa fa-caret-right"></i> Stock Availability </a> <b class="arrow"></b> </li>';
		if($_SESSION['ise'] == 1) echo '<li class="hover"> <a href="initial-stock-entry.php"> <i class="menu-icon fa fa-caret-right"></i> Initial Stock Entry </a> <b class="arrow"></b> </li>';
		if($_SESSION['stka'] == 1) echo '<li class="hover"> <a href="stock-adjustment.php"> <i class="menu-icon fa fa-caret-right"></i> Stock Adjustment </a> <b class="arrow"></b> </li>';
        echo '</ul></li>';
	}
	if($_SESSION['prep'] == 1 || $_SESSION['srep'] == 1 || $_SESSION['doc'] == 1 || $_SESSION['vat'] == 1 || $_SESSION['sch'] == 1){
		echo '<li class="hover"> <a href="#" class="dropdown-toggle"> <i class="menu-icon fa fa-calendar"></i> <span class="menu-text"> Reports</span> <b class="arrow fa fa-angle-down"></b> </a> <b class="arrow"></b><ul class="submenu">';
		if($_SESSION['srep'] == 1) echo '<li class="active open hover"> <a href="sales-report.php"> <i class="menu-icon fa fa-caret-right"></i> Sales Report </a> <b class="arrow"></b> </li>';
		if($_SESSION['prep'] == 1) echo '<li class="hover"> <a href="purchase-report.php"> <i class="menu-icon fa fa-caret-right"></i> Purchase Report </a> <b class="arrow"></b> </li>';
		if($_SESSION['doc'] == 1) echo '<li class="hover"> <a href="doctor-report.php"> <i class="menu-icon fa fa-caret-right"></i> Doctor Report </a> <b class="arrow"></b> </li>';
		if($_SESSION['vat'] == 1) echo '<li class="hover"> <a href="tax-report.php"> <i class="menu-icon fa fa-caret-right"></i> TAX Report </a> <b class="arrow"></b> </li>';
if($_SESSION['sch'] == 1) echo '<li class="hover"> <a href="schedule-report.php"> <i class="menu-icon fa fa-caret-right"></i> Schedule Drug Report </a> <b class="arrow"></b> </li>';
if($_SESSION['sch'] == 1) echo '<li class="hover"> <a href="pf-report.php"> <i class="menu-icon fa fa-caret-right"></i> PF Report </a> <b class="arrow"></b> </li>';
if($_SESSION['sch'] == 1) echo '<li class="hover"> <a href="ipbillsum.php"> <i class="menu-icon fa fa-caret-right"></i> Ip Bill Summary </a> <b class="arrow"></b> </li>';
        echo '</ul></li>';
	}
	if($_SESSION['phar-role'] == 1) {
      	echo '<li class="hover"> <a href="manage-license.php"> <i class="menu-icon fa fa-key"></i> <span class="menu-text"> License </span> <b class="arrow fa fa-angle-down"></b> </a> </li>';
	  }
	  if($_SESSION['bill'] == 1) {
      	echo '<li class="hover pull-right"> <a href="#" onClick="quickBilling(1)"> <i class="menu-icon fa fa-pencil-square-o"></i> <span class="menu-text"> Quick Bill </span> <b class="arrow fa fa-angle-down"></b> </a> </li>';
	  }
	 if($_SESSION['bill'] == 1) {
      	echo '<li class="hover pull-right"> <a href="#" onClick="quickBilling(2)"> <i class="menu-icon fa fa-pencil-square-o"></i> <span class="menu-text"> Quick Bill IP</span> <b class="arrow fa fa-angle-down"></b> </a> </li>';
	 }
	  ?>
  </ul>
  <?php include('manage-bill/includebill.php'); ?>
  <!-- /.nav-list -->
  <script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
</div>
<div class="main-content">
<div class="main-content-inner">
  <div class="page-content">
    <div class="page-header">
      <h1> Sales <small> <i class="ace-icon fa fa-angle-double-right"></i> Billing </small> <a style="display:none" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#mdlNewBill" style="text-align:none;"> New Bill</a> </h1>
    </div>
    <!-- /.page-header -->
    <div class="row">
      <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <div class="center"> <br />
          <div class="widget-box">
            <div class="widget-header">
              <h4 class="widget-title lighter smaller"> <i class="ace-icon fa fa-cogs blue"></i> Bills </h4>
            </div>
            <div class="widget-body">
              <div class="widget-main no-padding">
                <div class="dialogs ace-scroll">
                  <div class="scroll-track scroll-active" style="display: block; height: 300px;">
                    <div class="scroll-bar" style="height: 262px; top: 0px;"></div>
                  </div>
                  <div id="divUserList">
                    <?php 
							require_once("config.php");
							$res = mysql_query("SELECT * FROM tbl_billing WHERE status = 2");
							while($rs = mysql_fetch_array($res)){ ?>
                    <div class="scroll-content col-xs-4">
                      <div class="itemdiv dialogdiv">
                        <div class="user"> <img alt="<?php echo $rs['patientname']; ?>" src="dist/avatars/user.png"> </div>
                        <a href="#" style="cursor:pointer;text-decoration:none;" data-toggle="modal" data-target="#modal-view<?php echo $rs['id']; ?>" data-whatever="<?php echo $rs['id']; ?>" data-backdrop="static">
                        <div class="body">
                          <div class="name"><?php echo $rs['patientname']; ?></div>
                          <div class="text"><i class="fa fa-user-md orange"></i> <?php echo $rs['drname']; ?></div>
                          <div class="tools"> <a href="javascript:deleteBill('<?php echo $rs['id']; ?>');" class="btn btn-minier btn-danger"> <i class="fa fa-trash"></i> </a> </div>
                        </div>
                        </a> </div>
                    </div>
                    <div class="modal fade direct-bill" tabindex="-1" role="dialog" id="modal-view<?php echo $rs['id']; ?>">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header no-padding">
                            <div class="table-header">Billing Information : <?php echo $rs['patientname']; ?></div>
                          </div>
                          <div class="modal-body no-padding" style="  max-height: 450px; min-height: 400px; overflow-y: auto;">
                            <div class="col-xs-12"> <br />
                              <form class="form-horizontal">
                                <div class="form-group">
                                  <label class="col-xs-2 control-label">Product Type</label>
                                  <div class="col-xs-2">
                                    <select class="form-control input-sm" name="ptype<?php echo $rs['id']; ?>" id="ptype<?php echo $rs['id']; ?>" onchange="getval(this);">
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
                                    <input type="text" class="form-control input-sm" name="pname<?php echo $rs['id']; ?>" id="pname<?php echo $rs['id']; ?>" placeholder="Product Name" list="lstProducts" onBlur="retBatchNo('<?php echo $rs['id']; ?>')">
                                  </div>
                                  <label class="col-xs-1 control-label">Batch #</label>
                                  <div class="col-xs-2">
                                    <select class="form-control input-sm" name="batch<?php echo $rs['id']; ?>" id="batch<?php echo $rs['id']; ?>" onChange="returnExpiry('<?php echo $rs['id']; ?>')">
                                      <option>SELECT</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group">
								
								 <label class="col-xs-2 control-label">Aval</label>
                                  <div class="col-xs-2">
                                    <select class="form-control input-sm" name="aval<?php echo $rs['id']; ?>" id="aval<?php echo $rs['id']; ?>">
                                     
                                    </select>
                                  </div>
								  
                                  <label class="col-xs-2 control-label">Expiry</label>
                                  <div class="col-xs-2">
                                    <select class="form-control input-sm" name="expiry<?php echo $rs['id']; ?>" id="expiry<?php echo $rs['id']; ?>">
                                     
                                    </select>
                                  </div>
                                  <label class="col-xs-1 control-label">Quantity</label>
                                  <div class="col-xs-1">
                                  <input type="text" class="form-control input-sm mand number" name="qty<?php echo $rs['id']; ?>" id="qty<?php echo $rs['id']; ?>" placeholder="0" onBlur="validateQty('<?php echo $rs['id']; ?>')">
                                  </div>
                                  <input type="button" class="btn btn-sm btn-info col-xs-1" value="Add" onClick="addBillingItems('<?php echo $rs['id']; ?>')" />
                                </div>
                                <table id="tbl-list<?php echo $rs['id']; ?>" class="table table-striped">
                                  <thead>
                                    <tr>
                                      <th style="text-align:center">Code</th>
                                      <th style="text-align:center">Description</th>
                                      <th style="text-align:center">Qty.</th>
                                      <th style="text-align:center">Batch#</th>
                                      <th style="text-align:center">Expiry</th>
									   <th style="text-align:center">Amount</th>
                                      <th style="text-align:center">Action</th>
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
                            <label class="pull-left col-xs-1" id="lblAmount<?php echo $rs['id']; ?>">0.00</label>
                            <div class="pull-left col-xs-2">
                              <select id="paymentmode<?php echo $rs['id']; ?>" name="paymentmode<?php echo $rs['id']; ?>" class="form-control input-sm">
                                <option>SELECT</option>
                                <option>Cash</option>
                                <option>Card</option>
<option>Credit-Staff</option>
<option>Credit</option>
<option>Credit-NC</option>
<option>Credit-Claim</option>
                              </select>
                            </div>
							 <div class="pull-left col-xs-2">
                              <input type="text" name="discount<?php echo $rs['id']; ?>" id="discount<?php echo $rs['id']; ?>" Placeholder="Discount %" class="form-control input-sm" onBlur="getdiscount(<?php echo $rs['id']; ?>)">
                              
                            </div>
							
							 <div class="pull-left col-xs-1">
                              <input type="text" name="reminder<?php echo $rs['id']; ?>" id="reminder<?php echo $rs['id']; ?>" Placeholder="SMS" class="form-control input-sm  mand number" onBlur="getdiscount(<?php echo $rs['id']; ?>)">
                              
                            </div>
                            <button type="button" class="btn btn-primary btn-sm" onClick="closeBill('<?php echo $rs['id']; ?>','0')">Close Bill</button>
                            <button type="button" class="btn btn-primary btn-sm" onClick="closeBill('<?php echo $rs['id']; ?>','1')">Close Bill & Print</button>
                            <button type="button" class="btn btn-default btn-sm"  onClick="closemodal(<?php echo $rs['id']; ?>)">X</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php } ?>
                  </div>
                  <!-- /.widget-main -->
                </div>
                <!-- /.widget-body -->
              </div>
              <!-- /.widget-box -->
            </div>
			<script>
			
			</script>
			
            <datalist id="lstProducts">
              <?php
					require_once("config.php");
					$rres = mysql_query("SELECT productname FROM tbl_productlist WHERE status = 1 ORDER BY productname asc" );
					while($rrs = mysql_fetch_array($rres)){
						echo '<option>'.$rrs['productname'].'</option>';
					}
				?>
            </datalist>
          </div>
          <br />
          <br />
          <?php 
			require_once("config.php");
			$s1 = mysql_query("SELECT status FROM tbl_setting WHERE settingstype = 'DPP'");
			$srs = mysql_fetch_array($s1);
			$dpp = $srs['status'] ? $srs['status'] : 0;
			if($dpp == 1) { ?>
          <!-- /.col -->
          <div class="widget-box">
            <div class="widget-header">
              <h4 class="widget-title lighter smaller"> <i class="ace-icon fa fa-cogs blue"></i> Patients Bills </h4>
            </div>
            <div class="widget-body">
              <div class="widget-main no-padding">
                <div class="dialogs ace-scroll">
                  <div class="scroll-track scroll-active" style="display: block; height: 300px;">
                    <div class="scroll-bar" style="height: 262px; top: 0px;"></div>
                  </div>
                  <div id="divUserList">
                    <?php 
							require_once("config.php");
							$res = mysql_query("SELECT * FROM tbl_billing WHERE status = 3");
							while($rs = mysql_fetch_array($res)){ ?>
                    <div class="scroll-content col-xs-4">
                      <div class="itemdiv dialogdiv">
                        <div class="user"> <img alt="<?php echo $rs['patientname']; ?>" src="dist/avatars/user.png"> </div>
                        <a href="#" style="cursor:pointer;text-decoration:none;" data-toggle="modal" data-target="#modal-view<?php echo $rs['id']; ?>" data-whatever="<?php echo $rs['id']; ?>" data-backdrop="static">
                        <div class="body">
                          <div class="name"><?php echo $rs['patientname']; ?></div>
                          <div class="text"><i class="icon-user-md"></i><?php echo $rs['drname']; ?></div>
                          <div class="tools"> <a href="javascript:deleteXBill('<?php echo $rs['id']; ?>');" class="btn btn-minier btn-danger"> <i class="fa fa-trash"></i> </a> </div>
                        </div>
                        </a> </div>
                    </div>
                    <div class="modal fade patient-bill" tabindex="-1" role="dialog" id="modal-view<?php echo $rs['id']; ?>">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header no-padding">
                            <div class="table-header">Billing Information : <?php echo $rs['patientname']; ?></div>
                          </div>
                          <div class="modal-body no-padding" style="  max-height: 450px; min-height: 400px; overflow-y: auto;">
                            <div class="col-xs-12"> <br />
                              <form class="form-horizontal">
                                <div class="form-group">
                                  <label class="col-xs-2 control-label">Product Type</label>
                                  <div class="col-xs-2">
                                    <select class="form-control input-sm" name="ptype<?php echo $rs['id']; ?>" id="ptype<?php echo $rs['id']; ?>">
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
                                    <input type="text" class="form-control input-sm" name="pname<?php echo $rs['id']; ?>" id="pname<?php echo $rs['id']; ?>" placeholder="Product Name" list="lstProducts" onBlur="retBatchNo('<?php echo $rs['id']; ?>')">
                                  </div>
                                  <label class="col-xs-1 control-label">Batch #</label>
                                  <div class="col-xs-2">
                                    <select class="form-control input-sm" name="batch<?php echo $rs['id']; ?>" id="batch<?php echo $rs['id']; ?>" onChange="retExpiry('<?php echo $rs['id']; ?>')">
                                      <option>SELECT</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group">
								
								<label class="col-xs-2 control-label">Aval</label>
                                  <div class="col-xs-2">
                                    <select class="form-control input-sm" name="aval<?php echo $rs['id']; ?>" id="aval<?php echo $rs['id']; ?>">
                                      <option>SELECT</option>
                                    </select>
                                  </div>
								  
                                  <label class="col-xs-2 control-label">Expiry</label>
                                  <div class="col-xs-2">
                                    <select class="form-control input-sm" name="expiry<?php echo $rs['id']; ?>" id="expiry<?php echo $rs['id']; ?>">
                                      <option>SELECT</option>
                                    </select>
                                  </div>
                                  <label class="col-xs-1 control-label">Quantity</label>
                                  <div class="col-xs-1">
                                    <input type="text" class="form-control input-sm mand number" name="qty<?php echo $rs['id']; ?>" id="qty<?php echo $rs['id']; ?>" placeholder="0" onBlur="validateQty('<?php echo $rs['id']; ?>')">
                                  </div>
                                  <input type="button" class="btn btn-sm btn-info col-xs-1" value="Add" onClick="addXBillingItems('<?php echo $rs['id']; ?>')" />
                                </div>
                                <table id="tbl-list<?php echo $rs['id']; ?>" class="table table-striped">
                                  <thead>
                                    <tr>
                                      <th style="text-align:center">Code</th>
                                      <th style="text-align:center">Description</th>
                                      <th style="text-align:center">Freq.</th>
                                      <th style="text-align:center">Dur.</th>
                                      <th style="text-align:center">Spec.</th>
                                      <th style="text-align:center">Batch#</th>
                                      <th style="text-align:center">Expiry</th>
                                      <th style="text-align:center">Qty.</th>
                                      <th style="text-align:center">Amount</th>
                                      <th></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                  <tfoot>
                                  </tfoot>
                                </table>
                              </form>
                            </div>
                          </div>
                          <div class="modal-footer no-margin-top">
                            <label class="pull-left col-xs-2">Total Amount : </label>
                            <label class="pull-left col-xs-1" id="lblAmount<?php echo $rs['id']; ?>">0.00</label>
                            <div class="pull-left col-xs-2">
                              <select id="paymentmode<?php echo $rs['id']; ?>" name="paymentmode<?php echo $rs['id']; ?>" class="form-control input-sm">
                                <option>SELECT</option>
                                <option>Cash</option>
                                <option>Card</option>
<option>Credit-Staff</option>
<option>Credit</option>
<option>Credit-NC</option>
<option>Credit-Claim</option>
                              </select>
                            </div>
                            <button type="button" class="btn btn-primary btn-sm" onClick="closeBill('<?php echo $rs['id']; ?>','0')">Close Bill</button>
                            <button type="button" class="btn btn-primary btn-sm" onClick="closeBill('<?php echo $rs['id']; ?>','1')">Close Bill & Print</button>
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">X</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php } ?>
                  </div>
                  <!-- /.widget-main -->
                </div>
                <!-- /.widget-body -->
              </div>
              <!-- /.widget-box -->
            </div>
			
			
            <datalist id="lstProducts">
			
			
              <?php
					require_once("config.php");
					$rres = mysql_query("SELECT productname FROM tbl_productlist WHERE status = 1 ORDER BY productname asc");
					while($rrs = mysql_fetch_array($rres)){
						echo '<option>'.$rrs['productname'].'</option>';
					}
				?>
            </datalist>
          </div>
          <?php } ?>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.page-content -->
    </div>
  </div>
  <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="mdlNewBill">
    <div class="modal-dialog modal-xs">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">New Bill</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal">
            <div class="form-group">
              <label class="col-xs-3 control-label">Patient Name</label>
              <div class="col-xs-8">
                <input type="text" class="form-control input-sm mand" name="patientname" id="patientname" placeholder="Patient Name">
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-3 control-label">Doctor Name</label>
              <div class="col-xs-8">
                <input type="text" class="form-control input-sm" name="drname" id="drname" placeholder="Doctor Name">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-sm" onClick="createNewBill()">Create Bill</button>
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="patModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="exampleModalLabel">Update Product Details</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" id="updForm">
		  	<input type="hidden" id="dbval" name="dbval" />
			<input type="hidden" id="trval" name="trval" />
            <div class="form-group">
              <label class="col-xs-3 control-label">Product Type</label>
              <div class="col-xs-2">
                <select class="form-control input-sm" name="xptype" id="xptype" disabled >
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
              <div class="col-xs-4">
                <input type="text" class="form-control input-sm" name="xpname" id="xpname" placeholder="Product Name" readonly>
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-2 control-label">Batch #</label>
              <div class="col-xs-2">
                <select class="form-control input-sm" name="xpbatch" id="xpbatch" onChange="retX1Expiry()">
                  <option>SELECT</option>
                </select>
              </div>
			   <label class="col-xs-2 control-label">Aval</label>
              <div class="col-xs-2">
                <select class="form-control input-sm myalert" name="paval" id="paval">
                  <option>SELECT</option>
                </select>
              </div>
			  
              <label class="col-xs-2 control-label">Expiry</label>
              <div class="col-xs-2">
                <select class="form-control input-sm myalert" name="pexpiry" id="pexpiry">
                  <option>SELECT</option>
                </select>
              </div>
              <label class="col-xs-2 control-label">Quantity</label>
              <div class="col-xs-1">
                <input type="text" class="form-control input-sm mand number" name="pqty" id="pqty" placeholder="0" onBlur="validateX1Qty()">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-sm" onClick="updatePItems()">Save</button>
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        </div>
      </div>
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
<script src="manage-bill/manage-bill.js"></script>

<script>
openmodal(<?php echo $id; ?>);
			function openmodal(x) {
			var s='modal-view'+x;
			
			//$('#modal-view7').fadeIn();  
			//$('#modal-view7').dialog({ show: 'fade' });
			$('#'+s).modal('toggle');
			//alert(s);
			}

      function edittotal(x,y)
{
  var sumt=0;
  var total=0;
  var sumt1=0;
  var y=y;
  var edqty1=$('#edqty'+x).val();
  var edttl1=$('#edttl'+x).val();
  var sumb=$('#lblAmount'+y).html();

  var codei=$('#codei'+x).html();
  var bqty=$('#edqty'+x).attr('data-qty');
  var bedttl1=$('#edttl'+x).attr('data-qty');
 // alert(bqty)
  total = (parseFloat(bedttl1)/parseFloat(bqty))*parseFloat(edqty1);
  
 // sumt1=parseFloat(bedttl1)-parseFloat(total);
  //sumt=parseFloat(sumb)-parseFloat(sumt1)
 
  $('#edttl'+x).val(total);
  $('#edqty'+x).val(edqty1);
 // $('#lblAmount'+y).html(sumt);
  $.ajax({
    type: 'post',
    url: 'billqtyupdate.php',
    data: {
      id: y,
      qty: edqty1,
      total: total,
      code:codei
    },
    success: function(msg){
       //var sumb=$('#lblAmount'+y).html();
       //alert(sumb)
      
       var sumt=parseFloat(sumb)+parseFloat(msg);
       $('#lblAmount'+y).html(sumt).toFixed(2);
       //alert(x)
      //alert(msg)
      //$('#lblAmount'+y).val(msg);
    }
  });
  //alert(sumt);
  // $('#ttl').val('');
       // $('#ttl').html(total);
    
}
</script>
</body>
<!-- Mirrored from responsiweb.com/themes/preview/ace/1.3.3/top-menu.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 May 2015 06:07:38 GMT -->
</html>
