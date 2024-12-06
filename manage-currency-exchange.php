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
<title>Manage Currency Exchange</title>
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
 <?php include('navigate.php'); ?>

    <script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
  </div>
  <div class="main-content">
    <div class="main-content-inner">
      <div class="main-content-inner">
        <div class="page-content">
          <div class="page-header">
            <h1> Master Entry <small> <i class="ace-icon fa fa-angle-double-right"></i> Manage Currency Exchange </small> </h1>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="row">
                <div class="col-xs-12">
                  <div class="table-header"> List of Currency Exchange Rates
				  <a data-toggle="modal" data-target="#modal-new-currency-exchange" class="pull-right" style="margin-right:15px;color:#FFFFFF;text-decoration:none;cursor:pointer;"><i class="ace-icon fa fa-user"></i>  Add New</a>				  </div>
                  <div>
                    <table id="table-user-list" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th class="center">SNo</th>
                          <th>Base Currency</th>
                          <th>Currency Amount</th>
                          <th>Exchange Currency</th>
                          <th>Exchange Rate</th>
                          <th>Status</th>
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
                      <div class="table-header">Currency Information</div>
                    </div>
                    <div class="modal-body no-padding">
                      <div class="col-xs-12">
                        <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
                          <tr>
                            <th scope="row" style="vertical-align:middle;">Currency</th>
                            <td colspan="3" id="vcurrency"></td>
                          </tr>
                           <tr>
                            <th scope="row" style="vertical-align:middle;">Base Currency</th>
                            <td colspan="3" id="vbase_currency"></td>
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
                      <div class="table-header">Update Currency Information</div>
                    </div>
					<div class="modal-body no-padding">
                      <div class="col-xs-12">
					  	<form id="updatecurrency">
                        <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
                          <tr>
                            <th scope="row" style="vertical-align:middle;">Name</th>
                            <td colspan="3"><input type="hidden" id="DBid" name="DBid"><input type="text" id="ucurrency" name="ucurrency" placeholder="Currency Name"></td>
                          </tr>
                          <tr>
                            <th scope="row" style="vertical-align:middle;">Base Currency</th>
                            <td colspan="3">
                              <select name="ubase_currency" id="ubase_currency">
                                <option value='1'>Yes</option>
                                <option value='0'>No</option>  
                              </select>
                            </td>
                          </tr>
                        </table>
						</form>
						<br />
					  </div>
                    </div>
                    <div class="modal-footer no-margin-top">
					  <button class="btn btn-sm btn-info pull-right" data-dismiss="modal"> <i class="ace-icon fa fa-times"></i> Close </button>
                      <input type="button" class="btn btn-sm btn-primary pull-right" value="Update" onClick="updatecurrency()" style="margin-right:10px;"/>
                    </div>
                  </div>
                </div>
              </div>
			      <div id="modal-new-currency-exchange" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header no-padding">
                      <div class="table-header">New Currency Information</div>
                    </div>
                      <div class="modal-body no-padding">
                        <div class="col-xs-12">
                        <form id="newcurrency" >
  					  	          <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
                              <tr>
                                <th scope="row" style="vertical-align:middle;">Base Currency *</th>
                                <?php 
                                      include("../config.php");
                                      $base_currency_query = mysql_query("SELECT * FROM `tbl_currency` where `base_currency` = '1'");
                                      $base_currency_query_res_rs = mysql_fetch_array($base_currency_query); 
                                ?>
                                <td colspan="3"><input type="text" readonly id="icurrency" name="icurrency" value="<?php echo $base_currency_query_res_rs['currency'] ?>" />
                                <input type="hidden" id="currency" name="currency" value="<?php echo $base_currency_query_res_rs['id'] ?>" />
                              </td>
                              </tr>
                              <tr>
                                <th scope="row" style="vertical-align:middle;">Currency Amount</th>
                                <td colspan="3"><input type="text" readonly id="currency_amnt" name="currency_amnt" value='1' /></td>
                              </tr>
                              <tr>
                                <th scope="row" style="vertical-align:middle;">Exchange Currency</th>
                                <td colspan="3">
                                  <select name="exchange_currency" id="exchange_currency">  
                                  <?php
                                    
                                    $sql = "SELECT * FROM `tbl_currency` where `status` = '1' AND `base_currency` = '0'";
                                    $res = mysql_query($sql);

                                    while($rs = mysql_fetch_array($res)){
                                      $id=$rs['id'];
                                      $name=$rs['currency'];
                                    ?>
                                    <option value="<?php echo $id ?>"><?php echo $name ?></option>
                                    <?php } ?>
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row" style="vertical-align:middle;">Exchange Value</th>
                                <td colspan="3"><input type="text" id="exchange_value" name="exchange_value" /></td>
                              </tr>
                              <tr>
                                <th scope="row" style="vertical-align:middle;">Status</th>
                                <td colspan="3">
                                  <select name="status" id="status">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                  </select>
                                </td>
                              </tr>
                            </table>
            						  <br />
            					  </div>
                      </div>
                      <div class="modal-footer no-margin-top">
  					            <button class="btn btn-sm btn-info pull-right" data-dismiss="modal"> <i class="ace-icon fa fa-times"></i> Close </button>
                        <input type="submit" value="Save" class="btn btn-sm btn-primary pull-right" style="margin-right:10px;">
                      </div>
                    </form>
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
<script src="manage-currency-exchange/manage-currency-exchange.js"></script>
<script src="manage-bill/quick-bill.js"></script>
<script type="text/javascript">
	jQuery(function($) {
		//initiate dataTables plugin
		var oTable1 = 
		$('#table-user-list').dataTable( {
			bAutoWidth: false,
			"bProcessing": true,
			"sAjaxSource": "manage-currency-exchange/return-currency-exchange-list.php",
			"aoColumns": [
				{ mData: '#',"bSortable": true },
				{ mData: 'base_currency' },
        { mData: 'base_currency_amnt' },
        { mData: 'exchange_currency' },
        { mData: 'exchange_rate' },
				{ mData: 'Status',"sClass": "tdcenter" }
			],
			"aaSorting": [],
		} );		
	});

</script>

</body>
</html>
