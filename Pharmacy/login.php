<?php
	session_start();
	if(isset($_SESSION['phar-username']) && (trim($_SESSION['phar-username']) != '')) {
		header("location:index.php");
		exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from responsiweb.com/themes/preview/ace/1.3.3/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 May 2015 06:08:15 GMT -->
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta charset="utf-8" />
<title>Login Page - Pharmacy</title>
<meta name="description" content="User login page" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<link rel="stylesheet" href="dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="dist/css/ace.min.css" />
<link rel="stylesheet" href="dist/css/ace-rtl.min.css" />
</head>
<body class="login-layout light-login">
<div class="main-container">
  <div class="main-content">
    <div class="row">
      <div class="col-sm-10 col-sm-offset-1">
        <div class="login-container">
          <div class="center">
            <h1> <img src="images/logoo.png" style="height: 100px; width: 350px;" /></h1>
          </div>
          <div class="space-6"></div>
          <div class="position-relative">
            <div id="login-box" class="login-box visible widget-box no-border">
              <div class="widget-body">
                <div class="widget-main">
                  <h4 class="header blue lighter bigger"> <i class="ace-icon fa fa-medkit green"></i> Please Enter Your Information </h4>
                  <div class="space-6"></div>
                  <form action="loginauth.php" method="post" onSubmit="return login()">
                    <fieldset>
                    <label class="block clearfix"> <span class="block input-icon input-icon-right">
                    <input type="text" class="form-control" placeholder="Username" name="username" id="username" />
                    <i class="ace-icon fa fa-user"></i> </span> </label>
                    <label class="block clearfix"> <span class="block input-icon input-icon-right">
                    <input type="password" class="form-control" placeholder="Password" name="password" id="password" />
                    <i class="ace-icon fa fa-lock"></i> </span> </label>
                    <div class="space"></div>
					<p style="color:#FF0000; text-align:center;"><?php if(isset($_SESSION['loginerror'])) echo $_SESSION['loginerror']; ?></p>
                    <div class="clearfix">
                      <button type="submit" class="width-35 pull-right btn btn-sm btn-primary" onClick="login()"> <i class="ace-icon fa fa-key"></i> <span class="bigger-110">Login</span> </button>
                    </div>
                    <div class="space-4"></div>
                    </fieldset>
                  </form>
                </div>
                <!-- /.widget-main -->
                <div class="toolbar clearfix">
                  <div style="width:100%; text-align:center;"> <a href="http://raagaamed.com" target="_blank" class="user-signup-link"> &copy; RaagaaMed </a> </div>
                </div>
              </div>
              <!-- /.widget-body -->
            </div>
            <!-- /.login-box -->
          </div>
          <!-- /.position-relative -->
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.main-content -->
</div>
<div class="modal fade" id="mdlerr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Login Error</h4> 
      </div>
      <div class="modal-body">
        <p id="loginerror"></p>
      </div>
    </div>
  </div>
</div>

<!-- /.main-container -->
<!-- basic scripts -->
<!--[if !IE]> -->
<script src="ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
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

  <script src="ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  
<!-- inline scripts related to this page -->
<script>
	function login(){
		var usr = $('#username').val(), pwd = $('#password').val();
		if($.trim(usr) == ''){
			$('#loginerror').html('Username Cannot Be Left Blank !');
			$('#mdlerr').modal('show');
			return false;
		}
		if($.trim(pwd) == ''){
			$('#loginerror').html('Password Cannot Be Left Blank !');
			$('#mdlerr').modal('show');
			return false;
		}
		return true;
	}
</script>
</body>
</html>
