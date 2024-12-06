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
<title>Stock-wastage</title>
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
 $currenttab = 'Stocks';
 $currentPage = 'stock_wastage';
 include('navigate.php'); ?>
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
    <h1> Stocks <small> <i class="ace-icon fa fa-angle-double-right"></i> Stock Clearance</small> </h1>
    </div>
<div class="row">
<div class="col-xs-12">
<div class="center"> <br />
<form class="form-horizontal" id="frmclearance">
<div class="form-group">
<label class="col-xs-2 control-label">Product Name</label>
<div class="col-xs-3">
<input type="text" class="form-control input-sm" name="pname" id="pname" onChange="retBatchNo()" placeholder="Product Name"  list="lstProducts" />
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
        <div class="form-group">
        <label class="col-xs-2 control-label">Batch #</label>
        <div class="col-xs-2">
        <select class="form-control input-sm" name="batch" id="batch" onChange="retExpiry()">
        <option>SELECT</option>
        </select>
        </div>
        <label class="col-xs-2 control-label">Expiry</label>
        <div class="col-xs-2">
        <input type="text" class="form-control input-sm" disabled name="expiry" id="expiry" placeholder="MM/YYYY" maxlength="7" onBlur="validateExpiry()" >
        <!-- <select class="form-control input-sm" name="expiry" id="expiry"  onChange="returnQty()">
        <option>SELECT</option>
        </select> -->
        </div>
        </div>
          <div class="form-group">
          <label class="col-xs-2 control-label">Quantity</label>
          <div class="col-xs-2">
          <input type="text" class="form-control input-sm mand number" name="qty" id="qty" placeholder="0" onBlur="validateQty()">
          </div>
				  </div>
          <div class="form-group">
          <label class="col-xs-2 control-label">Reason</label>
          <div class="col-xs-6">
          <textarea class="form-control input-sm mand" name="reason" id="reason"></textarea>
          </div>
          <input type="button" class="btn btn-sm btn-info col-xs-2" value="Add" onClick="addstockclearance()" />

          </div>

          <br />
          <br />
                    <table id="tbl-stockclear-rpt" class="table table-fixed">
<thead>
  <tr>

    <th style="text-align: center;">Product Name</th>
    <th style="text-align: center;">Batch</th>
    <th style="text-align: center;">Expiry</th>
    <th style="text-align: center;">Quantity</th>
    <th style="text-align: center;">Action</th>
  </tr>
</thead>
<tbody id="results">

</tbody>
</table>
<center><input type="button" style="margin-top:50px;float: none;" class="btn btn-sm btn-info col-xs-2" value="Save all" onClick="saveallwastage()" /></center>
          </form>
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

<script src="libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
			window.jQuery || document.write("<script src='dist/js/jquery.min.js'>"+"<"+"/script>");
		</script>
<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='dist/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
<script src="bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="dist/js/ace-elements.min.js"></script>
<script src="dist/js/ace.min.js"></script>
<script src="manage-stock/stock-clearance.js"></script>
<script>
$(document).ready(function() {
    //called when key is pressed in textbox
    $("#expiry").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 47 &&  (e.which < 48 || e.which > 57) ) {
          return false;
        }
    });
    $("#expiry").keyup(function(){
    if ($(this).val().length == 2){
      $(this).val($(this).val() + "/");
    }
  });

     $("#qty").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 47 &&  (e.which < 48 || e.which > 57) ) {
          return false;
        }
    });

});

</script>

<script>
</script>
</body>
<!-- Mirrored from responsiweb.com/themes/preview/ace/1.3.3/top-menu.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 May 2015 06:07:38 GMT -->
</html>
