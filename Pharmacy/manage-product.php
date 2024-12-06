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
<title>Manage Products</title>
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
 $currentPage = 'Manage_Products';
 include('navigate.php'); ?>

    <script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
  </div>
  <div class="main-content">
    <div class="main-content-inner">
      <div class="main-content-inner">
        <div class="page-content">
          <div class="page-header col-md-6">
            <h1> Master Entry  <small> <i class="ace-icon fa fa-angle-double-right"></i> 
              Manage Products </small></h1></div>
              <div class="col-md-6" style="text-align:right;"><label>
                Claim Type</label>
            <select id="claim" onchange="claimProd()" style="font-size:12px;" >
              <option>All</option>
              <option value="CM">Claimable</option>
              <option value="NCM">Non-Claimable</option>
            </select>
            </div>
       
          <div class="row">
            <div class="col-xs-12">
              <div class="row">
                <div class="col-xs-12">
                  <div class="table-header"> List of Products <a data-toggle="modal" data-target="#modal-new-product" class="pull-right" style="margin-right:15px;color:#FFFFFF;text-decoration:none;cursor:pointer;"><i class="ace-icon fa fa-medkit"></i> Add New Product </a> </div>
                  <div>
                    <table id="table-user-list" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th class="center">SNo</th>
						  <th>Product Type</th>
                          <th>Product Name</th>
                          <th>Manufacturer</th>
                          <th>Shelf</th>
                          <th>Rack</th>
                          <th>Generic</th>
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
                      <div class="table-header">Product Information</div>
                    </div>
                    <div class="modal-body no-padding">
                      <div class="col-xs-12">
                        <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Name</th>
                              <td colspan="3" id="vproduct"></td>
                            </tr>
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Generic</th>
                              <td colspan="3" id="vgeneric"></td>
                            </tr>
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Manufacturer</th>
                              <td colspan="3" id="vmanufact"></td>
                            </tr>
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Schedule Type</th>
                              <td id="vschedule"></td>
                              <th scope="row" style="vertical-align:middle;">Product Type</th>
                              <td id="vproducttype"></td>
                            </tr>
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Unit Desc.</th>
                              <td id="vunitdesc"></td>
                              <th scope="row" style="vertical-align:middle;">Stock Type</th>
                              <td id="vstocktype"></td>
                            </tr>
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Purchase Tax(%)</th>
                              <td id="vptax"></td>
                              <th scope="row" style="vertical-align:middle;">Sale Tax(%)</th>
                              <td id="vstax"></td>
                            </tr>
                            <tr>
                             <!-- <th scope="row" style="vertical-align:middle;">MRP</th>
                              <td id="vmrp"></td>
                              <th scope="row" style="vertical-align:middle;">Unit Price</th>
                              <td id="vprice"></td>
                            </tr>-->
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Min. Qty.</th>
                              <td id="vminqty"></td>
                              <th scope="row" style="vertical-align:middle;">Max. Qty.</th>
                              <td id="vmaxqty"></td>
                            </tr>
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Shelf</th>
                              <td id="vshelf"></td>
                              <th scope="row" style="vertical-align:middle;">Rack</th>
                              <td id="vrack"></td>
                            </tr>
                            <th scope="row" style="vertical-align:middle;">HSN code</th>
                              <td id="vhsncode"></td>
                              <th scope="row" style="vertical-align:middle;">Claim Type</th>
                              <td id="vcliam_type"></td>
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
                      <div class="table-header">Update Product Information</div>
                    </div>
                    <div class="modal-body no-padding">
                      <div class="col-xs-12">
						  <form id="updateProduct">
                          <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Name</th>
                              <td colspan="3"><input type="hidden" id="DBid" name="DBid"><input type="text" id="uproduct" name="uproduct" placeholder="Product Name"></td>
                            </tr>
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Generic</th>
                              <td colspan="3"><input type="text" id="ugeneric" name="ugeneric" placeholder="Generic"></td>
                            </tr>
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Manufacturer</th>
                              <td colspan="3"><input type="text" id="umanufact" name="umanufact" placeholder="Manufacturer Name" onFocus="manuList('u')" onBlur="valManuf('u')" list="lstmanufact">
                                <datalist id="lstmanufact"></datalist></td>
                            </tr>
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Schedule Type</th>
                              <td><select id="uschedule" name="uschedule">
                                  <option value="">-</option>
                                  <option value='A'>Scheduled(A)</option>
                                  <option value='B'>Scheduled(B)</option>
                                  <option value='C'>Scheduled(C)</option>
                                  <option value='D'>Scheduled(D)</option>
                                  <option value='E'>Scheduled(E)</option>
                                  <option value='F'>Scheduled(F)</option>
                                  <option value='G'>Scheduled(G)</option>
                                  <option value='H'>Scheduled(H)</option>
				  <option value='H1'>Scheduled(H1)</option>
				  <option value='I'>Scheduled(I)</option>
                                  <option value='J'>Scheduled(J)</option>
                                  <option value='K'>Scheduled(K)</option>
                                  <option value='L'>Scheduled(L)</option>
                                  <option value='M'>Scheduled(M)</option>
                                  <option value='N'>Scheduled(N)</option>
                                  <option value='O'>Scheduled(O)</option>
                                  <option value='P'>Scheduled(P)</option>
                                  <option value='Q'>Scheduled(Q)</option>
                                  <option value='R'>Scheduled(R)</option>
                                  <option value='S'>Scheduled(S)</option>
                                  <option value='T'>Scheduled(T)</option>
                                  <option value='U'>Scheduled(U)</option>
                                  <option value='V'>Scheduled(V)</option>
                                  <option value='W'>Scheduled(W)</option>
                                  <option value='X'>Scheduled(X)</option>
                                  <option value='Y'>Scheduled(Y)</option>
                                  <option value='Z'>Scheduled(Z)</option>
                                </select>
                              </td>
                              <th scope="row" style="vertical-align:middle;">Product Type</th>
                              <td><select id="uproducttype" name="uproducttype">
                                  <option value='P'>Pharma (P)</option>
                                  <option value='NP'>Non-Pharma(NP)</option>
                                  <option value='0'>Others(0)</option>
                                </select></td>
                            </tr>
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Unit Desc.</th>
                              <td><input type="text" id="uunitdesc" name="uunitdesc" placeholder="10 / 15" class="number"></td>
                              <th scope="row" style="vertical-align:middle;">Stock Type</th>
                              <td><select id="ustocktype" name="ustocktype">
							  		<option>SELECT</option>
								  <?php
										require_once("config.php");
										$q = mysqli_query($db,"SELECT producttype FROM tbl_producttype WHERE status = 1");
										while($r = mysqli_fetch_array($q)){
											echo '<option>'.$r['producttype'].'</option>';
										}
									?>
							  </select></td>
                            </tr>
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Purchase Tax(%)</th>
                              <td><input type="text" id="uptax" name="uptax" placeholder="Purchase Tax %" value="0" class="number"></td>
                              <th scope="row" style="vertical-align:middle;">Sale Tax(%)</th>
                              <td><input type="text" id="ustax" name="ustax" placeholder="Sale Tax %" value="0" class="number"></td>
                            </tr>
                            <!--<tr>
                              <th scope="row" style="vertical-align:middle;">MRP</th>
                              <td><input type="text" id="umrp" name="umrp" placeholder="MRP" onBlur="calcUnitPrice('u')"></td>
                              <th scope="row" style="vertical-align:middle;">Unit Price</th>
                              <td><input type="text" id="uprice" name="uprice" placeholder="MRP / Unit Desc."></td>
                            </tr>-->
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Min. Qty.</th>
                              <td><input type="text" id="uminqty" name="uminqty" placeholder="Minimum" ></td>
                              <th scope="row" style="vertical-align:middle;">Max. Qty.</th>
                              <td><input type="text" id="umaxqty" name="umaxqty" placeholder="Maximum"></td>
                            </tr>
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Shelf</th>
                              <td><input type="text" id="ushelf" name="ushelf" placeholder="Shelf"></td>
                              <th scope="row" style="vertical-align:middle;">Rack</th>
                              <td><input type="text" id="urack" name="urack" placeholder="Rack"></td>
                            </tr>
                            <tr>
                              <th scope="row" style="vertical-align:middle;">HSN Code</th>
                              <td><input type="text" id="uhsncode" name="uhsncode" placeholder="HSN Code"></td>
                              <th scope="row" style="vertical-align:middle;">Claim Type</th>
                             <td><select id="ucliam_type" name="ucliam_type">
                              <option value=''>select</option>
                                 <option value='CM'>Claimable</option>
                                 <option value='NCM'>Non-Claimable</option>
                               </select></td>
                            </tr>
                          </table>
                        </form>
                        <br />
                      </div>
                    </div>
                    <div class="modal-footer no-margin-top">
                      <button class="btn btn-sm btn-info pull-right" data-dismiss="modal"> <i class="ace-icon fa fa-times"></i> Close </button>
                      <input type="button" class="btn btn-sm btn-primary pull-right" value="Update" onClick="updateProduct()" style="margin-right:10px;"/>
                    </div>
                  </div>
                </div>
              </div>
              <div id="modal-new-product" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header no-padding">
                      <div class="table-header">New Product Information <a data-toggle="modal" data-target="#modal-new-manufacturer" class="pull-right" style="margin-right:15px;color:#FFFFFF;text-decoration:none;cursor:pointer;"><i class="ace-icon fa fa-medkit"></i> Add New Manufacturer </a> </div>
                    </div>
                    <div class="modal-body no-padding">
                      <div class="col-xs-12">
                        <form id="newProduct">
                          <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Name</th>
                              <td colspan="3"><input type="text" id="product" name="product" placeholder="Product Name"></td>
                            </tr>
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Generic</th>
                              <td colspan="3"><input type="text" id="generic" name="generic" placeholder="Generic"></td>
                            </tr>
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Manufacturer</th>
                              <td colspan="3"><input type="text" id="manufact" name="manufact" placeholder="Manufacturer Name" onFocus="manuList('n')" onBlur="valManuf('n')" list="lstmanufact">
                                <datalist id="lstmanufact"></datalist></td>
                            </tr>
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Schedule Type</th>
                              <td><select id="schedule" name="schedule">
                                  <option value="">-</option>
                                  <option value='A'>Scheduled(A)</option>
                                  <option value='B'>Scheduled(B)</option>
                                  <option value='C'>Scheduled(C)</option>
                                  <option value='D'>Scheduled(D)</option>
                                  <option value='E'>Scheduled(E)</option>
                                  <option value='F'>Scheduled(F)</option>
                                  <option value='G'>Scheduled(G)</option>
                                  <option value='H'>Scheduled(H)</option>
                                  <option value='H1'>Scheduled(H1)</option>
				  <option value='I'>Scheduled(I)</option>
                                  <option value='J'>Scheduled(J)</option>
                                  <option value='K'>Scheduled(K)</option>
                                  <option value='L'>Scheduled(L)</option>
                                  <option value='M'>Scheduled(M)</option>
                                  <option value='N'>Scheduled(N)</option>
                                  <option value='O'>Scheduled(O)</option>
                                  <option value='P'>Scheduled(P)</option>
                                  <option value='Q'>Scheduled(Q)</option>
                                  <option value='R'>Scheduled(R)</option>
                                  <option value='S'>Scheduled(S)</option>
                                  <option value='T'>Scheduled(T)</option>
                                  <option value='U'>Scheduled(U)</option>
                                  <option value='V'>Scheduled(V)</option>
                                  <option value='W'>Scheduled(W)</option>
                                  <option value='X'>Scheduled(X)</option>
                                  <option value='Y'>Scheduled(Y)</option>
                                  <option value='Z'>Scheduled(Z)</option>
                                </select>
                              </td>
                              <th scope="row" style="vertical-align:middle;">Product Type</th>
                              <td><select id="producttype" name="producttype">
                              <option value=''>select</option>
                                  <option value='P'>Pharma (P)</option>
                                  <option value='NP'>Non-Pharma(NP)</option>
<option value='s'>Surgicals(s)</option>
                                  <option value='0'>Others(0)</option>
                                </select></td>
                            </tr>
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Unit Desc.</th>
                              <td><input type="text" id="unitdesc" name="unitdesc" placeholder="10 / 15" class="number"></td>
                              <th scope="row" style="vertical-align:middle;">Stock Type</th>
                              <td><select id="stocktype" name="stocktype"><option>SELECT</option>
							  		<?php
										require_once("config.php");
										$q = mysqli_query($db,"SELECT producttype FROM tbl_producttype WHERE status = 1");
										while($r = mysqli_fetch_array($q)){
											echo '<option>'.$r['producttype'].'</option>';
										}
									?>
							  		</select></td>
                            </tr>
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Purchase Tax(%)</th>
                              <td><input type="text" id="ptax" name="ptax" placeholder="Purchase Tax %" value="0" class="number"></td>
                              <th scope="row" style="vertical-align:middle;">Sale Tax(%)</th>
                              <td><input type="text" id="stax" name="stax" placeholder="Sale Tax %" value="0" class="number"></td>
                            </tr>
                            <!--<tr>
                              <th scope="row" style="vertical-align:middle;">MRP</th>
                              <td><input type="text" id="mrp" name="mrp" placeholder="MRP" onBlur="calcUnitPrice('n')"></td>
                              <th scope="row" style="vertical-align:middle;">Unit Price</th>
                              <td><input type="text" id="price" name="price" placeholder="MRP / Unit Desc."></td>
                            </tr>-->
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Min. Qty.</th>
                              <td><input type="text" id="minqty" name="minqty" placeholder="Minimum"></td>
                              <th scope="row" style="vertical-align:middle;">Max. Qty.</th>
                              <td><input type="text" id="maxqty" name="maxqty" placeholder="Maximum" onBlur="calvalidation($(this))"></td>
                            </tr>
							
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Shelf</th>
                              <td><input type="text" id="shelf" name="shelf" placeholder="Shelf"></td>
                              <th scope="row" style="vertical-align:middle;">Rack</th>
                              <td><input type="text" id="rack" name="rack" placeholder="Rack"></td>
                              </tr>
                              <tr>
                              <th scope="row" style="vertical-align:middle;">HSN Code</th>
                              <td><input type="text" id="hsncode" name="hsncode" placeholder="HSN Code"></td>
                              <th scope="row" style="vertical-align:middle;">Claim Type</th>
                             <td><select id="cliam_type" name="cliam_type">
                              <option value=''>select</option>
                                 <option value='CM'>Claimable</option>
                                 <option value='NCM'>Non-Claimable</option>
                               </select></td>
                            </tr>
                          </table>
                        </form>
                        <br />
                      </div>
                    </div>
                    <div class="modal-footer no-margin-top">
                      <button class="btn btn-sm btn-info pull-right" data-dismiss="modal"> <i class="ace-icon fa fa-times"></i> Close </button>
                      <input type="button" class="btn btn-sm btn-primary pull-right" value="Save" onClick="newProduct()" style="margin-right:10px;"/>
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
                              <th rowspan="4" scope="row" style="vertical-align:middle;">Address</th>
                            </tr>
                            <tr>
                              <td colspan="3"><input type="text" id="addressline1" name="addressline1" placeholder="Address Line 1"></td>
                            </tr>
                            <tr>
                              <td colspan="3"><input type="text" id="addressline2" name="addressline2" placeholder="Address Line 2"></td>
                            </tr>
                            <tr>
                              <td colspan="3"><input type="text" id="addressline3" name="addressline3" placeholder="Address Line 3"></td>
                            </tr>
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
                              <td><input type="text" id="pincode" name="pincode" placeholder="Pincode"></td>
                            </tr>
                            <tr>
                              <th scope="row" style="vertical-align:middle;">Contact #</th>
                              <td><input type="text" id="contact1" name="contact1" placeholder="Contact # 1"></td>
                              <th scope="row" style="vertical-align:middle;">Contact #</th>
                              <td><input type="text" id="contact2" name="contact2" placeholder="Contact # 2"></td>
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
<script src="manage-product/manage-product.js"></script>
<script src="manage-bill/quick-bill.js"></script>
<script type="text/javascript">
	jQuery(function($) {
		//initiate dataTables plugin
		var oTable1 = 
		$('#table-user-list').dataTable( {
			bAutoWidth: false,
			"bProcessing": true,
			"sAjaxSource": "manage-product/return-product-list.php",
			"aoColumns": [
				{ mData: '#',"bSortable": true },
				{ mData: 'type' },
				{ mData: 'product' },
				{ mData: 'manufacturer' },
				{ mData: 'shelf' },
				{ mData: 'rack' },
				{ mData: 'generic' },
				{ mData: 'Action',"bSortable": false,"sClass": "tdcenter" },
			],
			"aaSorting": [],
		} );		
	});

  function claimProd()
  {
    var clm_type = $('#claim').val();
    var oTable1 = 
    $('#table-user-list').dataTable( {
      "destroy" : true,
      bAutoWidth: false,
      "bProcessing": true,
      "sAjaxSource": "manage-product/return-product-list.php?claim_type="+clm_type,
      "aoColumns": [
        { mData: '#',"bSortable": true },
        { mData: 'type' },
        { mData: 'product' },
        { mData: 'manufacturer' },
        { mData: 'shelf' },
        { mData: 'rack' },
        { mData: 'generic' },
        { mData: 'Action',"bSortable": false,"sClass": "tdcenter" },
      ],
      "aaSorting": [],
    } );  
  }
	
</script>
</body>
</html>
