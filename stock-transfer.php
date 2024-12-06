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
	//$id=$_GET['id'];



	if(isset($_GET['id']))

		$id=$_GET['id'];

		else

		$id=0;

		//echo $id;

		

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

<meta charset="utf-8" />

<title>Stock Transfer</title>

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

<script src="libs/jquery/2.1.1/jquery.min.js"></script>

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
 $currentPage = 'Stock_Transfer';
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

      <h1> Stock <small> <i class="ace-icon fa fa-angle-double-right"></i> Stock Transfer </small> <a style="display:none" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#mdlNewBill" style="text-align:none;"> New Bill</a> </h1>

    </div>

    <!-- /.page-header -->

    <div class="row">

      <div class="col-xs-12">

        <!-- PAGE CONTENT BEGINS -->

        <div class="center"> <br />

          <div class="widget-box">

            <div class="widget-header">

              <h4 class="widget-title lighter smaller"> <i class="ace-icon fa fa-cogs blue"></i> Bills </h4>

            </div>

            <div class="widget-body">

              <div class="widget-main no-padding">

                <div class="dialogs ace-scroll">

                  <div class="scroll-track scroll-active" style="display: block; height: 300px;">

                    <div class="scroll-bar" style="height: 262px; top: 0px;"></div>

                  </div>

            

                    <?php 

							require_once("config.php");

							$res = mysqli_query($db,"SELECT * FROM tbl_billing WHERE status = 2 and del_status != 1 ");

							while($rs = mysqli_fetch_array($res)){ ?>

                    

                        <?php } ?>

                    <div  role="dialog">

                      <div class="modal-dialog modal-lg">

                        <div class="modal-content">

                          <div class="modal-header no-padding">

                            <div class="table-header">Stock  Transfer </div>

                          </div>

                          <div class="modal-body no-padding" style="  max-height: 450px; min-height: 400px; overflow-y: auto;">

                            <div class="col-xs-12"> <br />

                              <form class="form-horizontal">

                                <div class="form-group">

                                  <label class="col-xs-2 control-label">Move Stock To</label>

                                  <div class="col-xs-2">

                                    <select class="form-control input-sm" name="ptype<?php echo $rs['id']; ?>" id="ptype" onchange="getval(this);">

                                      <option>SELECT</option>

                                      <?php

											$q = mysqli_query($db,"SELECT distinct name,id FROM branch");

											while($r = mysqli_fetch_array($q)){

												echo '<option value='.$r['id'].'>'.$r['name'].'</option>';

											}

										?>

                                    </select>

                                  </div>

                                  <label class="col-xs-2 control-label">Product Name</label>

                                  <div class="col-xs-3">

                                    <input type="text" class="form-control input-sm" name="pname<?php echo $rs['id']; ?>" id="pname" placeholder="Product Name" list="lstProducts" onBlur="retBatchNo('<?php echo $rs['id']; ?>')">

                                  </div>

                                  <label class="col-xs-1 control-label">Batch #</label>

                                  <div class="col-xs-2">

                                    <select class="form-control input-sm" name="batch<?php echo $rs['id']; ?>" id="batch" onChange="returnExpiry('<?php echo $rs['id']; ?>')">

                                      <option>SELECT</option>

                                    </select>

                                  </div>

                                </div>

                                <div class="form-group">

								

								 <label class="col-xs-2 control-label">Aval</label>

                                  <div class="col-xs-2">

                                    <input type="text" class="form-control input-sm" name="aval<?php echo $rs['id']; ?>" id="aval" val="" readonly/>

                                  </div>

								  

                                  <label class="col-xs-2 control-label">Expiry</label>

                                  <div class="col-xs-2">

                                    <input type="text" class="form-control input-sm" name="expiry<?php echo $rs['id']; ?>" id="expiry" val="" readonly/>

                                  </div>

                                  <label class="col-xs-1 control-label">Quantity</label>

                                  <div class="col-xs-1">

                                  <input type="text" class="form-control input-sm mand number" name="qty" id="qty" placeholder="0" onBlur="validateQty('<?php echo $rs['id']; ?>')">

                                  </div>

                                  <input type="button" class="btn btn-sm btn-info col-xs-1" value="Add" onClick="ChangeStock()" />

                                </div>

                                <table id="tbl-list<?php echo $rs['id']; ?>" class="table table-striped">

                                  <thead>

                                    <tr>

                                      <th style="text-align:center">Code</th>

                                      <th style="text-align:center">Description</th>

                                      <th style="text-align:center">Qty.</th>

                                      <th style="text-align:center">Batch#</th>

                                      <th style="text-align:center">Expiry</th>

                                      <th style="text-align:center">Action</th>

                                      <th></th>

                                    </tr>

                                  </thead>

                                  <tbody>

                                  </tbody>

                                </table>

                              </form>

                            </div>

                          </div>

                          <div class="modal-footer no-margin-top">

                          

                            <button type="button" class="btn btn-primary btn-sm" onClick="Updatestock('<?php echo $rs['id']; ?>','0')">Submit</button>

                          </div>

                        </div>

                      </div>

                    </div>

                

                  </div>

                  <!-- /.widget-main -->

                </div>

                <!-- /.widget-body -->

              </div>

              <!-- /.widget-box -->

            </div>

			<script>

			

			</script>

			

            <datalist id="lstProducts">

              <?php

					require_once("config.php");

					$rres = mysqli_query($db,"SELECT productname FROM tbl_productlist WHERE status = 1 ORDER BY productname asc" );

					while($rrs = mysqli_fetch_array($rres)){

						echo '<option>'.$rrs['productname'].'</option>';

					}

				?>

            </datalist>

          </div>

          <br />

          <br />

          <?php 

			require_once("config.php");

			$s1 = mysqli_query($db,"SELECT status FROM tbl_setting WHERE settingstype = 'DPP'");

			$srs = mysqli_fetch_array($s1);

			$dpp = $srs['status'] ? $srs['status'] : 0;

			if($dpp == 1) { ?>

          <!-- /.col -->

          <div class="widget-box">

            

            <div class="widget-body">

              <div class="widget-main no-padding">

                <div class="dialogs ace-scroll">

                  <div class="scroll-track scroll-active" style="display: block; height: 300px;">

                    <div class="scroll-bar" style="height: 262px; top: 0px;"></div>

                  </div>

                  <div id="divUserList">

                    <?php 

							require_once("config.php");

							$res = mysqli_query($db,"SELECT * FROM tbl_billing WHERE status = 3 and del_status != 1 ");

							while($rs = mysqli_fetch_array($res)){ ?>

                    <div class="scroll-content col-xs-4">

                      <div class="itemdiv dialogdiv">

                        <div class="user"> <img alt="<?php echo $rs['patientname']; ?>" src="dist/avatars/user.png"> </div>

                        <a href="#" style="cursor:pointer;text-decoration:none;" data-toggle="modal" data-target="#modal-view<?php echo $rs['id']; ?>" data-whatever="<?php echo $rs['id']; ?>" data-backdrop="static">

                        <div class="body">

                          <div class="name"><?php echo $rs['patientname']; ?></div>

                          <div class="text"><i class="icon-user-md"></i><?php echo $rs['drname']; ?></div>

                          <div class="tools"> <a href="javascript:deleteXBill('<?php echo $rs['id']; ?>');" class="btn btn-minier btn-danger"> <i class="fa fa-trash"></i> </a> </div>

                        </div>

                        </a> </div>

                    </div>

                    <div class="modal fade patient-bill" tabindex="-1" role="dialog" id="modal-view<?php echo $rs['id']; ?>">

                      <div class="modal-dialog modal-lg">

                        <div class="modal-content">

                          <div class="modal-header no-padding">

                            <div class="table-header">Billing Information : <?php echo $rs['patientname']; ?></div>

                          </div>

                          <div class="modal-body no-padding" style="  max-height: 450px; min-height: 400px; overflow-y: auto;">

                            <div class="col-xs-12"> <br />

                              <form class="form-horizontal">

                                <div class="form-group">

                                  <label class="col-xs-2 control-label">Product Type</label>

                                  <div class="col-xs-2">

                                    <select class="form-control input-sm" name="ptype<?php echo $rs['id']; ?>" id="ptype<?php echo $rs['id']; ?>">

                                      <option>SELECT</option>

                                      <?php

											$q = mysqli_query($db,"SELECT distinct stocktype FROM tbl_productlist");

											while($r = mysqli_fetch_array($q)){

												echo '<option>'.$r['stocktype'].'</option>';

											}

										?>

                                    </select>

                                  </div>

                                  <label class="col-xs-2 control-label">Product Name</label>

                                  <div class="col-xs-3">

                                    <input type="text" class="form-control input-sm" name="pname<?php echo $rs['id']; ?>" id="pname<?php echo $rs['id']; ?>" placeholder="Product Name" list="lstProducts" onBlur="retBatchNo('<?php echo $rs['id']; ?>')">

                                  </div>

                                  <label class="col-xs-1 control-label">Batch #</label>

                                  <div class="col-xs-2">

                                    <select class="form-control input-sm" name="batch<?php echo $rs['id']; ?>" id="batch<?php echo $rs['id']; ?>" onChange="retExpiry('<?php echo $rs['id']; ?>')">

                                      <option>SELECT</option>

                                    </select>

                                  </div>

                                </div>

                                <div class="form-group">

								

								<label class="col-xs-2 control-label">Aval</label>

                                  <div class="col-xs-2">

                                    <select class="form-control input-sm" name="aval<?php echo $rs['id']; ?>" id="aval<?php echo $rs['id']; ?>">

                                      <option>SELECT</option>

                                    </select>

                                  </div>

								  

                                  <label class="col-xs-2 control-label">Expiry</label>

                                  <div class="col-xs-2">

                                    <select class="form-control input-sm" name="expiry<?php echo $rs['id']; ?>" id="expiry<?php echo $rs['id']; ?>">

                                      <option>SELECT</option>

                                    </select>

                                  </div>

                                  <label class="col-xs-1 control-label">Quantity</label>

                                  <div class="col-xs-1">

                                    <input type="text" class="form-control input-sm mand number" name="qty<?php echo $rs['id']; ?>" id="qty<?php echo $rs['id']; ?>" placeholder="0" onBlur="validateQty('<?php echo $rs['id']; ?>')">

                                  </div>

                                  <input type="button" class="btn btn-sm btn-info col-xs-1" value="Add" onClick="addXBillingItems('<?php echo $rs['id']; ?>')" />

                                </div>

                                <table id="tbl-list<?php echo $rs['id']; ?>" class="table table-striped">

                                  <thead>

                                    <tr>

                                      <th style="text-align:center">Code</th>

                                      <th style="text-align:center">Description</th>

                                      <th style="text-align:center">Freq.</th>

                                      <th style="text-align:center">Dur.</th>

                                      <th style="text-align:center">Spec.</th>

                                      <th style="text-align:center">Batch#</th>

                                      <th style="text-align:center">Expiry</th>

                                      <th style="text-align:center">Qty.</th>

                                      <th style="text-align:center">Amount</th>

                                      <th></th>

                                    </tr>

                                  </thead>

                                  <tbody>

                                  </tbody>

                                  <tfoot>

                                  </tfoot>

                                </table>

                              </form>

                            </div>

                          </div>

                          <div class="modal-footer no-margin-top">

                            <label class="pull-left col-xs-2">Total Amount : </label>

                            <label class="pull-left col-xs-1" id="lblAmount<?php echo $rs['id']; ?>">0.00</label>

                            <div class="pull-left col-xs-2">

                              <select id="paymentmode<?php echo $rs['id']; ?>" name="paymentmode<?php echo $rs['id']; ?>" class="form-control input-sm">

                                <option>SELECT</option>

                                <option>Cash</option>

                                <option>Card</option>

<option>Credit-Staff</option>

<option>Credit</option>

<option>Credit-NC</option>

<option>Credit-Claim</option>

                              </select>

                            </div>

                            <button type="button" class="btn btn-primary btn-sm" onClick="closeBill('<?php echo $rs['id']; ?>','0')">Close Bill</button>

                            <button type="button" class="btn btn-primary btn-sm" onClick="closeBill('<?php echo $rs['id']; ?>','1')">Close Bill & Print</button>

                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">X</button>

                          </div>

                        </div>

                      </div>

                    </div>

                    <?php } ?>

                  </div>

                  <!-- /.widget-main -->

                </div>

                <!-- /.widget-body -->

              </div>

              <!-- /.widget-box -->

            </div>

			

			

            <datalist id="lstProducts">

			

			

              <?php

					require_once("config.php");

					$rres = mysqli_query($db,"SELECT productname FROM tbl_productlist WHERE status = 1 ORDER BY productname asc");

					while($rrs = mysqli_fetch_array($rres)){

						echo '<option>'.$rrs['productname'].'</option>';

					}

				?>

            </datalist>

          </div>

          <?php } ?>

        </div>

        <!-- /.row -->

      </div>

      <!-- /.page-content -->

    </div>

  </div>

			  

             
              

            

              

            </div>


        </div>

        

      </div>

    </div>

  </div>

  <!-- /.main-content -->

  <<?php
  include('footer.php'); 
  ?>

  <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"> <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i> </a> </div>

<!-- /.main-container -->

<!-- basic scripts -->

<!--[if !IE]> -->





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

<!-- inline scripts related to this page -->

<script src="manage-bill/manage-bill.js"></script>

<script src="manage-bill/quick-bill.js?123"></script>

<script>

openmodal(<?php echo $id; ?>);

			function openmodal(x) {

			var s='modal-view'+x;

			

			//$('#modal-view7').fadeIn();  

			//$('#modal-view7').dialog({ show: 'fade' });

			$('#'+s).modal('toggle');

			//alert(s);

			}

</script>



</body>

<!-- Mirrored from responsiweb.com/themes/preview/ace/1.3.3/top-menu.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 May 2015 06:07:38 GMT -->

</html>

