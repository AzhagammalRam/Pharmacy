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
<title>Manage Users</title>
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
    <div class="navbar-header pull-left"> <a href="#" class="navbar-brand"> <small> <img height="80" width="130" src="images/logoo.png" /> Pharmacy </small> </a>
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
 $currentPage = 'Manage_Users';
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
            <h1> Master Entry <small> <i class="ace-icon fa fa-angle-double-right"></i> Manage Users </small> </h1>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="row">
                <div class="col-xs-12">
                  <div class="table-header"> List of Users <a data-toggle="modal" data-target="#modal-new" class="pull-right" style="margin-right:15px;color:#FFFFFF;text-decoration:none;cursor:pointer;"><i class="ace-icon fa fa-user"></i> Add New User </a> </div>
                  <div>
                    <table id="table-user-list" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th class="center">SNo</th>
                          <th>Name</th>
                          <th>User ID</th>
                          <th>Role</th>
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
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header no-padding">
                      <div class="table-header">User Information</div>
                    </div>
                    <div class="modal-body no-padding">
                      <div class="col-xs-12">
                        <div class="col-xs-6">
                          <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
                            <tr>
                              <th scope="row">Name</th>
                              <td id="txtUserName">UserName</td>
                            </tr>
                            <tr>
                              <th scope="row">User ID</th>
                              <td id="txtUserId">Admin</td>
                            </tr>
                            <tr>
                              <th scope="row">Role</th>
                              <td id="txtRole">Role</td>
                            </tr>
                            <tr>
                              <th scope="row">Status</th>
                              <td id="txtStatus">Status</td>
                            </tr>
                            <tr>
                              <th scope="row">store</th>
                              <td id="txtstore">store</td>
                            </tr>
                          </table>
                        </div>
                        <div class="col-xs-3"> <img height=150 width=180 alt="Image Not Found" id="txtPhoto" /></div>
                      </div>
                    </div>
                    <div class="col-xs-12"> <br />
                      <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
                        <tr>
                          <td colspan="4">Master Entry</td>
                        </tr>
                        <tr>
                          <td id="vopt1"></td>
                          <td id="vopt2"></td>
                          <td id="vopt3"></td>
                          <td id="vopt4"></td>
                          <td id="vopt5"></td>
                        </tr>
                        <tr>  
                          <td id="vopt6"></td>
                          
                        </tr>
                         <tr>
                        <td colspan="4">Credit Pay</td>
                        </tr>
                         <tr>
                          <td id="vopt7"></td>
                          <td id="vopt8"></td>

                        </tr>
                        <tr>
                          <td colspan="4">Sales</td>
                        </tr>
                        <tr>
                          <td id="vopt9"></td>
                          <td id="vopt10"></td>
                          <td id="vopt11"></td>
                        </tr>
                        <tr>
                          <td colspan="4">Purchase</td>
                        </tr>
                        <tr>
                          
                         
                        <td id="vopt12"></td>
                        <td id="vopt13"></td>
                        <td id="vopt14"></td>

`                                                     
                        </tr>
                        <tr>
                        <td colspan="4">Stocks</td>
                        </tr>
                        <tr>                       
                        <td id="vopt15"></td>
                        <td id="vopt16"></td>   
                        <td id="vopt20"></td>
                        <td id="vopt17"></td>
                        <!-- <td id="vopt18"></td> -->
                       
                        </tr>
                        <tr>
                        <td colspan="4">Reports</td>
                        </tr>
                        <tr>
                          
                        <td id="vopt19"></td>
                       
                        <td id="vopt21"></td>
                        <td id="vopt22"></td>
                        <td id="vopt23"></td>
                        </tr>
                        <tr>
                        <td id="vopt24"></td>
                        <td id="vopt25"></td>
                        <td id="vopt26"></td>
                        <td id="vopt27"></td>
                        <td id="vopt28"></td>
                        </tr>
                        <tr>                             
                        <td id="vopt29"></td> 
                        <td id="vopt30"></td>
                        <td id="vopt31"></td>
                        <td id="vopt32"></td>   
                        <td id="vopt33"></td>
                        </tr>
                        <tr>                             
                        <td id="vopt34"></td>
                        </tr>
                      </table>
                      <br />
                    </div>
                    <div class="modal-footer no-margin-top">
                      <button class="btn btn-sm btn-info pull-right" data-dismiss="modal"> <i class="ace-icon fa fa-times"></i> Close </button>
                    </div>
                  </div>
                </div>
              </div>
              <div id="modal-update" class="modal fade" tabindex="-1">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header no-padding">
                      <div class="table-header">Update User Information</div>
                    </div>
                    <div class="modal-body no-padding">
                      <div class="col-xs-12">
                        <div class="col-xs-8">
                          <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
                            <tr>
                              <th scope="row">Name *</th>
                              <td><input type="hidden" id="DBid" name="DBid">
                                <input type="text" id="UserName" name="UserName"></td>
                            </tr>
                            <tr>
                              <th scope="row">User ID *</th>
                              <td><input type="text" id="UserId" name="UserId"></td>
                            </tr>
                            <tr>
                              <th scope="row">Password *</th>
                              <td><input type="text" id="Password" name="Password" required></td>
                            </tr>
                            <tr>
                              <th scope="row">Role *</th>
                              <td><select id="Role" name="Role">
                                  <option value="0">Select</option>
                                  <option value="1">Admin</option>
                                  <option value="2">User</option>
                                </select></td>
                            </tr>
                             <tr>
                              <th scope="row">Store</th>
                              <td><select id="newstore" name="newstore">
                                 <option value="0">Select</option>
                                  <?php
                                  include("config.php"); 
                      $q = mysqli_query($db,"SELECT distinct name,id FROM branch");
                      // echo "SELECT distinct name,id FROM branch";
                      while($r = mysqli_fetch_array($q)){
                        echo '<option value='.$r['id'].'>'.$r['name'].'</option>';
                      }
                    ?>
                                </select></td>
                            </tr>
                            <tr>
                              <th scope="row">Photo</th>
                              <td><input type="file" id="Photo" name="Photo" onChange="readURL(this)"></td>
                            </tr>
                          </table>
                        </div>
                        <div class="col-xs-3"> <img height=150 width=180 alt="Image Not Found" id="imgPhoto" /></div>
                      </div>
                    </div>
                    <div class="col-xs-12"> <br />
                      <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
                        <tr>
                          <td colspan="4">Master Entry</td>
                        </tr>
                        <tr>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt1">
                              Manage Product</label>
                            </div></td>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt2">
                              Manage Manufacturer</label>
                            </div></td>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt3">
                              Manage Suppliers</label>
                            </div></td>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt4">
                              Manage Users</label>
                            </div></td>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt22">
                              Manage store</label>
                            </div></td>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt23">
                              Manage Doctor</label>
                            </div></td>
                        </tr>
                         <tr>
                          <td colspan="4">Credit Pay</td>
                        </tr>
                        <tr>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt20">
                              Supplier Credit</label>
                            </div></td>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt21">
                               Customer Credit</label>
                            </div></td>
                        <tr>
                          <td colspan="4">Sales</td>
                        </tr>
                        <tr>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt5">
                              Billing</label>
                            </div></td>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt6">
                              Sales Return</label>
                            </div></td>
                            <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt28">
                              Drug Return</label>
                            </div></td>
                          
                        </tr>
                        <tr>
                          <td colspan="4">Purchase</td>
                        </tr>
                        <tr>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt7">
                              Purchase Entry</label>
                            </div></td>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt8">
                              Purchase Return</label>
                            </div></td>
                            <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt29">
                              Purchase Return-Others</label>
                            </div></td>
                          
                        </tr>
                        <tr>
                          <td colspan="4">Stocks</td>
                        </tr>
                        <tr>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt9">
                              Stock Availability</label>
                            </div></td>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt10">
                              Initial Stock Entry</label>
                            </div></td>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt11">
                              Stock Adjustment</label>
                            </div></td>
                        <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt19">
                              Stock Transfer</label>
                            </div></td>
                             <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt32">
                              Stock Clearance</label>
                            </div></td>
                        <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt33">
                              Disposed Stocks</label>
                            </div></td>
                          
                        </tr>
                        <tr>
                          <td colspan="4">Reports</td>
                        </tr>
                        <tr>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt12">
                              Sales Report</label>
                            </div></td>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt13">
                              Purchase Report</label>
                            </div></td>
							<td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt14">
                              Doctor Report</label>
                            </div></td>
							<td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt15">
                              Tax Report</label>
                            </div></td>
							<td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt16">
                              Schedule Report</label>
                            </div></td>
                            <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt17">
                               Short Expiry Report</label>
                            </div></td>
                        </tr>
                        <tr>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt24">
                              PF Report</label>
                            </div></td>
                            <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt25">
                               Ip Bill Summary Report</label>
                            </div></td>
                            <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt26">
                             Purchase Return Report</label>
                            </div></td>
                            <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt27">
                               Store Report</label>
                            </div></td>
                            <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt30">
                               Drug Return Report</label>
                            </div></td>
                             <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt31">
                               Disposed report</label>
                            </div></td>
                            <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="xopt34">
                               Camp Medicine report</label>
                            </div></td>
                                                </tr>
                      </table>
                      <br />
                    </div>
                    <div class="modal-footer no-margin-top">
                      <button class="btn btn-sm btn-info pull-right" data-dismiss="modal"> <i class="ace-icon fa fa-times"></i> Close </button>
                      <input type="button" class="btn btn-sm btn-primary pull-right" value="Update" onClick="updateUser()" style="margin-right:10px;"/>
                    </div>
                  </div>
                </div>
              </div>
              <div id="modal-new" class="modal fade" tabindex="-1">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header no-padding">
                      <div class="table-header">New User Information</div>
                    </div>
                    <div class="modal-body no-padding">
                      <div class="col-xs-12">
                        <div class="col-xs-8">
                          <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
                            <tr>
                              <th scope="row">Name *</th>
                              <td><input type="text" id="newUserName" name="newUserName"></td>
                            </tr>
                            <tr>
                              <th scope="row">User ID *</th>
                              <td><input type="text" id="newUserId" name="newUserId"></td>
                            </tr>
                            <tr>
                              <th scope="row">Password *</th>
                              <td><input type="password" id="newPassword" name="newPassword" required></td>
                            </tr>
                            <tr>
                              <th scope="row">Role *</th>
                              <td><select id="newRole" name="newRole">
                                  <option value="0">Select</option>
                                  <option value="1">Admin</option>
                                  <option value="2">User</option>
                                </select></td>
                            </tr>
                            <tr>
                              <th scope="row">Store</th>
                              <td><select id="newstore" name="newstore">
                                  <option value="0">Select</option>
                                  <?php
                                  include("config.php"); 
											$q = mysqli_query($db,"SELECT distinct name,id FROM branch");
											// echo "SELECT distinct name,id FROM branch";
                      while($r = mysqli_fetch_array($q)){
												echo '<option value='.$r['id'].'>'.$r['name'].'</option>';
											}
										?>
                                </select></td>
                            </tr>
                            <tr>
                              <th scope="row">Photo</th>
                              <td><input type="file" id="newPhoto" name="newPhoto" onChange="readNewURL(this)"></td>
                            </tr>
                          </table>
                        </div>
                        <div class="col-xs-3"> <img height=150 width=180 alt="Image Not Found" id="newimgPhoto" /></div>
                      </div>
                    </div>
<div class="col-xs-12"> <br />
                      <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
                        <tr>
                          <td colspan="4">Master Entry</td>
                        </tr>
                        <tr>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt1">
                              Manage Product</label>
                            </div></td>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt2">
                              Manage Manufacturer</label>
                            </div></td>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt3">
                              Manage Suppliers</label>
                            </div></td>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt4">
                              Manage Users</label>
                            </div></td>
                         <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt22">
                              Manage Doctors</label>
                            </div></td>
                         <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt23">
                              Manage Store</label>
                            </div></td>
                        </tr>
                         <tr>
                          <td colspan="4">Credit Pay</td>
                        </tr>
                        <tr>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt20">
                              Supplier Credit</label>
                            </div></td>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt21">
                               Customer Credit</label>
                            </div></td>
                        <tr>
                          <td colspan="4">Sales</td>
                        </tr>
                        <tr>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt5">
                              Billing</label>
                            </div></td>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt6">
                              Sales Return</label>
                            </div></td>
                            <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt28">
                              Drug Return</label>
                            </div></td>
                         
                        </tr>
                        <tr>
                          <td colspan="4">Purchase</td>
                        </tr>
                        <tr>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt7">
                              Purchase Entry</label>
                            </div></td>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt8">
                              Purchase Return</label>
                            </div></td>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt29">
                              Purchase Return-Others</label>
                            </div></td>  
                         
                        </tr>
                        <tr>
                          <td colspan="4">Stocks</td>
                        </tr>
                        <tr>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt19">
                              Stock Transfer</label>
                            </div></td>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt9">
                              Stock Availability</label>
                            </div></td>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt10">
                              Initial Stock Entry</label>
                            </div></td>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt11">
                              Stock Adjustment</label>
                            </div></td>
                            <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt32">
                              Stock Clearance</label>
                            </div></td>
                            <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt33">
                              Disposed Stocks</label>
                            </div></td>
                         
                        </tr>
                        <tr>
                          <td colspan="4">Reports</td>
                        </tr>
                        <tr>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt12">
                              Sales Report</label>
                            </div></td>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt13">
                              Purchase Report</label>
                            </div></td>
							              <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt14">
                              Doctor Report</label>
                            </div></td>
							              <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt15">
                              Tax Report</label>
                            </div></td>
							              <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt16">
                              Schedule Report</label>
                            </div></td>
                            <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt18">
                             Short Expiry Report</label>
                            </div></td>
                          </tr>
                          <tr>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt24">
                             PF Report</label>
                            </div></td>
                            <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt25">
                             Ip Bill Summary Report</label>
                            </div></td>
                          <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt26">
                             Purchase Return Report</label>
                            </div></td>
                            <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt27">
                             Store Report</label>
                            </div></td>
                            <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt30">
                             Drug Return Report</label>
                            </div></td>
                            <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt32">
                             Disposed Report</label>
                            </div></td>
                            <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt33">
                             Stock Clearance</label>
                            </div></td>
                             <td><div class="checkbox">
                              <label>
                              <input type="checkbox" id="opt34">
                             Camp Medicine Clearance</label>
                            </div></td>
                          </tr>
                      </table>
                      <br />
                    </div>
                    <div class="modal-footer no-margin-top">
                      <button class="btn btn-sm btn-info pull-right" data-dismiss="modal"> <i class="ace-icon fa fa-times"></i> Close </button>
                      <input type="button" class="btn btn-sm btn-primary pull-right" value="Save" onClick="newUser()" style="margin-right:10px;"/>
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
<script src="manage-user/manage-user.js"></script>
<script src="manage-bill/quick-bill.js"></script>
<script type="text/javascript">
	jQuery(function($) {
		//initiate dataTables plugin
		var oTable1 = 
		$('#table-user-list')
		//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
		.dataTable( {
			bAutoWidth: false,
			"bProcessing": true,
			"sAjaxSource": "manage-user/return-user-list.php",
			"aoColumns": [
				{ mData: '#',"bSortable": false },
				{ mData: 'Name' },
				{ mData: 'User ID' },
				{ mData: 'Role' },
				{ mData: 'Status',"sClass": "tdcenter" },
				{ mData: 'Action',"bSortable": false,"sClass": "tdcenter" },
			],
			"aaSorting": [],
		} );		
	});
</script>
</body>
</html>
