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
	$res = mysqli_query($db,"SELECT * FROM tbl_purchase WHERE status = 2");
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
		$add1 = $r1['addressline1'];		$add2 = $r1['addressline2'];		$add3 = $r1['addressline3'];
		$contactno = $r1['contactno1'];
		$credit = $r1['credit'];
		$res2 = mysqli_query($db,"SELECT * FROM tbl_payment WHERE id = $payment");
		$r2 = mysqli_fetch_array($res2);
		$creditdate = implode("/", array_reverse(explode("-",$r2['creditdate'])));
		$paymentdate = implode("/", array_reverse(explode("-",$r2['paymentdate'])));
		$payable = $r2['payable'];
		$paymentamt = $r2['paymentamt'];
		
		$readonly = "readonly";
		$disabled = 'disabled="disabled"';
		$enabled = '';
	}else{
		$purchaseid = '';	$maufacturerid = '';		$invoiceno = '';
		$invoicedate = date('d/m/Y');	$invoiceamt = '';			$invoicetype = '';
		$payment = '';		$add1 = '';		$add2 = '';	$add3 = '';
		$contactno = '';	$creditdate = date('d/m/Y');			$paymentdate = date('d/m/Y');
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
<title>Purchase Entry</title>
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
    <div class="navbar-header pull-left"> <a href="#" class="navbar-brand"> <small> <img height="80" width="130" src="images/logo1.png" /> Pharmacy </small> </a>
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
 $currentPage = 'Purchase_Entry';
 include('navigate.php'); ?>
<!--   <div class="modal fade" tabindex="-1" role="dialog" id="mdlNewQuickBill">
    <div class="modal-dialog modal-xs">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">New Bill</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal">
		  	<div class="form-group">
              <label class="col-xs-3 control-label">UHID / Phno</label>
              <div class="col-xs-8">
                <input type="text" class="form-control input-sm mand" name="qbcontactnumber" id="qbcontactnumber" placeholder="UHID/Phone Number" onBlur="getdetails($(this))">
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-3 control-label">Patient Name</label>
              <div class="col-xs-8">
                <input type="text" class="form-control input-sm mand" name="qbpatientname" id="qbpatientname" placeholder="Patient Name">
              </div>
            </div>
		
            <div class="form-group">
			<?php require_once("config.php");
			$query=mysqli_query($db,"select id,doctorname from tbl_doctor");
			?>
              <label class="col-xs-3 control-label">Doctor Name</label>
              <div class="col-xs-8">
			  <select id='qbdrname' onChange="checkdoctor($(this))"> 
			  <option value="0">Select</option>
			<?php
    while($q=mysqli_fetch_array($query)) { 
    $docname=$q["doctorname"];
    echo "<option value='$docname' >$docname</option>";
  } 
        ?>
				</select>
              </div>
            </div>
			 <div class="form-group">
			 <label class="col-xs-3 control-label"></label>
			 <div class="col-xs-8">
			 <div id="otherdoctor">
			<input type="text" class="form-control input-sm" name="qbdrname1" id="qbdrname1" placeholder="Doctor Name">
			</div>
			</div>
			 </div>
          </form>
		 <script>
		 function checkdoctor(x) {
		 var doctor=x.val();
		 if(doctor==0)
		 $("#otherdoctor").show(); 
		
		 else {
		 $("#qbdrname1").val(""); 
		 $("#otherdoctor").hide();
		 }
		// alert(doctor);
		 }
		 </script>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-sm" onClick="createNewBill()">Create Bill</button>
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div> -->
    <!-- /.nav-list -->
    <script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
  </div>
  <div class="main-content">
    <div class="main-content-inner">
      <div class="page-content">
        <div class="page-header">
          <h1> Purchase <small> <i class="ace-icon fa fa-angle-double-right"></i> Purchase Entry </small> </h1>
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
                        <input type="hidden" class="form-control"  name="purchaseid" id="purchaseid" readonly value="<?php echo $purchaseid; ?>" />
                        <input type="text" class="form-control" tabindex="1" name="supplier" id="supplier"  placeholder="Supplier Name" list="lstSupplier" onBlur="supplierDetails()">
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
                <div class="form-group">
                  <label class="col-xs-3 control-label">Invoice Date</label>
                  <div class="col-xs-3">
                    <input type="text" class="form-control input-sm" tabindex="2" name="invoicedate" id="invoicedate" <?php echo $readonly; ?> placeholder="DD/MM/YYYY" value="<?php echo $invoicedate; ?>">
                  </div>
                  <label class="col-xs-3 control-label">Invoice #</label>
                  <div class="col-xs-3">
                    <input type="text" class="form-control input-sm" tabindex="3" onBlur="checkinvoiceno()" name="invoiceno" id="invoiceno" <?php echo $readonly; ?> placeholder="" value="<?php echo $invoiceno; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-xs-3 control-label">Invoice <i class="menu-icon fa fa-inr"></i></label>
                  <div class="col-xs-3">
                    <input type="text" class="form-control input-sm number" tabindex="4" name="invoiceamt" id="invoiceamt" <?php echo $readonly; ?> placeholder="" value="<?php echo $invoiceamt; ?>">
                  </div>
                   <label class="col-xs-3 control-label">Previous Credit</label>
                  <div class="col-xs-3">
   					<input type="text" class="form-control input-sm" name="creditval" tabindex="5" id="creditval" placeholder="" value="<?php echo $credit; ?>">
   				
   					<input type="hidden" id="purchase_val" placeholder="" value="<?php echo $credit1; ?>">
                  </div>
                  </div>
                  <div class="form-group">
                  <label class="col-xs-3 control-label">Type</label>
                  <div class="col-xs-3">
                    <select class="form-control input-sm" name="invoicetype" tabindex="6" id="invoicetype" <?php echo $readonly; ?>>
                      <option value="0">SELECT</option>
                      <option value="CASH" <?php echo $cash; ?>>CASH</option>
                      <option value="CR" <?php echo $cr; ?>>CREDIT</option>
                    </select>
                  </div>
                </div>
                <div id="divcash" style="display:none;">
                  <div class="form-group">
                    <label class="col-xs-3 control-label">Payment Date</label>
                    <div class="col-xs-3">
                      <input type="text" class="form-control input-sm" tabindex="7" name="paymentdate" id="paymentdate" <?php echo $readonly; ?> placeholder="DD/MM/YYYY" value="<?php echo $paymentdate; ?>">
                    </div>
                    <label class="col-xs-3 control-label">Paid Amount <i class="menu-icon fa fa-inr"></i></label>
                    <div class="col-xs-3">
                      <input type="text" class="form-control input-sm number" tabindex="8" name="paymentamt" id="paymentamt" <?php echo $readonly; ?> placeholder="" value="<?php echo $paymentamt; ?>">
                    </div>
                  </div>
				 
				  <div id="showme" style="display:none;">
				  <div class="form-group">
                    <label class="col-xs-3 control-label">Pending Amount <i class="menu-icon fa fa-inr"></i></label>
                    <div class="col-xs-3">
                      <input type="text" class="form-control input-sm number" name="penamt" id="penamt" <?php echo $readonly; ?> placeholder="" value="<?php echo $penamt; ?>">
                    </div>
	
					<label class="col-xs-3 control-label">Due Date</label>
                    <div class="col-xs-3">
                      <input type="text" class="form-control input-sm" name="dued" id="dued" <?php echo $readonly; ?> placeholder="DD/MM/YYYY" value="<?php echo $dued; ?>">
                    </div>
                  </div>
				 </div>
				 
                  <div class="form-group">
                    <label class="col-xs-3 control-label">Paid To</label>
                    <div class="col-xs-9">
                      <input type="text" class="form-control input-sm" tabindex="9" name="payable" id="payable" placeholder="" <?php echo $readonly; ?> value="<?php echo $payable; ?>">
                    </div>
                  </div>
                </div>
                <div id="divcr" style="display:none;">
                  <div class="form-group">
                    <label class="col-xs-3 control-label">Credit Date</label>
                    <div class="col-xs-3">
                      <input type="text" class="form-control input-sm" name="creditdate" tabindex="11" id="creditdate" <?php echo $readonly; ?> placeholder="DD/MM/YYYY" value="<?php echo $creditdate; ?>">
                    </div>
                  </div>
                </div>
                <input type="button" class="btn btn-info btn-sm" tabindex="12" value="Enter Purchased Item details" id="savepurchaseid" <?php echo $disabled; ?> onClick="savePurchase()" />
                <input type="button" class="btn btn-danger btn-sm" value="Delete" <?php echo $enabled; ?> onClick="deletePurchase()" />
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
  <div class="modal fade" id="mdlPurchase" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <form class="form-horizontal" id="frmPurchaseEntry">
			<input type="hidden" class="form-control input-sm mand" name="peinvoiceno" id="peinvoiceno" value="<?php echo $purchaseid; ?>" readonly />
            <input type="hidden" class="form-control input-sm mand" name="pepurchaseno" id="pepurchaseno" value="<?php echo $purchaseitemid; ?>" readonly />
            <div class="form-group">
				<!-- <label class="col-xs-1 control-label">Type</label>
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
              </div> -->
              <label class="col-xs-1 control-label">Name</label>
              <div class="col-xs-4">
                <input type="text" class="form-control input-sm mand" tabindex="12" name="peproductname" id="peproductname" placeholder="Product Name" list="lstProductName" onBlur="returnProductInfo()" />
                <datalist id="lstProductName">
                  <?php
						require_once("config.php");
						$res = mysqli_query($db,"SELECT productname FROM tbl_productlist WHERE status = 1");
						while($rs = mysqli_fetch_array($res)){
							echo '<option>'.$rs['productname'].'</option>';
						}
					?>
                </datalist>
              </div>
              
              <label class="col-xs-1 control-label">U.Desc</label>
              <div class="col-xs-1">
                <input type="text" class="form-control input-sm number" name="unitdesc" id="unitdesc" placeholder="0" disabled />
              </div>
              
              <label class="col-xs-1 control-label">Qty</label>
              <div class="col-xs-1">
                <input type="text" class="form-control input-sm number mand" tabindex="13" name="peqty" id="peqty" placeholder="0" onBlur="getAval()" />
              </div>
              
              <label class="col-xs-1 control-label">Free</label>
              <div class="col-xs-1">
                <input type="text" class="form-control input-sm number" name="pefree" tabindex="14" id="pefree" placeholder="0" value="0" onBlur="getAval()" />
              </div>
            </div>
			<div class="form-group">
       		
              
                <label class="col-xs-1 control-label">Avail</label>
              <div class="col-xs-2">
                <input type="text" class="form-control input-sm number" tabindex="15" name="avail" id="totaval" placeholder="0" value="0" />
              </div>
              
			<label class="col-xs-1 control-label">Batch #</label>
              <div class="col-xs-2">
                <input type="text" class="form-control input-sm mand" tabindex="16" name="pebatch" id="pebatch" />
              </div>
              <label class="col-xs-1 control-label">Expiry</label>
              <div class="col-xs-2">
                <input type="text" class="form-control input-sm mand" tabindex="17" name="peexpiry" id="peexpiry" placeholder="MM/YYYY" maxlength="7" onBlur="validateExpiry()" />
              </div>
              
              <label class="col-xs-1 control-label">P. Price</label>
              <div class="col-xs-2">
                <input type="text" class="form-control input-sm number mand" tabindex="18" name="pepprice" id="pepprice" placeholder="0" onBlur="returnpreviousprice()"/>
              </div>

              </div>
			  <div class="form-group">
        	
              <label class="col-xs-1 control-label">MRP</label>
              <div class="col-xs-2">
                <input type="text" class="form-control input-sm number mand" tabindex="19" name="pemrp" id="pemrp"/>
              </div>
              <label class="col-xs-1 control-label">Tax type</label>
			  <div class="col-xs-2">
			  	<select id="taxtype" name="taxtype" tabindex="20" class="form-control input-sm mand"  onChange="taxlabtype();">
			  	<option value="1">--SELECT--</option>
                <option value="1">GST</option>
                <option value="2">IGST</option>
                </select>
			  </div>
                <label id="gsttax" class="col-xs-1 control-label">GST (%)</label>
			  	<label id="igsttax" style="display:none;" class="col-xs-1 control-label mand">IGST (%)</label>
			  <div class="col-xs-2">
				<input type="text" class="form-control input-sm number mand" tabindex="21" name="pevatp" id="pevatp" placeholder="0" onBlur="validatevat()"/>
			  </div>
			  
				<label class="col-xs-1 control-label">Tax Amount<i class="ace-icon fa fa-rupee"></i></label>
			  <div class="col-xs-2">
				<input type="text" class="form-control input-sm number" readonly name="pevat" id="pevat" placeholder="0" />
			  </div>
			

				  <input type="button" class="btn btn-primary btn-sm col-xs-1 pull-right" tabindex="22" style="margin-right:10px; margin-top:10px;" value="Add" onClick="addPurchaseItems()" /></div>
          </form>
        </div>
        <div class="modal-body" style="max-height:350px; overflow-y: auto;">
          <table class="table table-bordered table-striped" id="tbl-purchase-entry">
            <thead>
            <th>Code</th>
            <th>Type</th>
              <th>Description</th>
              <th>Qty.</th>
              <th>Free</th>
              <th>Batch #</th>
              <th>Expiry</th>
              <th>P.Price</th>
              <th>MRP</th>
              <th>TAX %</th>
              <th>TAX Amount</th>
              <th>Net</th>
              <th></th>
              </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
		   <label class="col-xs-1 control-label">Invoice Amount</label> <label class="col-xs-1 control-label"><?php echo $invoiceamt; ?></label>
		   <label class="col-xs-1 control-label">Purchase Amount</label> <label class="col-xs-1 control-label" id="lblpamount"><?php echo $invoiceamt; ?></label>
		   <label class="col-xs-1 control-label">Previous Amount</label> <label class="col-xs-1 control-label" ><?php echo $credited_amount; ?>
		   <input type='hidden' id='camount' value="<?php echo $credited_amount; ?>" /></label>
		    <label class="col-xs-2 control-label" style = "width: 9.666%;">Round off</label> <input type="text" id="round_off" name="round_off" class="col-xs-1 number mand" value="<?php echo $invoiceamt; ?>" readonly />
       <label style="display:none" class="col-xs-2 control-label" style = "width: 9.666%;" >Discount</label> <input style="display:none" type="text" id="lblpadj" name="lblpadj" class="col-xs-1 number mand" value="0"  onBlur="adj()"/>
          <a href="#" class="btn btn-warning btn-sm" onClick="javascript:$('#mdlPurchase').modal('hide');"><i class="ace-icon fa fa-arrow-left"></i> Cancel</a>
          <button type="button" class="btn btn-primary btn-sm" onClick="savePurchaseItems()">Save All</button>
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
<script src="libs/jquery/2.1.1/jquery.min.js"></script>
<script>
		$('#paymentamt').blur(function(){
		if(!$.isNumeric($('#paymentamt').val())){
			alert('Invalid Amount');
			$('#paymentamt').val('');
		}else
			if($('#paymentamt').val()!=$('#invoiceamt').val()){
			alert('Paid amount should not be Greater or Lesser than invoice amount');
			$('#paymentamt').val('');
		}
		// else{
		// var tolamm = parseFloat($('#invoiceamt').val()) - parseFloat($('#paymentamt').val());
		// 	$('#penamt').val(tolamm.toFixed(2));
		// }
		if($('#paymentamt').val()==$('#invoiceamt').val())
		$('#showme').hide();
	});	
</script>

<script>
$(document).ready(function() {
    //called when key is pressed in textbox
    $("#peexpiry").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 47 &&  (e.which < 48 || e.which > 57) ) {
          return false;
        }
    });
    $("#peexpiry").keyup(function(){
    if ($(this).val().length == 2){
      $(this).val($(this).val() + "/");
    }
  });


});

</script>

<script type="text/javascript">
function checkinvoiceno(invoiceno,supplierid){
    //alert("came");
var invoiceno=$("#invoiceno").val();
var supplierid=$("#supplierid").val();
$.ajax({
    type:'post',
        url:'invoice.php', 
        data:{invoiceno: invoiceno,supplierid:supplierid},
        success:function(msg){
        //alert(msg)
        	if(msg=="Sucess")
        	{
        		 $("#savepurchaseid").attr("disabled",true);
        	
        alert("Invoice already exist");     
        }else{
$("#savepurchaseid").attr("disabled",false)
        }
    }
 });
}

function taxlabtype()
{
	var taxtype=$("#taxtype").val();
	if(taxtype==1)
	{
		$("#gsttax").show();
		$("#igsttax").hide();
	}else if(taxtype==2)
	{
		$("#igsttax").show();
		$("#gsttax").hide();
	}
}

</script>
					
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
<script src="manage-purchase/manage-purchase.js"></script>
<script src="manage-bill/quick-bill.js"></script>
<!-- inline scripts related to this page -->
<link rel="stylesheet" type="text/css" href="datetimepicker/jquery.datetimepicker.css"/ >
<script src="datetimepicker/jquery.datetimepicker.js"></script>
<script>
	$(document).ready(function () { 
		$('#invoicedate,#paymentdate,#creditdate,#dued').datetimepicker({
			lang:'en',
			timepicker:false,
			format:'d/m/Y',
      }); 
	});
</script>
<style type="text/css">
.col-xs-1 {
    width: 7.333% !important;
}
</style>
</body>
<!-- Mirrored from responsiweb.com/themes/preview/ace/1.3.3/top-menu.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 May 2015 06:07:38 GMT -->
</html>
<?php echo $visible; ?>