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
<title>Billing</title>
<meta name="description" content="top menu &amp; navigation" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<!-- bootstrap & fontawesome -->
<link rel="stylesheet" href="dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="dist/css/bootstrap-select.min.css" />
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
<script src="dist/js/bootstrap-select.min.js"></script>
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
	@media only screen and (max-width:992px){
		#usermenu {
			margin-top: 0px;
		}
	}
	</style>
  <!-- /.navbar-container -->
</div>

 <?php
  $currenttab = 'sales';
  $currentPage = 'Billing';
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
      <h1> Sales <small> <i class="ace-icon fa fa-angle-double-right"></i> Billing </small> <a  class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#mdlNewBill" style="text-align:none;"> New Bill</a> </h1>
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
                            <input type="hidden" id="userrole" value="<?php echo $_SESSION['phar-role'] ?>" >
                  <div id="divUserList">
                    <?php 
							require_once("config.php");
							$res = mysqli_query($db,"SELECT * FROM tbl_billing WHERE status = 2 and del_status != 1");
							while($rs = mysqli_fetch_array($res)){ ?>
                    <div class="scroll-content col-xs-4">
                      <div class="itemdiv dialogdiv">
                        <div class="user"> <img alt="<?php echo $rs['patientname']; ?>" src="dist/avatars/user.png"> </div>
                        <a href="#" style="cursor:pointer;text-decoration:none;" data-toggle="modal" data-target="#modal-view<?php echo $rs['id']; ?>" data-whatever="<?php echo $rs['id']; ?>" data-backdrop="static">
                        <div class="body">
                          <div class="name"><?php echo $rs['patientname']; ?></div>
                          <div class="text"><i class="fa fa-user-md orange"></i> <?php echo $rs['drname']; ?></div>
                          <div class="tools"> <a href="javascript:deleteBill('<?php echo $rs['id']; ?>');" class="btn btn-minier btn-danger"> <i class="fa fa-trash"></i> </a> </div>
                        </div>
                        </a> </div>
                    </div>
                    
                    <div class="modal fade direct-bill" role="dialog" tabindex="-1" id="modal-view<?php echo $rs['id']; ?>">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header no-padding">
                            <div class="table-header">Billing Information : <?php echo $rs['patientname']; ?></div>
                          </div>
                          <div class="modal-body no-padding" style="  max-height: 450px; min-height: 400px; overflow-y: auto;">
                            <div class="col-xs-12"> <br />
                              <form class="form-horizontal">
                                <div class="form-group">
                                  <!-- <label class="col-xs-2 control-label">Product Type</label>
                                  <div class="col-xs-2">
                                    <select class="form-control input-sm" name="ptype<?php //echo $rs['id']; ?>" id="ptype<?php //echo $rs['id']; ?>" onchange="getval(this);">
                                      <option>SELECT</option>
                                      <?php
											// $q = mysqli_query($db,"SELECT distinct stocktype FROM tbl_productlist");
											// while($r = mysqli_fetch_array($q)){
											// 	echo '<option>'.$r['stocktype'].'</option>';
											// }
										?>
                                    </select>
                                  </div> -->
                                  <label class="col-xs-2 control-label">Product Name</label>
                                  <div class="col-xs-3">
                                    <input type="text" class="form-control input-sm" tabIndex="1" name="pname<?php echo $rs['id']; ?>" id="pname<?php echo $rs['id']; ?>" placeholder="Product Name" list="lstProducts" onBlur="retBatchNo('<?php echo $rs['id']; ?>')">
                                  </div>
                                  <?php include("config.php"); 
                                 if($config['module']['murugan'] == false ) {?>
                                  <label class="col-xs-1 control-label">Supplier #</label>
                                  <div class="col-xs-2">
                                    <select class="form-control input-sm" tabIndex="12" name="suplr<?php echo $rs['id']; ?>" id="suplr<?php echo $rs['id']; ?>" onChange="returnbatExpiry('<?php echo $rs['id']; ?>')">
                                      <option>SELECT</option>
                                    </select>
                                  </div>
                                  <?php } ?>
                                  <label class="col-xs-1 control-label">Batch #</label>
                                  <div class="col-xs-2">
    <select  class="form-control input-sm" tabIndex="2" name="batch<?php echo $rs['id']; ?>" id="batch<?php echo $rs['id']; ?>" onChange="qbreturnExpiry('<?php echo $rs['id']; ?>')">
                                      <option>SELECT</option>
                                    </select>
                                  </div>


                                  <!-- <label class="col-xs-2 control-label">Date</label>
                                  <div class="col-xs-2">
                                  <input type="text"  class="form-control input-sm mand invoicedate" placeholder="YYYY/MM/DD" name="invoicedate<?php echo $rs['id']; ?>" id="invoicedate<?php echo $rs['id']; ?>"/></div> -->
                                </div>
                                <div class="form-group">
								
								 <label class="col-xs-1 control-label">Aval</label>
                                  <div class="col-xs-2">
                                    <input type="hidden"  name="expiryval<?php echo $rs['id']; ?>" id="expiryval<?php echo $rs['id']; ?>"/>
                                    <input type="text" readonly class="form-control input-sm" name="aval<?php echo $rs['id']; ?>" id="aval<?php echo $rs['id']; ?>"/>
                                      
                                  </div>
								  
                                  <label class="col-xs-1 control-label">Expiry</label>
                                  <div class="col-xs-2">
                                    <input type="text" readonly class="form-control input-sm"  name="expiry<?php echo $rs['id']; ?>" id="expiry<?php echo $rs['id']; ?>"/>
                                     
                                    
                                  </div>
                                  <label class="col-xs-2 control-label">Quantity</label>
                                  <div class="col-xs-2">
                                  <input type="text" class="form-control input-sm mand number positive" tabIndex="13" name="qty<?php echo $rs['id']; ?>" id="qty<?php echo $rs['id']; ?>" placeholder="0" onBlur="validateQty('<?php echo $rs['id']; ?>')">
                                  </div></div>
                                  <div class="form-group">
                                  
                                  <input type="button" class="btn btn-sm btn-info col-xs-1" tabIndex="14" value="Add" onClick="addBillingItems('<?php echo $rs['id']; ?>')" style="float:right; 
  right: .5em;" />
                                  </div>
                                  
                                <table id="tbl-lists<?php echo $rs['id']; ?>" class="table table-striped">
                                  <thead>
                                    <tr>
                                      <th style="text-align:center">Code</th>
                                      <th style="text-align:center">Type</th>
                                      <th style="text-align:center">Description</th>
                                      <th style="text-align:center">Qty.</th>
                                      <th style="text-align:center">Suplier</th>
                                      <th style="text-align:center">Batch#</th>
                                      <th style="text-align:center">Expiry</th>
                                      <th style="text-align:center">Tax %</th>
									                    <th style="text-align:center">Amount</th>
                                      <th style="text-align:center">Action</th>
                                      
                                    </tr>
                                    
<?php
 $aid=$rs['id'];
 include("config.php");
  $x=0;
  $sql= "select * from `$pharmacydb`.`tbl_billing_items` where bid = '$aid' and del_status != 1";
     $result=mysqli_query($db,$sql);
  while($row=mysqli_fetch_array($result))
  {
    $puritm_id= explode('-', $row['purchaseid']);
    $puritm_id = $puritm_id[0];
    
    $pur = mysqli_fetch_array(mysqli_query($db,"Select * from tbl_purchaseitems where id= '$puritm_id'"));
    $pur_id = $pur['purchaseid'];
  
   
    $sup_1 =mysqli_fetch_array(mysqli_query($db,"select b.suppliername,b.id from tbl_purchase a join tbl_supplier b on a.supplierid = b.id where a.purchaseid= (select purchaseid from tbl_purchaseitems where id = $puritm_id)")); 
    $sup_nm = $sup_1['suppliername'];
    $sup_id = $sup_1['id'];
    $xid=$row['id'];
    $pid=$row['code'];
    $bat_ch =  $row['batchno']; 
    $sql1= "select * from `$pharmacydb`.`tbl_productlist` where id = '$pid'";
     $result1=mysqli_query($db,$sql1);
  while($row1=mysqli_fetch_array($result1))
  {
$x+=$row['amount'];
 ?>


                              <tr>
                                      <td style="text-align:center" id="codei<?php echo $row['id']; ?>"><?php echo $row['code']; ?></td>
                                      <td style="text-align:center"><?php echo $row1['stocktype']; ?></td>
                                      <td style="text-align:center"><?php echo $row1['productname']; ?></td>
                                      <td style="text-align:center"><input type="text" class="edqty" onkeypress = "return qtycheck(event);" data-qty="<?php echo $row['qty']; ?>" id="edqty<?php echo $row['id']; ?>"  value="<?php echo $row['qty']; ?>" onBlur="edittotal(<?php echo $row['id']; ?>,<?php echo $rs['id']; ?> )" style="width:50px; height:30px;" ></td>
                                      <!-- <td style="text-align:center"><input type="text" class="edqty" onkeypress = ""  id="edsup<?php echo $row['id']; ?>"  value="<?php echo $sup_nm; ?>" onBlur="edittotal(<?php echo $row['id']; ?>,<?php echo $rs['id']; ?> )" style="width:50px; height:30px;" ></td> -->
                                      <td style="text-align:center">
        <select class="form-control input-sm" name="edsup<?php echo $row['id']; ?>"  id="edsup<?php echo $row['id']; ?>" onchange="editsupplier(<?php echo $row['id']; ?>,'edbat<?php echo $row['id']; ?>','#tbl-lists<?php echo $rs['id']; ?>' )">
                                        <option>SELECT</option>
                                        <?php
          $format_dt = 'Y/m/d '; 
           $d_t = date ( $format_dt, strtotime ( '+90 days' ) );
          $x_dt = date ( $format_dt);
          $sup_sql =mysqli_query($db,"select  distinct(c.suppliername),c.id from tbl_purchaseitems a join tbl_purchase b on a.purchaseid= b.purchaseid join tbl_supplier c on b.supplierid=c.id where a.productid = $pid and a.aval >= 0 and a.expirydate >= '$x_dt'");
                                        while($rs_sup2 = mysqli_fetch_array($sup_sql)){   
                                        $sup_nm2 = $rs_sup2['suppliername'];
                                        $sup_id2 = $rs_sup2['id'];
                                         ?>
                                        <option value="<?php echo $sup_id2; ?>" <?php if($sup_id2 ==  $sup_id ): ?> selected="selected"<?php endif; ?>><?php echo $sup_nm2; ?></option>
                                        <?php  
                                        }
                                        ?>
                                      </select></td>

                                        <td style="text-align:center">
        <select class="form-control input-sm" name="edbat<?php echo $row['id']; ?>"  id="edbat<?php echo $row['id']; ?>" onchange="editbatch(<?php echo $row['id']; ?>,'<?php echo $row['purchaseid']; ?>','#tbl-lists<?php echo $rs['id']; ?>' )">
                                        <option>SELECT</option>
                                        <?php
         $bt_sql =mysqli_query($db,"select a.* from tbl_purchaseitems a join tbl_purchase b on a.purchaseid = b.purchaseid where a.productid = '$pid' and a.aval >= 0 and a.expirydate >= '$x_dt'");
          while($rs_bt = mysqli_fetch_array($bt_sql)){   
          $bt_no = $rs_bt['batchno'];
          $purbt_id = $rs_bt['purchaseid'];
          $tbl_pur_id = $rs_bt['id'];
                                        ?>
          <option value="<?php echo $tbl_pur_id; ?>" <?php if($purbt_id ==  $pur_id ): ?> selected="selected"<?php endif; ?>><?php echo $bt_no; ?></option>
                                        <?php  
                                        }
                                        ?>
                                      </select></td>





        <!-- <td style="text-align:center"><?php echo $row['batchno']; ?></td> -->
        <td style="text-align:center"><input type="text" id="edexp<?php echo $row['id']; ?>" class="edttl"  value="<?php echo $row['expirydate']; ?>" disabled style="width:80px; height:30px;"></td> 
        <!-- <td style="text-align:center"><?php echo $row['expirydate'];  ?></td> -->
        <td style="text-align:center"><?php echo $row['tax_percentage']; ?></td>
        <td style="text-align:center"><input type="text" id="edttl<?php echo $row['id']; ?>" class="edttl" data-qty="<?php echo $row['amount']; ?>" value="<?php echo $row['amount']; ?>" disabled style="width:80px; height:30px;"></td> 
        <td style="text-align:center"><img src='images/delete.png' style='height:24px; cursor:pointer;' onClick='javascript:deleteItem(this,<?php echo $xid; ?>)'></td>
        
      </tr>

<?php 

 }

}
 ?>
                

                                  </thead>
                                  <tbody>
                                  </tbody>
                                </table>
                              </form>
                            </div>
                          </div>
                          <div class="modal-footer no-margin-top">
                            <label class="pull-left col-xs-2">Total Amount : </label>
                            <label class="pull-left col-xs-1" id="lblAmount<?php echo $rs['id']; ?>"><?php echo $x; ?></label>
							              <input type="hidden" id="insur<?php echo $rs['id']; ?>" value = "1" />
                            <div class="pull-left col-xs-2">
                              <select id="paymentmode<?php echo $rs['id']; ?>" tabIndex="5" name="paymentmode<?php echo $rs['id']; ?>" class="form-control input-sm">
                                <option>SELECT</option>
                                <option>Cash</option>
                                <option>Card</option>
                                <option>Credit-Staff</option>
                              </select>
                            </div>
							 <div class="pull-left col-xs-2">
                              <input type="text" name="discount<?php echo $rs['id']; ?>" tabIndex="6" id="discount<?php echo $rs['id']; ?>" Placeholder="Discount %" class="form-control input-sm" onBlur="getdiscount(<?php echo $rs['id']; ?>)">
                              
                            </div>
							
							 <div class="pull-left col-xs-1">
                              <input type="text" name="reminder<?php echo $rs['id']; ?>" id="reminder<?php echo $rs['id']; ?>" Placeholder="SMS" class="form-control input-sm  mand number " onBlur="getdiscount(<?php echo $rs['id']; ?>)">
                              
                            </div>
                            <button type="button" class="btn btn-primary btn-sm" tabIndex="7" onClick="closeBill('<?php echo $rs['id']; ?>','0')">Close Bill</button>
                            <button type="button" class="btn btn-primary btn-sm" tabIndex="8" onClick="closeBill('<?php echo $rs['id']; ?>','1')">Close Bill & Print</button>
                            <button type="button" class="btn btn-default btn-sm"  tabIndex="9" onClick="closemodal(<?php echo $rs['id']; ?>)">Hold</button>
                            <!-- <div class="row no-margin-top"> -->
                              <!-- <label class="pull-left col-xs-2">Select Currency : </label> -->
                              <!-- <div class="pull-left col-xs-2"> -->
      <!-- <select id="currency<?php //echo $rs['id']; ?>" name="currency<?php //echo $rs['id']; ?>" class="form-control input-sm" onChange="change_currency(<?php //echo $rs['id']; ?>);return false;"> -->
                                  <!-- <option value="">Select</option> -->
                                 <!-- <?php 
                                  // include("../config.php");
                                  // $sql1 = "SELECT * FROM `tbl_currency` WHERE `base_currency` = '0' and `status` = '1'";
                                  // $res1 = mysqli_query($db,$sql1);
                                  // $rs1 = mysqli_fetch_array($res1);
                                  // if($rs1 != ''){
                                  // while($rs1 = mysqli_fetch_array($res1)){
                                  //   $id=$rs1['id'];
                                  //   $name=$rs1['currency'];
                                  ?>
                                  <option value="<?php //echo $id; ?>"><?php //echo $name; ?></option>
                                  <?php //} } ?>
                                </select> -->
                                                           <!-- </div> -->
                              <!-- <label class="pull-left col-xs-2">Converted Amount :</label> -->
                        <!-- <input type="hidden" name="currency_id<?php echo $rs['id']; ?>" id="currency_id<?php echo $rs['id']; ?>" /> -->
                              <!-- <div class="pull-left col-xs-2" id="currency_value<?php echo $rs['id']; ?>"> -->
                                <!-- <input type='text' id='currency_value' name='currency_value'  /> -->
                              <!-- </div> -->
                            <!-- </div> -->

                            <!-- UnComment for Currency  -->
                            <label class="pull-left col-xs-2">Discount(Rs.): </label>
                            <label class="pull-left col-xs-1" id="discountamount<?php echo $rs['id']; ?>"></label>
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
            <!-- <div class="widget-header"> -->
              <!-- <h4 class="widget-title lighter smaller"> <i class="ace-icon fa fa-cogs blue"></i> Patients Bills </h4> -->
            <!-- </div> -->
            <div class="widget-body">
              <div class="widget-main no-padding">
                <!-- <div class="dialogs ace-scroll"> -->
                  <div class="scroll-track scroll-active" style="display: block; height: 300px;">
                    <div class="scroll-bar" style="height: 262px; top: 0px;"></div>
                  </div>
                  <div id="divUserList">
                    <?php 
							require_once("config.php");
							$res = mysqli_query($db,"SELECT * FROM tbl_billing WHERE status = 3 and del_status != 1");
							while($rs = mysqli_fetch_array($res)){ ?>
                    <div class="scroll-content col-xs-4">
                      <div class="itemdiv dialogdiv">
                        <div class="user"> <img alt="<?php echo $rs['patientname']; ?>" src="dist/avatars/user.png"> </div>
                        <a href="#" style="cursor:pointer;text-decoration:none;" data-toggle="modal" data-target="#modal-view<?php echo $rs['id']; ?>" data-whatever="<?php echo $rs['id']; ?>" data-backdrop="static" >
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
                                    <input type="text" class="form-control input-sm mand number positive" name="qty<?php echo $rs['id']; ?>" id="qty<?php echo $rs['id']; ?>" placeholder="0" onBlur="validateQty('<?php echo $rs['id']; ?>')">
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
                <!-- </div> -->
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
  <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="mdlNewBill">
    <div class="modal-dialog modal-xs">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">New Bill</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal">
            <div class="form-group">
              <label class="col-xs-3 control-label">Patient Name</label>
              <div class="col-xs-8">
                <input type="text" class="form-control input-sm mand" name="patientname" id="patientname" placeholder="Patient Name">
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-3 control-label">Doctor Name</label>
              <div class="col-xs-8">
                <input type="text" class="form-control input-sm" name="drname" id="drname" placeholder="Doctor Name">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-sm" onClick="createNewBill1()">Create Bill</button>
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="patModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="exampleModalLabel">Update Product Details</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" id="updForm">
		  	<input type="hidden" id="dbval" name="dbval" />
			<input type="hidden" id="trval" name="trval" />
            <div class="form-group">
              <label class="col-xs-3 control-label">Product Type</label>
              <div class="col-xs-2">
                <select class="form-control input-sm" name="xptype" id="xptype" disabled >
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
              <div class="col-xs-4">
                <input type="text" class="form-control input-sm" name="xpname" id="xpname" placeholder="Product Name" readonly>
              </div>
            </div>
            <div class="form-group">
              <label class="col-xs-2 control-label">Batch #</label>
              <div class="col-xs-2">
                <select class="form-control input-sm" name="xpbatch" id="xpbatch" onChange="retX1Expiry()">
                  <option>SELECT</option>
                </select>
              </div>
			   <label class="col-xs-2 control-label">Aval</label>
              <div class="col-xs-2">
                <select class="form-control input-sm myalert" name="paval" id="paval">
                  <option>SELECT</option>
                </select>
              </div>
			  
              <label class="col-xs-2 control-label">Expiry</label>
              <div class="col-xs-2">
                <select class="form-control input-sm myalert" name="pexpiry" id="pexpiry">
                  <option>SELECT</option>
                </select>
              </div>
              <label class="col-xs-2 control-label">Quantity</label>
              <div class="col-xs-1">
                <input type="text" class="form-control input-sm mand number positive" name="pqty" id="pqty" placeholder="0" onBlur="validateX1Qty()">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-sm" onClick="updatePItems()">Save</button>
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        </div>
      </div>
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
<script src="manage-bill/quick-bill.js"></script>
<link rel="stylesheet" type="text/css" href="datetimepicker/jquery.datetimepicker.css"/ >
<script src="datetimepicker/jquery.datetimepicker.js"></script>
<!-- <script>
  $(document).ready(function () { 
    $('.invoicedate').datetimepicker({
      lang:'en',
      timepicker:false,
      format:'d-m-Y',
    }); 
  });
</script> -->
<script>
openmodal(<?php echo $id; ?>);
			function openmodal(x) {
			var s='modal-view'+x;
			
			//$('#modal-view7').fadeIn();  
			//$('#modal-view7').dialog({ show: 'fade' });
			$('#'+s).modal('toggle');
			//alert(s);
			}


      function editbatch(x,y,tblid)
{

   var prod = $('#codei'+x).val(), batch = $('#edbat'+x).val();
   var  qty =  $('#edqty'+x).val();
   qty = parseInt(qty);
  if(batch == 'SELECT') return false;
     if(batch == 'SELECT') return false;
  $.ajax({
    type: 'post',
    url: 'manage-bill/return-aval.php?prod='+encodeURIComponent(prod)+"&batch="+batch+"&editbatch=1",
    success: function(msg) {
      aval = parseInt(msg);
      if(aval < qty || aval == 0 )
      {
        if(aval < 0)
        {
          aval = 0;
        }
        alert("Avalable Quantity is "+aval);
        $('#edbat'+x).attr("disabled", true);
        $(tblid).load(location.href +" "+tblid);
        return false;
      }
      else{
        var codei=$('#codei'+x).html();
  var edbat = $('#edbat'+x).val();

  $.ajax({
    type: 'post',
    url: 'edit_batch.php',
    data: {
      id: x,
      oldpur_itm: y,
      bat_purid: edbat,
      code:codei
    },
    success: function(msg){
      // alert(msg);
       var xx = msg.split("~~");
       // alert (xx[0]);
       $('#edexp'+x).val(xx[0]);
       jQuery('#edsup'+x).html(xx[1]);
    }
  });
      }
      
     }
  });

}

function editsupplier(x,y,tblid)
{
  var codei=$('#codei'+x).html();
  var edsup = $('#edsup'+x).val();
  $.ajax({
    type: 'post',
    url: 'editsup_batch.php',
    data: {
      id: x,
      sup_id: edsup,
      code:codei
    },
    success: function(msg){
      // alert(msg);
        var xx = msg.split("~~");     
        if(xx[0] == 1)
        {
          alert("Selected supplier does not have enough quantity");
           $('#edsup'+x).attr("disabled", true);
           $(tblid).load(location.href +" "+tblid);
        return false;
      }  else{

       $('#edexp'+x).val(xx[0]);
     jQuery('#edbat'+x).html(xx[1]);
      }
      
    }
  });
}
      function edittotal(x,y)
{
  var sumt=0;
  var total=0;
  var sumt1=0;
  var y=y;
  var edqty1=$('#edqty'+x).val();
  var edttl1=$('#edttl'+x).val();
  var sumb=$('#lblAmount'+y).html();

  var codei=$('#codei'+x).html();
  var bqty=$('#edqty'+x).attr('data-qty');
  var bedttl1=$('#edttl'+x).attr('data-qty');
 // alert(bqty)
  total = (parseFloat(bedttl1)/parseFloat(bqty))*parseFloat(edqty1);
  
 // sumt1=parseFloat(bedttl1)-parseFloat(total);
  //sumt=parseFloat(sumb)-parseFloat(sumt1)
 
  $('#edttl'+x).val(total);
  $('#edqty'+x).val(edqty1);
 // $('#lblAmount'+y).html(sumt);
  $.ajax({
    type: 'post',
    url: 'billqtyupdate.php',
    data: {
      id: y,
      qty: edqty1,
      total: total,
      code:codei
    },
    success: function(msg){
       //var sumb=$('#lblAmount'+y).html();
       //alert(sumb)
      
       var sumt=parseFloat(sumb)+parseFloat(msg);
       $('#lblAmount'+y).html(sumt).toFixed(2);
       //alert(x)
      //alert(msg)
      //$('#lblAmount'+y).val(msg);
    }
  });
  //alert(sumt);
  // $('#ttl').val('');
       // $('#ttl').html(total);
    
}
$(function() {
   $('input,select').on('keypress', function(e) {
        e.which !== 13 || $('[tabIndex=' + (+this.tabIndex + 1) + ']')[0].focus();
    });
});
</script>
</body>
<!-- Mirrored from responsiweb.com/themes/preview/ace/1.3.3/top-menu.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 May 2015 06:07:38 GMT -->
</html>
<script>
  function change_currency(x) {

   var currency=$("#currency"+x+" option:selected").val();
   var total=parseFloat($('#lblAmount'+x).html());

    $.ajax({
        type: 'post',
        url: 'currency_exchange_rate.php',
        data: {
        currency: currency
      },
      success: function(msg){
        var y = JSON.parse(msg);
        var exchange_rate = parseFloat(y.exchange_rate);
        var id=y.id;
         $('#currency_value'+x).html((total*exchange_rate));
         $('#currency_id'+x).val(id);
      }
    });
  }  
</script>
<script>
shortcut.add("Shift+P",function() {
  // alert("x");
  // var button = $(event.relatedTarget);
  var x=<?php if($_GET['id'] !=''){ echo $_GET['id']; } else { echo 0; } ?>;
  // alert(x);
  closeBill(x,1);
});

$(".positive").blur(function(){
  var x = $(this);
  var y = x.val();
  if(y < 0){ x.css("border","2px dotted red"); x.val(''); return false; }
  else{ x.css("border","1px solid #d5d5d5"); }
});

function qtycheck(event) {
  if ((event.keyCode >= 48 && event.keyCode <= 57) || event.keyCode === 13) {
    return true;
  } else {
    return false;
  }

}
</script>