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
<title>Unused Products</title>
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
 $currentPage = 'clearstock';
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
          <h1> Stocks <small> <i class="ace-icon fa fa-angle-double-right"></i>Disposed Stocks</small> </h1>
        </div>
        <!-- /.page-header -->
        <div class="row">
          <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="center"> <br />
              <form class="form-horizontal" id="frmBilling">
                 <br />
                </div>
                <br />
                <br />
                <div style="min-height: 350px; max-height: 450px; overflow-y: auto;">
                  <table id="tbl-list" class="table table-striped record_table">
                    <thead>
                    <tr>
  <th><input class="checkbox" type="checkbox" id="checkall" name="checkall[]" style="height:15px; width:15px;"/></th>
  <th style="text-align: center;">Product Name</th>
  <th style="text-align: center;">Batch</th>
  <th style="text-align: center;">Expiry</th>
  <th style="text-align: center;">Quantity</th>
  <th style="display:none;">id</th>
                    </tr>
                    </thead>
                    <tbody>
                <?php
                require_once("config.php");
                $sql = mysql_query("SELECT * FROM stockwastage WHERE status = 0 AND dispose_status=1 order by id asc");
                $i=0;
                while($r = mysql_fetch_array($sql)){
                $product_name = $r['product_name'];
                $expiry = $r['expiry'];
                $qty = $r['qty'];
                $batchno = $r['batchno'];
                $amount = $r['amount'];
                $id = $r['id'];                
                echo '<tr><td><input type="checkbox" class="checkbox" style="text-align:center;" id=checkind_'.$i++.'></td><td style="text-align:center">'.$product_name.'</td><td style="text-align:center">'.$r['batch'].'</td><td style="text-align:center">'.$expiry.'</td><td style="text-align:center">'.$qty.'</td><td style="display:none;">'.$id.'</td></tr>'; 
                }
                ?>
                    </tbody>
                  </table>
                </div>
                <div class="form-group">
                  <br>
       <button type="button" style="margin-right:10px;" class="btn btn-primary btn-sm pull-right" onClick="deleteunused()">Dispose</button>
                </div>
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
<!-- page specific plugin scripts -->
<!-- ace scripts -->
<script src="dist/js/ace-elements.min.js"></script>
<script src="dist/js/ace.min.js"></script>
<!-- inline scripts related to this page -->
<script src="manage-stock/stock-clearance.js"></script>
<!-- <script src="manage-bill/quick-bill.js"></script> -->
<script>
  $("#checkall").change(function(){
    var status = this.checked; 
    $('.checkbox').each(function(){ 
        this.checked = status;
    });
});
$('.checkbox').change(function(){  
    
    if(this.checked == false){ 
        $("#checkall")[0].checked = false; 
    }
    
    
    if ($('.checkbox:checked').length == $('.checkbox').length ){ 
        $("checkall")[0].checked = true; 
    }
});

$(document).ready(function() {
    $('.record_table tr').click(function(event) {
        if (event.target.type !== 'checkbox') {
            $(':checkbox', this).trigger('click');
        }
    });
});

function qtycheck(event) {
  if ((event.keyCode >= 48 && event.keyCode <= 57) || event.keyCode === 13) {
    return true;
  } else {
    return false;
  }

}
</script>
</body>
<!-- Mirrored from responsiweb.com/themes/preview/ace/1.3.3/top-menu.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 May 2015 06:07:38 GMT -->
</html>
