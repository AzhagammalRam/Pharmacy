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
<title>Purchase Return Report</title>
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
 <?php 
 $currenttab = 'Reports';
 $currentPage = 'Purchase_Return_Report';
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
            <h1> Report <small> <i class="ace-icon fa fa-angle-double-right"></i> Purchase Return Report </small> </h1>
          </div>
        <!-- /.page-header -->
        <div class="row">
          <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="center"> <br />
              <br />
              <br />
             <form class="form-horizontal">
                <div class="row">
                  <div class="form-group">
                    <label for="name" class="col-xs-2 control-label">From</label>
                    <div class="col-xs-2">
                      <input type="text" class="form-control" name="dtfrom" id="dtfrom" placeholder="DD/MM/YYYY">
                    </div>
                    <label for="name" class="col-xs-1 control-label">To</label>
                    <div class="col-xs-2">
                      <input type="text" class="form-control" name="dtto" id="dtto" placeholder="DD/MM/YYYY">
                    </div></div>
                     <div class="row">
                  <div class="form-group">
                    <label for="name" class="col-xs-2 control-label">Return Invoice</label>
                    <div class="col-xs-2">
                       <input type="text" class="form-control" name="invoice" id="invoice" placeholder="Return Invoice #">
                    </div>
                    <label for="supplier" class="col-xs-1 control-label">Supplier</label>
                     <div class="col-xs-2">
                        <input type="text" class="form-control" name="supplier" id="supplier"  placeholder="Supplier Name" list="lstSupplier" >
                        <datalist id="lstSupplier">
                          <?php
              require_once("config.php");
              $res = mysqli_query($db,"SELECT * FROM tbl_supplier WHERE status = 1");
              while($rs = mysqli_fetch_array($res)){
                echo '<option>'.$rs['suppliername'].'</option>';
              }
            ?>
                        </datalist>
                      </div>

          
          </div><div class="form-group"><div class="col-xs-4"></div>
                    <div class="col-xs-1">
          <input type="button" value="Submit" class="btn btn-primary btn-sm col-xs-12" onClick="rptDisplay()" />
          </div>
          <div class="col-xs-2">
          <input type="button" value="Export to Excel" class="btn btn-primary btn-sm col-xs-12" onClick="rptPrintXLS()" />
          </div>
                  </div>
                </div>
              </form>
              <br />
             <table id="tbl-purchase-return" class="table table-fixed">
<thead>
  <tr>
    <th style="text-align: center;">Date</th>
    <th style="text-align: center;">Return Invoice</th>
    <th style="text-align: center;">Supplier Name </th>
    <th style="text-align: center;">Return Amount</th>
  </tr>
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
<?php include('manage-bill/includebill.php'); ?>
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
    format:'Y-m-d',
    maxDate:0,
  });  
    $('#dtto').datetimepicker({
    lang:'en',
    timepicker:false,
    format:'Y-m-d',
    maxDate:0,
  }); 
});
function rptPrintXLS(){
  var d1 = $('#dtfrom').val(), d2 = $('#dtto').val(), pm = $('#paymentmode').val();
  if(d1 == "")
    return false;
  var data = "fromdate="+d1+"&todate="+d2+"&paymentmode="+pm;
  window.open("manage-report/excel-purchase-report.php?"+data)
}
  function rptDisplay(){
  if($.trim($('#dtfrom').val())== ""){ $('#dtfrom').css("border","2px dotted red"); return false; }
  else{ $('#dtfrom').css("border","1px solid #d5d5d5"); }
  if($.trim($('#dtto').val())== ""){ $('#dtto').css("border","2px dotted red"); return false; }
  else{ $('#dtto').css("border","1px solid #d5d5d5"); }

  var d1 = $('#dtfrom').val(), d2 = $('#dtto').val(), invoice = $('#invoice').val(),supplier = $('#supplier').val();
  var table = $("#tbl-purchase-return > tbody");
  // if(d1 == "")
  //  return false;
  $.ajax({
    type: 'post',
    url: 'manage-report/return-purchasereturn-report.php',
    data: {
      dtfrom: d1,
      dtto: d2,
      invoice: invoice,
      supplier:supplier
    },
    success: function(msg) {console.log(msg);
      table.empty();
      var x = JSON.parse(msg);

      for(var i = 0; i < x.length; i++){
        var tr = "<tr><td style='text-align:center;'>"+x[i].date+"</td><td style='text-align:center;cursor:pointer;'><a href='purchase-returnbill.php?rid="+x[i].id+"' target = 'new window'>"+x[i].return_invoice+"</a></td><td style='text-align:center;'>"+x[i].supplier+"</td><td style='text-align:center;'>"+x[i].totalamt+"</td></tr>";
         $(table).append(tr);
      }
      $('#dtfrom').val('');
        $('#dtto').val(''); $('#invoice').val(''); $('#supplier') .val('');
      // var tr = "<tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th style='text-align: right;'>Total</th><th style='text-align:center;'>"+x[i].tamt+"</th></tr>";
      // $(table).append(tr);
    }
  });
}
</script>
</body>
<!-- Mirrored from responsiweb.com/themes/preview/ace/1.3.3/top-menu.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 May 2015 06:07:38 GMT -->
</html>
