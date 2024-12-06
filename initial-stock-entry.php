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
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta charset="utf-8" />
<title>Initial Stock Entry</title>
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
 $currenttab = 'Stocks';
 $currentPage = 'Initial_Stock_Entry';
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
          <h1> Stock <small> <i class="ace-icon fa fa-angle-double-right"></i> Initial Stock Entry </small> </h1>
        </div>
        <!-- /.page-header -->
        <div class="row">
          <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="center"> <br />
              <form class="form-horizontal" id="frmPurchaseEntry">
              <input type="hidden" class="form-control input-sm mand" name="flag" id="flag" value="" />
            <div class="form-group">
              <label class="col-xs-1 control-label">Name</label>
              <div class="col-xs-4">
                <input type="text" class="form-control input-sm mand" name="peproductname" id="peproductname" placeholder="Product Name" list="lstProductName" onBlur="returnProductInfo()" />
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
              <label class="col-xs-1 control-label">Qty</label>
              <div class="col-xs-1">
                <input type="text" class="form-control input-sm number mand" name="peqty" id="peqty" placeholder="0" />
              </div>
              <label class="col-xs-1 control-label">Batch #</label>
              <div class="col-xs-2">
                <input type="text" class="form-control input-sm mand" name="pebatch" id="pebatch" />
              </div>
            </div>
			<div class="form-group">
              <label class="col-xs-1 control-label">Expiry</label>
              <div class="col-xs-2">
                <input type="text" class="form-control input-sm mand" name="peexpiry" id="peexpiry" placeholder="MM/YYYY" maxlength="7" onBlur="validateExpiry()" />
              </div>
              <label class="col-xs-1 control-label">P. Price</label>
              <div class="col-xs-2">
                <input type="text" class="form-control input-sm number mand" name="pepprice" id="pepprice" placeholder="0" />
              </div>
              <label class="col-xs-1 control-label">MRP</label>
              <div class="col-xs-2">
                <input type="text" class="form-control input-sm number mand" name="pemrp" id="pemrp" placeholder="0" />
              </div>
              </div>
              <div class="form-group">
                <label class="col-xs-1 control-label">Tax type</label>
                <div class="col-xs-2">
                  <select id="taxtype" name="taxtype" class="form-control input-sm mand"  onChange="taxlabtype();">
                  <option value="0">--SELECT--</option>
                        <option value="1">GST</option>
                        <option value="2">IGST</option>
                        </select>
                </div>
                        <label id="gsttax" class="col-xs-1 control-label">GST (%)</label>
                <label id="igsttax" style="display:none;" class="col-xs-1 control-label mand">IGST (%)</label>
                <div class="col-xs-2">
                <input type="text" class="form-control input-sm number mand" name="pevatp" id="pevatp" placeholder="0" onBlur="validatevat()"/>
                </div>
               <label class="col-xs-1 control-label">TAX <i class="ace-icon fa fa-rupee"></i></label>
                <div class="col-xs-2">
                <input type="text" class="form-control input-sm number" readonly name="pevat" id="pevat" placeholder="0" />
                </div>
                </div>
                <div class="form-group" style="margin-left: 400px;margin-top: 40px">
              <input type="button" class="btn btn-primary btn-sm col-xs-1" value="Add" onClick="addPurchaseItems()" />
              </div>
              </div>
          </form>
              <br />
              <br />
			  <div  style="max-height:550px; overflow-y:auto">
             <table class="table table-bordered table-striped" id="tbl-purchase-entry">
            <thead>
              <th>Code</th>
              <th>Description</th>
              <th>Qty.</th>
              <th>Batch #</th>
              <th>Expiry</th>
              <th>P.Price </th>
              <th>MRP</th>
              <th>TAX %</th>
              <th>TAX Amount</th>
              <th></th>
              </thead>
            <tbody>
			<?php
				require_once("config.php");
				$res1 = mysqli_query($db,"SELECT * FROM tbl_purchaseitems WHERE status = 3");
				while($r = mysqli_fetch_array($res1)){
					$id = $r['productid'];
					$sql = "SELECT * FROM tbl_productlist WHERE id = '$id'";
					$res = mysqli_query($db,$sql);
					$rs = mysqli_fetch_array($res);
					echo "<tr><td>".$r['productid']."</td><td>".$rs['productname']."</td><td>".$r['qty']."</td><td>".$r['batchno']."</td><td>".$r['expirydate']."</td><td>".$r['pprice']."</td><td>".$r['mrp']."</td><td>".$r['tax_percentage']."</td><td>".$r['tax_amount']."</td><td><img src='images/edit.png' style='width: 24px; cursor: pointer;' onClick='editItemini(".$r['id'].")' />&nbsp;<img src='images/delete.png' style='width: 24px; cursor: pointer;' onClick='javascript:deleteItem(this,".$r['id'].")' /></td></tr>";
				}
			?>
            </tbody>
          </table>
		  </div>
              <br />
              <br />
			<button type="button" class="btn btn-primary btn-sm" onClick="saveInitialItems()">Save All</button>
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
  <?php include('manage-bill/includebill.php'); ?>
<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='dist/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
<script src="bootstrap/3.3.1/js/bootstrap.min.js"></script>
<!-- page specific plugin scripts -->
<!-- ace scripts -->
<script src="dist/js/ace-elements.min.js"></script>
<script src="dist/js/ace.min.js"></script>
<script src="manage-stock/manage-ise.js"></script>
<script src="manage-bill/quick-bill.js"></script>
<!-- inline scripts related to this page -->

</body>
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
function validatevat(){
  var x = $('#pepprice').val();
  if(x == ''){ $('#pepprice').focus(); return false; }
  var y = $('#pevatp').val();
  if(y == ''){ $('#pevatp').focus(); return false; }
  var z;
  z= x *(y/100);
  $('#pevat').val(truncator(z, 2));
  
}
function validatevatprice(){
  var x = $('#pepprice').val();
  if(x == ''){ $('#pepprice').focus(); return false; }
  
  var y = $('#pevatp').val();
  if(y!=''){
    var z;
    z= x *(y/100);
    
    $('#pevat').val(truncator(z, 2));
  }
}
function truncator(numToTruncate, intDecimalPlaces) {    
    var numPower = Math.pow(10, intDecimalPlaces); // "numPowerConverter" might be better
    return ~~(numToTruncate * numPower)/numPower;
}
</script>
<!-- Mirrored from responsiweb.com/themes/preview/ace/1.3.3/top-menu.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 May 2015 06:07:38 GMT -->
</html>