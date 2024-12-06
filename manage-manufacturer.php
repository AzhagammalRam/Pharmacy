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
<title>Manage Manufacturer</title>
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
 $currenttab = 'Master_Entry';
 $currentPage = 'Manage_Manufacturers';
 include('navigate.php'); ?>
 
    <script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
  </div>
  <div class="main-content">
    <div class="main-content-inner">
      <div class="main-content-inner">
        <div class="page-content">
          <div class="page-header">
            <h1> Master Entry <small> <i class="ace-icon fa fa-angle-double-right"></i> Manage Manufacturers </small> </h1>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="row">
                <div class="col-xs-12">
                  <div class="table-header"> List of Manufacturers 
				  <a data-toggle="modal" data-target="#modal-new-manufacturer" class="pull-right" style="margin-right:15px;color:#FFFFFF;text-decoration:none;cursor:pointer;"><i class="ace-icon fa fa-user"></i>  Add New Manufacturer </a>				  </div>
                  <div>
                    <table id="table-user-list" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th class="center">SNo</th>
                          <th>Manufacturer</th>
                          <th>Contact #</th>
                          <th>Email</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div id="modal-view" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header no-padding">
                      <div class="table-header">Manufacturer Information</div>
                    </div>
                    <div class="modal-body no-padding">
                      <div class="col-xs-12">
                        <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
                          <tr>
                            <th scope="row" style="vertical-align:middle;">Name</th>
                            <td colspan="3" id="vmanufacturer"></td>
                          </tr>
                          <tr>
                            <th rowspan="4" scope="row" style="vertical-align:middle;">Address</th></tr>
                            <tr><td colspan="3" id="vaddressline1"></td></tr>
							<tr><td colspan="3" id="vaddressline2"></td></tr>
							<tr><td colspan="3" id="vaddressline3"></td></tr>
						  <tr>
							<th scope="row" style="vertical-align:middle;">City</th>
                            <td id="vcity"></td>
                            <th scope="row" style="vertical-align:middle;">State</th>
                            <td id="vstate"></td>
                          </tr>
                          <tr>
                            <th scope="row" style="vertical-align:middle;">Country</th>
                            <td id="vcountry"></td>
							<th scope="row" style="vertical-align:middle;">Pincode</th>
                            <td id="vpincode"></td>
                          </tr>
						  <tr>
                            <th scope="row" style="vertical-align:middle;">Contact #</th>
                            <td id="vcontact1"></td>
							<th scope="row" style="vertical-align:middle;">Contact #</th>
                            <td id="vcontact2"></td>
                          </tr>
						  <tr>
                            <th scope="row" style="vertical-align:middle;">Email</th>
                            <td colspan="3" id="vemail"></td>
                          </tr>
						  <tr>
                            <th scope="row" style="vertical-align:middle;">Status</th>
                            <td colspan="3" id="vstatus"></td>
                          </tr>
                        </table>
						<br />
					  </div>
                    </div>
                    <div class="modal-footer no-margin-top">
                      <button class="btn btn-sm btn-info pull-right" data-dismiss="modal"> <i class="ace-icon fa fa-times"></i> Close </button>
                    </div>
                  </div>
                </div>
              </div>
			  <div id="modal-update" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header no-padding">
                      <div class="table-header">Update Manufacturer Information</div>
                    </div>
					<div class="modal-body no-padding">
                      <div class="col-xs-12">
					  	<form id="updateManufacturer">
                        <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
                          <tr>
                            <th scope="row" style="vertical-align:middle;">Name</th>
                            <td colspan="3"><input type="hidden" id="DBid" name="DBid"><input type="text" id="umanufacturer" name="umanufacturer" placeholder="Manufacturer Name"></td>
                          </tr>
                          <tr>
                            <th rowspan="4" scope="row" style="vertical-align:middle;">Address</th></tr>
                            <tr><td colspan="3"><input type="text" id="uaddressline1" name="uaddressline1" placeholder="Address Line 1"></td></tr>
							<tr><td colspan="3"><input type="text" id="uaddressline2" name="uaddressline2" placeholder="Address Line 2"></td></tr>
							<tr><td colspan="3"><input type="text" id="uaddressline3" name="uaddressline3" placeholder="Address Line 3"></td></tr>
						  <tr>
							<th scope="row" style="vertical-align:middle;">City</th>
                            <td><input type="text" id="ucity" name="ucity" placeholder="City"></td>
                            <th scope="row" style="vertical-align:middle;">State</th>
                            <td><input type="text" id="ustate" name="ustate" placeholder="State"></td>
                          </tr>
                          <tr>
                            <th scope="row" style="vertical-align:middle;">Country</th>
                            <td><input type="text" id="ucountry" name="ucountry" placeholder="Country"></td>
							<th scope="row" style="vertical-align:middle;">Pincode</th>
                            <td><input type="text" id="upincode" name="upincode" pattern="[0-9]{6}" maxlength="6" placeholder="Pincode"></td>
                          </tr>
						  <tr>
                            <th scope="row" style="vertical-align:middle;">Contact #</th>
                            <td><input type="text" id="ucontact1" name="ucontact1" maxlength="10" placeholder="Contact # 1"></td>
							<th scope="row" style="vertical-align:middle;">Contact #</th>
                            <td><input type="text" id="ucontact2" name="ucontact2" maxlength="10" placeholder="Contact # 2"></td>
                          </tr>
						  <tr>
                            <th scope="row" style="vertical-align:middle;">Email</th>
                            <td colspan="3"><input type="text" id="uemail" name="uemail" placeholder="Email address"></td>
                          </tr>
                        </table>
						</form>
						<br />
					  </div>
                    </div>
                    <div class="modal-footer no-margin-top">
					  <button class="btn btn-sm btn-info pull-right" data-dismiss="modal"> <i class="ace-icon fa fa-times"></i> Close </button>
                      <input type="button" class="btn btn-sm btn-primary pull-right" value="Update" onClick="updateManufacturer()" style="margin-right:10px;"/>
                    </div>
                  </div>
                </div>
              </div>
			  <div id="modal-new-manufacturer" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header no-padding">
                      <div class="table-header">New Manufacturer Information</div>
                    </div>
                    <div class="modal-body no-padding">
                      <div class="col-xs-12">
					  	<form id="newManufacturer">
                        <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
                          <tr>
                            <th scope="row" style="vertical-align:middle;">Name</th>
                            <td colspan="3"><input type="text" id="manufacturer" name="manufacturer" placeholder="Manufacturer Name"></td>
                          </tr>
                          <tr>
                            <th rowspan="4" scope="row" style="vertical-align:middle;">Address</th></tr>
                            <tr><td colspan="3"><input type="text" id="addressline1" name="addressline1" placeholder="Address Line 1"></td></tr>
							<tr><td colspan="3"><input type="text" id="addressline2" name="addressline2" placeholder="Address Line 2"></td></tr>
							<tr><td colspan="3"><input type="text" id="addressline3" name="addressline3" placeholder="Address Line 3"></td></tr>
						  <tr>
							<th scope="row" style="vertical-align:middle;">City</th>
                            <td><input type="text" id="city" name="city" placeholder="City"></td>
                            <th scope="row" style="vertical-align:middle;">State</th>
                            <td><input type="text" id="state" name="state" placeholder="State"></td>
                          </tr>
                          <tr>
                            <th scope="row" style="vertical-align:middle;">Country</th>
                            <td><input type="text" id="country" name="country" placeholder="Country"></td>
							<th scope="row" style="vertical-align:middle;">Pincode</th>
                            <td><input type="text" id="pincode" name="pincode" pattern="[0-9]{6}" maxlength="6" placeholder="Pincode"></td>
                          </tr>
						  <tr>
                            <th scope="row" style="vertical-align:middle;">Contact #</th>
                            <td><input type="text" id="contact1" name="contact1" maxlength="10" placeholder="Contact # 1"></td>
							<th scope="row" style="vertical-align:middle;">Contact #</th>
                            <td><input type="text" id="contact2" name="contact2" maxlength="10" placeholder="Contact # 2"></td>
                          </tr>
						  <tr>
                            <th scope="row" style="vertical-align:middle;">Email</th>
                            <td colspan="3"><input type="text" id="email" name="email" placeholder="Email address"></td>
                          </tr>
                        </table>
						</form>
						<br />
					  </div>
                    </div>
                    <div class="modal-footer no-margin-top">
					  <button class="btn btn-sm btn-info pull-right" data-dismiss="modal"> <i class="ace-icon fa fa-times"></i> Close </button>
                      <input type="button" class="btn btn-sm btn-primary pull-right" value="Save" onClick="newManufacturer()" style="margin-right:10px;"/>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
 <?php
  include('footer.php'); 
  ?>
  <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"> <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i> </a> </div>
<script src="ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!--[if IE]>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<![endif]-->
<script type="text/javascript">
			window.jQuery || document.write("<script src='dist/js/jquery.min.js'>"+"<"+"/script>");
		</script>
<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='dist/js/jquery1x.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
 <?php include('manage-bill/includebill.php'); ?>
<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='dist/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
<script src="netdna.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="dist/js/dataTables/jquery.dataTables.min.js"></script>
<script src="dist/js/dataTables/jquery.dataTables.bootstrap.min.js"></script>
<script src="dist/js/dataTables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script src="dist/js/dataTables/extensions/ColVis/js/dataTables.colVis.min.js"></script>
<script src="dist/js/ace-elements.min.js"></script>
<script src="dist/js/ace.min.js"></script>
<script src="manage-manufacturer/manage-manufacturer.js"></script>
<script src="manage-bill/quick-bill.js"></script>
<script type="text/javascript">
	jQuery(function($) {
		//initiate dataTables plugin
		var oTable1 = 
		$('#table-user-list').dataTable( {
			bAutoWidth: false,
			"bProcessing": true,
			"sAjaxSource": "manage-manufacturer/return-manufacturer-list.php",
			"aoColumns": [
				{ mData: '#',"bSortable": false },
				{ mData: 'manufacturer' },
				{ mData: 'contact' },
				{ mData: 'email' },
				{ mData: 'Status',"sClass": "tdcenter" },
				{ mData: 'Action',"bSortable": false,"sClass": "tdcenter" },
			],
			"aaSorting": [],
		} );		
	});
$(document).ready(function() {
    //called when key is pressed in textbox
      $("#contact1").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 94 && e.which != 43 && e.which != 45 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
          return false;
        }
    });
      $("#contact2").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 94 && e.which != 43 && e.which != 45 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
          return false;
        }
    });
      $("#pincode").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 94 && e.which != 43 && e.which != 45 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
          return false;
        }
    });
      $("#upincode").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 94 && e.which != 43 && e.which != 45 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
          return false;
        }
    });
       $("#ucontact1").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 94 && e.which != 43 && e.which != 45 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
          return false;
        }
    });
        $("#ucontact2").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 94 && e.which != 43 && e.which != 45 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
          return false;
        }
    });
        $(document).ready(function(){
    var $regexname=/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/; 
    $('#email').blur(function(e){
             if (!$(this).val().match($regexname)) {
             alert("Enter valid email id");
             $('#email').val("");
             return false;
             }
           
         });
});
        $(document).ready(function(){
    var $regexname=/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/; 
    $('#uemail').blur(function(e){
             if (!$(this).val().match($regexname)) {
             alert("Enter valid email id");
             $('#uemail').val("");
             return false;
             }
           
         });
});


});

</script>
</body>
</html>
