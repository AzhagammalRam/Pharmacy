<?php
	session_start();
	if(!isset($_SESSION['phar-username']) || (trim($_SESSION['phar-username']) == '')) {
		header("location:login.php");
		exit();
	}
	require_once("config.php");
	$cmd="SELECT * from test where status = 1";
	$result = mysqli_query($db,$cmd);
	$rs = mysqli_fetch_array($result);
	$client = $rs["client"];
	$software = $rs["product_name"];
	$key = $rs["product_key"];
	
	if($rs["register_date"])
		$expiry = date('d-m-Y',$rs["register_date"]);
	else
		$expiry = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta charset="utf-8" />
<title>Manage License</title>
<meta name="description" content="top menu &amp; navigation" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<link rel="stylesheet" href="dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="font/font-awesome.min.css" />
<!--<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />-->
<link rel="stylesheet" href="dist/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />


<style>
input[type="text"]{
	width: 100%;
}
.tdcenter{
	text-align:center;
}
</style>
<!--[if lte IE 9]>
			<link rel="stylesheet" href="dist/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
<!--[if lte IE 9]>
		  <link rel="stylesheet" href="dist/css/ace-ie.min.css" />
		<![endif]-->
<script src="dist/js/ace-extra.min.js"></script>
<script src="dist/js/shortcuts.js"></script>
<!--[if lte IE 8]>
		<script src="dist/js/html5shiv.min.js"></script>
		<script src="dist/js/respond.min.js"></script>
		<![endif]-->
<link rel="icon" href="favicon.ico" type="image/x-icon"/>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
</head>
<body class="no-skin">
<div id="navbar" class="navbar navbar-default navbar-collapseh-navbar">
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
        <li class="light-blue user-min"> <a id="usermenu" data-toggle="dropdown" href="#" class="dropdown-toggle"> <img class="nav-user-photo" src="return-user-img.php?id=<?php echo $_SESSION['phar-loginid']; ?>" alt="<?php echo $_SESSION['phar-username']; ?>" /> <span class="user-info"> <small>Welcome,</small> <?php echo $_SESSION['phar-username']; ?> </span> <i class="ace-icon fa fa-caret-down"></i> </a>
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
</div>
 <?php 
 $currenttab = 'License';
 
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
          <h1> Manage License </h1>
        </div>
        <!-- /.page-header -->
        <div class="row">
          <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="center"> <br />
               <div class="col-lg-2"> </div>
      <div class="col-lg-8">
        <div class="col-lg-9"> </div>
        <!-- <div class="col-lg-3"> <a href="#" data-toggle="modal" data-target="#mdlAddDepartment" class="btn btn-info btn-sm">Edit License</a> </div> -->
      </div>
	  <form method="post" id="frmregistration" name="frmregistration" class="form-horizontal" role="form">
        <div class="form-group">
		<label for="pname" class="col-lg-3 control-label">Client Name:</label>
          <div class="col-lg-4">
            <input type="text" name="client" value="<?php echo $client; ?>" readonly="readonly" tabindex="1" class="form-control" id="client" >
          </div>
		  </div><div class="form-group">
          <label for="pname" class="col-lg-3 control-label">Product Name:</label>
          <div class="col-lg-4">
            <input type="text" name="pname" value="<?php echo $software; ?>" readonly="readonly" tabindex="1" class="form-control" id="pname" >
          </div>
          
        </div>
        <div class="form-group">
          <label for="pkey" class="col-lg-3 control-label">Product Key:</label>
          
          <div class="col-lg-4">
            <input type="text" readonly="readonly" value="<?php echo $key; ?>" class="form-control" tabindex="2" id="pkey" name="pkey">
          </div>
                </div>
        <div class="form-group">
          <label for="valid" class="col-lg-3 control-label">Expired Date:</label>
          <div class="col-lg-4">
            <input type="text" readonly="readonly" value="<?php echo $expiry; ?>" class="form-control" tabindex="3" id="valid" name="valid">
          </div>
        </div>
      </form>
	  <div class="modal fade" id="mdlAddDepartment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New Product Key</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" name="addDept" id="addDept" role="form">
         
		  <div class="form-group">
            <label for="pkey" class="col-lg-4 control-label">Product Key:</label>
            <div class="col-lg-5">
              <input type="text" class="form-control" name="prodkey" id="prodkey" onKeyUp="validatekey(event)" placeholder="XXXXX-XXXXX-XXXXX-XXXXX" maxlength="23" />
            </div>
          </div>
        </form>
        <div id="NewDeptMessage">
		<?php
		$connected = @fsockopen("www.raagaamed.com", 80); 
    if ($connected){
        fclose($connected);
    }else{
        echo '<center><font color="red">Please Check your Internet Connection & Try Again <br />(Press F5 to refresh)</font></center>';
    }
		?>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" onClick="addLicense()">Register</button>
      </div>
    </div>
  </div>
</div>
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
<script src="manage-bill/quick-bill.js"></script>
<!-- inline scripts related to this page -->
<script src="userjs/jquery.jsonp-2.4.0.js"></script>
<?php include('manage-bill/includebill.php'); ?>
<script>
	function validatekey(event){
		var key = event.keyCode;
		var rowCount = $('#prodkey').val().length;
		if(key!==8){
		if(rowCount == 5 || rowCount == 11 || rowCount == 17){
			$('#prodkey').val( $('#prodkey').val() + "-");
			}
		}
	}
	
	function addLicense(){
		var serial=$('#prodkey').val();
		if(serial==''){
			$('#NewDeptMessage').html('<font color=\"#FF0000\">Required Fields cannot be left blank</font>');
			return false;
		}

		var dataUrl='http://raagaamed.com//register-key.php?check=?';
		$.ajax({
			url:dataUrl,
			dataType: 'jsonp',
			data:{serial:serial,},
			success:function(data){
			if(data.error1 == '' && data.error2 == ''){
				var msg = $.trim(data.result);
				var x = msg.split("~");
				$("#pname").val(x[1]);
				$("#pkey").val(x[3]);
				$("#valid").val(x[2]);
				$("#client").val(x[0]);		
				$.ajax({
					type: 'post',
					url: 'userjs/update.php',
					data: {
						pname: $("#pname").val(),
						pkey: $("#pkey").val(),
						valid: $("#valid").val(),
						client: $("#client").val(),
					},
					success: function(msg) {
						alert(msg);
					}
				});
				$('#mdlAddDepartment').modal('hide');
			}
			else if(data.error1 != ''){
				$('#NewDeptMessage').html('<font color=\"#FF0000\">'+data.error1+'</font>');
			}
			else if(data.error2 != ''){
				$('#NewDeptMessage').html('<font color=\"#FF0000\">'+data.error2+'</font>');
			}
		},
		error:function(XMLHttpRequest, textStatus, errorThrown){
			alert(errorThrown);
		}
	});
}
</script>
</body>
<!-- Mirrored from responsiweb.com/themes/preview/ace/1.3.3/top-menu.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 May 2015 06:07:38 GMT -->
</html>
