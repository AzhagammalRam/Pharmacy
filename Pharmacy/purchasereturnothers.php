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
	$res = mysqli_query($db,"SELECT * FROM tbl_purchase_return WHERE status = 2");
	if(mysqli_num_rows($res)){

		$rs = mysqli_fetch_array($res);
		$purchaseid = $rs['id'];
		$purchaseitemid = $rs['purchaseid'];
		$supplierid = $rs['supplierid'];
		$invoiceno = $rs['invoiceno'];
		$invoicedate = implode("/", array_reverse(explode("-",$rs['invoicedate'])));
		$invoiceamt = $rs['invoiceamt'];
		$invoicetype = $rs['invoicetype'];
		$credited_amount = $rs['credit_adj'];
		if($invoicetype == "CASH"){
			$cash = 'selected="selected"';
			$visible = '<script>$("#divcash").show(); $("#mdlPurchase").modal("show");</script>';
		}else if($invoicetype == "CR"){
			$cr = 'selected="selected"';
			$visible = '<script>$("#divcr").show(); $("#mdlPurchase").modal("show");</script>';
		}
		
		$payment = $rs['payment'];

		$res1 = mysqli_query($db,"SELECT * FROM tbl_supplier WHERE id = $supplierid");
		$r1 = mysqli_fetch_array($res1);
		$suppliername = $r1['suppliername'];
		// $add1 = $r1['addressline1'];		$add2 = $r1['addressline2'];		$add3 = $r1['addressline3'];
		// $contactno = $r1['contactno1'];
		$credit = $r1['credit'];
		// $res2 = mysqli_query($db,"SELECT * FROM tbl_payment WHERE id = $payment");
		// $r2 = mysqli_fetch_array($res2);
		// $creditdate = implode("/", array_reverse(explode("-",$r2['creditdate'])));
		// $paymentdate = implode("/", array_reverse(explode("-",$r2['paymentdate'])));
		// $payable = $r2['payable'];
		// $paymentamt = $r2['paymentamt'];
		
		$readonly = "readonly";
		$disabled = 'disabled="disabled"';
		$enabled = '';
	}else{
		$purchaseid = '';	$maufacturerid = '';		$invoiceno = '';
		$invoicedate = date('d/m/Y');	$invoiceamt = '';			$invoicetype = '';
		$payment = '';		$add1 = '';		$add2 = '';	$add3 = '';
		$contactno = '';	$creditdate = '';			$paymentdate = '';
		$payable = '';		$paymentamt = '';
		$readonly = '';		$disabled = '';
		$cash = '';			$cr = '';		$visible = '';	$enabled = 'disabled="disabled"';
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta charset="utf-8" />
<title>Purchase Return</title>
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
 <?php 
  $currenttab = 'Purchase';
 $currentPage = 'Purchase_Return_Others';
 include('navigate.php'); ?>
    <!-- /.nav-list -->
    <script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
  </div>
  <div class="main-content">
    <div class="main-content-inner">
      <div class="page-content">
        <div class="page-header">
          <h1> Purchase Return<small> <i class="ace-icon fa fa-angle-double-right"></i> Purchase Return Entry Others </small> </h1>
        </div>
        <!-- /.page-header -->
        <div class="row">
          <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="center"> <br />
              <form class="form-horizontal" id="frmPurchase">
                <div class="col-xs-6">
                  <div class="row">
                    <div class="form-group">
                      <label for="supplier" class="col-xs-4 control-label">Supplier Name</label>
                      <div class="col-xs-8">
                        <input type="hidden" class="form-control" name="purchaseid" id="purchaseid" readonly value="<?php echo $purchaseid; ?>" />
                        <input type="text" class="form-control" name="supplier" id="supplier"  placeholder="Supplier Name" list="lstSupplier" onBlur="supplierDetails()">
                        <datalist id="lstSupplier">
                          <?php
							require_once("config.php");
							$res = mysqli_query($db,"SELECT suppliername FROM tbl_supplier WHERE status = 1");
							while($rs = mysqli_fetch_array($res)){
								echo '<option>'.$rs['suppliername'].'</option>';
							}
						?>
                        </datalist>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-xs-4 control-label">Address</label>
                      <div class="col-xs-8">
                        <input type="hidden" class="form-control" name="supplierid" id="supplierid" value="<?php echo $supplierid; ?>" readonly />
                        <input type="text" class="form-control input-sm" name="address1" id="address1" value="<?php echo $add1; ?>" placeholder="Address Line 1" readonly />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-xs-4 control-label">&nbsp;</label>
                      <div class="col-xs-8">
                        <input type="text" class="form-control input-sm" name="address2" id="address2" value="<?php echo $add2; ?>" placeholder="Address Line 2" readonly />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-xs-4 control-label">&nbsp;</label>
                      <div class="col-xs-8">
                        <input type="text" class="form-control input-sm" name="address3" id="address3" value="<?php echo $add3; ?>" placeholder="Address Line 3" readonly />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-xs-4 control-label">Contact Number</label>
                      <div class="col-xs-8">
                        <input type="text" class="form-control input-sm" name="contact1" id="contact1" value="<?php echo $contactno; ?>" placeholder="Contact Number" readonly />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xs-6">
				<div class="row">
                
                <input type="button" class="btn btn-info btn-sm" value="Enter Purchased Item details"  onClick="returnPurchase()" />
				</div>
				</div>
              </form>
              <br />
              <br />
              <br />
              <br />
              <br />
              <br />
              <br />
              <br />
              <br />
              <br />
              <br />
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
  <div class="modal fade" id="mdlPurchaseReturn" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <form class="form-horizontal" id="frmPurchaseReturnEntry">
			
            <div class="form-group">
				<label class="col-xs-1 control-label">Type</label>
              <div class="col-xs-2">
                <select class="form-control input-sm" name="petype" id="petype">
					<option>SELECT</option>
					<?php
						require_once("config.php");
						$res = mysqli_query($db,"SELECT distinct stocktype FROM tbl_productlist WHERE status = 1");
						while($rs = mysqli_fetch_array($res)){
							echo '<option>'.$rs['stocktype'].'</option>';
						}
					?>
				</select>
              </div>
              <label class="col-xs-1 control-label">Name</label>
              <div class="col-xs-4">
                <input type="text" class="form-control input-sm mand" name="peproductname" id="peproductname" placeholder="Product Name" list="lstProductName" onBlur="retBatchNoother()" />
                <datalist id="lstProductName">
                  <?php
						require_once("config.php");
						$res = mysqli_query($db,"SELECT productname FROM tbl_productlist WHERE status = 1 ORDER BY productname asc");
						while($rs = mysqli_fetch_array($res)){
							echo '<option>'.$rs['productname'].'</option>';
						}
					?>
                </datalist>
              </div>
             <label class="col-xs-1 control-label">Batch #</label>
              <div class="col-xs-2">

                <select class="form-control input-sm" name="batch" id="batch" onChange="returnExpiryothers()">
                  <option>SELECT</option>
                </select></div></div>

               	<div class="form-group">
					<label class="col-xs-1 control-label">Aval</label>
		                <div class="col-xs-2">
		                  <input type="text" readonly class="form-control input-sm" name="aval" id="aval"/>
		                </div>
	                <label class="col-xs-1 control-label">Expiry</label>
		                <div class="col-xs-2">
		                  <input type="text" readonly class="form-control input-sm" name="expiry" id="expiry"/>
		                </div>
	                <label class="col-xs-4 control-label">Unit Quantity</label>
		                <div class="col-xs-1">
		                	<input type="text" class="form-control input-sm" name="qty" id="qty" placeholder="0" />
		                </div>
	            	</div>
	                <div class="form-group">                
	              		<label class="col-xs-1 control-label">Unit Price</label>
		              	<div class="col-xs-2">
		                <input type="text" class="form-control input-sm number" name="uprice" id="uprice" placeholder="0" />
		              	</div>
	    			<label class="col-xs-1 control-label">Reason</label>
	    			<div class="col-xs-4">
	                <input type="text" class="form-control input-sm" name="reason" id="reason" />
                </div>
              
				<input type="button" class="btn btn-primary btn-sm col-xs-1 pull-right" style="margin-right:10px;" value="Add" onClick="addPurchaseReturnItems()" />
          </form>
        </div>
        <input type="hidden" class="form-control input-sm" name="preturnno" id="preturnno" value="" />
        <input type="hidden" class="form-control input-sm " name="product_id" id="product_id" value="" />
        <div class="modal-body" style="max-height:350px; overflow-y: auto;">
        	<form id="purchasereturnitems">
          <table class="table table-bordered table-striped" id="tbl-purchase-return-others">
            <thead>
	          <th>Name</th>
	          <th>Unit.Qty</th>
	          <th>Reason</th>
	          <th>Unit.Price</th>
	          <th>Action</th>
	        </thead>
            <tbody>
            </tbody>
          </table>
      </form>
        </div>
        <div class="modal-footer">
		    <a href="#" class="btn btn-warning btn-sm" onClick="javascript:$('#mdlPurchaseReturn').modal('hide');"><i class="ace-icon fa fa-arrow-left"></i> Close</a>
          	<button type="button" class="btn btn-primary btn-sm" onClick="savePurchaseReturnItems()">Print & Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- /.main-content -->
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
  <?php include('manage-bill/includebill.php'); ?>
<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='dist/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
<script src="bootstrap/3.3.1/js/bootstrap.min.js"></script>
<!-- page specific plugin scripts -->
<!-- ace scripts -->
<script src="dist/js/ace-elements.min.js"></script>
<script src="dist/js/ace.min.js"></script>
<script src="manage-return/manage-return.js"></script>
<script src="manage-bill/quick-bill.js"></script>
<!-- inline scripts related to this page -->
<link rel="stylesheet" type="text/css" href="datetimepicker/jquery.datetimepicker.css"/ >
</body>
<?php
  include('footer.php'); 
?>
<!-- Mirrored from responsiweb.com/themes/preview/ace/1.3.3/top-menu.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 May 2015 06:07:38 GMT -->
</html>
<?php echo $visible; ?>