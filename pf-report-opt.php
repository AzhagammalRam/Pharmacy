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
<title>PF Report</title>
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
	@media only screen and (max-width:992px){
		#usermenu {
			margin-top: 0px;
		}
	}
	</style>
  <!-- /.navbar-container -->
</div>
 <?php include('navigate.php'); ?>
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
            <h1> Report <small> <i class="ace-icon fa fa-angle-double-right"></i> PF Report </small> </h1>
          </div>
        <!-- /.page-header -->
        <div class="row">
          <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="center"> <br />
              <br />
              <br />
             <form class="form-horizontal" method="post" action="pf-report-opt.php">
                <div class="row">
                  <div class="form-group">
                    <label for="name"  class="col-xs-2 control-label">From</label>
                    <div class="col-xs-2">
                      <input type="text" value="<?php echo $_POST['dtfrom'] ?>" class="form-control" name="dtfrom" class="dtfrom" id="dtfrom" placeholder="DD/MM/YYYY">
                    </div>
                    <label for="name" class="col-xs-1 control-label">To</label>
                    <div class="col-xs-2">
                      <input type="text" class="form-control" value="<?php echo $_POST['dtto'] ?>" name="dtto" class="dtto" id="dtto" placeholder="DD/MM/YYYY">
                    </div>
                    <input type="hidden" value="<?php echo $_POST['productname'] ?>" id="getname" />

					<?php require("config.php");
						$query=mysqli_query($db,"select id,productname from tbl_productlist order by productname");
					?>
					<label for="name" class="col-xs-2 control-label">Drug Name</label>
                    <div class="col-xs-2">
                      <select class="form-control" name="productname" id="productname">
                        <option value="all">All</option>
                       <?php  
                       while($q=mysqli_fetch_array($query)) { 
							$prodname=$q["productname"];
							echo "<option value='$prodname' >$prodname</option>";
                		} 
                		?>
                      </select>
                    </div>
					</div><div class="form-group"><div class="col-xs-4"></div>
                    <div class="col-xs-1">
				  <input type="submit" value="Submit" class="btn btn-primary btn-sm col-xs-12"  />
				  </div>
				  <div class="col-xs-2">
				  <input type="button" value="Export to Excel" class="btn btn-primary btn-sm col-xs-12" onClick="vatPrintXLS()" />
				  </div>
                  </div>
                </div>
              </form>
              <br />
			  <table id="tbl-pur-rpt" class="table table-fixed">
<thead>
  <tr>
    <th style="text-align: center;">Generic Name</th>
	 <th style="text-align: center;">P.Inv No</th>
	 <th style="text-align: center;">Supplier</th>
	<th style="text-align: center;">Qty/strip</th>
    <th style="text-align: center;">Bat.no</th>
	   <th style="text-align: center;">Ex.Date</th>
    <th style="text-align: center;">MRP</th>
	
	<th style="text-align: center;">Inv.Date</th>
	<th style="text-align: center;">Entered By</th>
 </tr>
 
 <?php 
 require_once("config.php");
	$fromdate = $_REQUEST['dtfrom'];
	$fromto = $_REQUEST['dtto'];
	$pro = $_REQUEST['productname'];
	//$billtype = $_REQUEST['billtype'];
	
	$d1 = implode("-", array_reverse(explode("/",$fromdate)));
	if($fromto == "")	$d2 = $d1;
	else $d2 = implode("-", array_reverse(explode("/",$fromto)));
	$sql="SELECT tbl_productlist.id, tbl_productlist.productname, tbl_productlist.genericname, tbl_purchaseitems.productid, tbl_purchaseitems.qty, tbl_purchaseitems.batchno, tbl_purchaseitems.expirydate, tbl_purchaseitems.mrp, tbl_purchaseitems.username, tbl_purchase.invoicedate, tbl_purchase.invoiceno, tbl_supplier.id, tbl_supplier.suppliername FROM tbl_productlist JOIN tbl_purchaseitems ON tbl_productlist.id = tbl_purchaseitems.productid JOIN tbl_purchase ON tbl_purchaseitems.purchaseid = tbl_purchase.purchaseid JOIN tbl_supplier ON tbl_purchase.supplierid = tbl_supplier.id
 WHERE tbl_purchase.invoicedate BETWEEN  '$d1' AND '$d2' AND ";
	//$sql = "select totalamt, billno,patientname,cast(datentime as date) as billdate,drname FROM tbl_billing where (datentime BETWEEN '$d1' AND '$d2')  AND ";
	if($pro == "all")
		$sql .= "productname like '%'  ";
	else
		$sql .= "productname = '$pro'  ";
		
	
echo $pro;
echo ('---Purchase Analysis Report');
	$array1 = array();
	$res = mysqli_query($db,$sql);
	$xtotal = 0;
	while($rs = mysqli_fetch_array($res)){
		?>
		<tr><td><?php echo $rs['genericname']?></td>
        <td><?php echo $rs['invoiceno']?></td>
		 <td><?php echo $rs['suppliername']?></td>
        <td><?php echo $rs['qty']?></td>
        <td><?php echo $rs['batchno']?></td>
        <td><?php echo $rs['expirydate']?></td>
        <td><?php echo $rs['mrp']?></td>
       
        <td><?php echo $rs['invoicedate']?></td>
		<td><?php echo $rs['username']?></td>
        </tr>
		
<?php 
	}
	
	
 
 ?>
 
</thead>
<tbody>
</tbody>
</table>
             
<table id="tbl-sales-rpt" class="table table-fixed">
<thead>
  <tr>
    <th style="text-align: center;">Patient Name</th>
	<th style="text-align: center;">Bill No</th>
	<th style="text-align: center;">Qty/unit</th>
    <th style="text-align: center;">Bat.No</th>
	<th style="text-align: center;">Ex.Date</th>
    <th style="text-align: center;">MRP</th>
	<th style="text-align: center;">Bill.date</th>
</tr>

<?php 
 require_once("config.php");
	$fromdate = $_REQUEST['dtfrom'];
	$fromto = $_REQUEST['dtto'];
	$pro = $_REQUEST['productname'];
	//echo $pro;
	//$billtype = $_REQUEST['billtype'];
	
	$d1 = implode("-", array_reverse(explode("/",$fromdate)));
	if($fromto == "")	$d2 = $d1;
	else $d2 = implode("-", array_reverse(explode("/",$fromto)));
	$sql="SELECT tbl_productlist.id, tbl_productlist.productname, tbl_productlist.genericname, tbl_purchaseitems.productid, tbl_purchaseitems.batchno, tbl_purchaseitems.expirydate, tbl_purchaseitems.mrp,tbl_purchaseitems.datentime, tbl_billing_items.batchno, tbl_billing_items.qty, tbl_billing_items.billno, tbl_billing.billno, tbl_billing.patientname, tbl_billing.datentime
FROM tbl_productlist
JOIN tbl_purchaseitems ON tbl_productlist.id = tbl_purchaseitems.productid
JOIN tbl_billing_items ON tbl_purchaseitems.batchno = tbl_billing_items.batchno
JOIN tbl_billing ON tbl_billing_items.billno = tbl_billing.billno
WHERE tbl_billing.del_status != 1 AND tbl_purchaseitems.datentime BETWEEN '$d1' AND '$d2' AND ";
	//$sql="SELECT  tbl_productlist.id, tbl_billing.billno,tbl_purchaseitems.productid, productname, qty, batchno, expirydate, tbl_purchaseitems.mrp, aval,tbl_purchaseitems.datentime
//FROM tbl_productlist
//JOIN tbl_purchaseitems ON tbl_productlist.id = tbl_purchaseitems.productid    JOIN tbl_billing ON tbl_purchaseitems.id = tbl_billing.id      WHERE tbl_purchaseitems.datentime BETWEEN '$d1' AND '$d2' AND ";
	//$sql = "select totalamt, billno,patientname,cast(datentime as date) as billdate,drname FROM tbl_billing where (datentime BETWEEN '$d1' AND '$d2')  AND ";
	if($pro == "all")
		$sql .= "productname like '%'  ";
	else
		$sql .= "productname = '$pro'  ";
		
	
echo $pro;
echo ('---Sale Analysis Report');
	$array1 = array();
	$res = mysqli_query($db,$sql);
	$xtotal = 0;
	while($rs = mysqli_fetch_array($res)){
		?>
		<tr><td><?php echo $rs['patientname']?></td>
        <td><?php echo $rs['billno']?></td>
        <td><?php echo $rs['qty']?></td>
        <td><?php echo $rs['batchno']?></td>
        <td><?php echo $rs['expirydate']?></td>
        <td><?php echo $rs['mrp']?></td>
        <td><?php echo $rs['datentime']?></td>
        </tr>
		
<?php 
	}
	
 
 ?>
</thead>
<tbody>
</tbody>
</table>
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
<link rel="stylesheet" type="text/css" href="datetimepicker/jquery.datetimepicker.css"/ >

<script src="datetimepicker/jquery.datetimepicker.js"></script>
<script>
	$(document).ready(function () { 
		$('#dtfrom').datetimepicker({
		lang:'en',
		timepicker:false,
		format:'d/m/Y'
	});  
		$('#dtto').datetimepicker({
		lang:'en',
		timepicker:false,
		format:'d/m/Y'
	}); 

		$('#productname').val($('#getname').val()); 
});

	function vatPrintXLS(){
	var d1 = $('#dtfrom').val(), d2 = $('#dtto').val(), pn = $('#productname').val();
	if(d1 == "")
		return false;
	var data = "fromdate="+d1+"&todate="+d2+"&productname="+pn;
	window.open("manage-report/excel-pf-report.php?"+data)
}
</script>
</body>
<!-- Mirrored from responsiweb.com/themes/preview/ace/1.3.3/top-menu.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 May 2015 06:07:38 GMT -->
</html>
