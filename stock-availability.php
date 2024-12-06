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
<title>Stock Availability</title>
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
.tdhide{
	display:none;
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
 $currenttab = 'Stocks';
 $currentPage = 'Stock_Availability';
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
            <h1> Stock <small> <i class="ace-icon fa fa-angle-double-right"></i> Stock Availability </small> </h1>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="row">
                <div class="col-xs-12">
                  <div class="table-header"> List of Products & Availability <div style="float:right" class="col-xs-2">
				  <!-- <input type="button" id="printpage" value="Print PDF" class="btn btn-primary btn-sm col-xs-12" onclick="printDiv();"/> -->
				  </div> </div>
          <div class="col-xs-1">
          <input type="button" value="Excel" class="btn btn-primary btn-sm" onClick="rptPrintXLS()" />
          </div>






                  <div>

                    <table id="table-user-list" class="table table-striped table-bordered table-hover">

                      <thead>
                        <tr>
                          <th class="center">SNo</th>
						  						<th>Product Type</th>
                          <th>Product Name</th>
                          <th style="text-align: center;">Generic Name</th>
                          <th>Batch #</th>
                          <?php
                          if($_SESSION['phar-role']=='1')
                            echo"<th>Supplier</th>"
                          ?>
                          
                          <th>Pharma</th>
						              <th>Expiry</th>
						              <th>Availability</th>
                          <th>Shelf</th>
                          <th>Rack</th>
                           <?php
                          if($_SESSION['phar-role']=='1')
                            echo"<th>Cost</th>"
                          ?>
                          
                          <th>MRP</th>
                          <th>Store</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
					  <tfoot>
            <tr>
                <th colspan="11" style="text-align:center;"></th>
                <th style="text-align:center"></th>
                <th></th>
            </tr>
        </tfoot>
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
                              <th scope="row" style="vertical-align:middle;">MRP</th>
                              <td id="vmrp"></td>
                              <th scope="row" style="vertical-align:middle;">Unit Price</th>
                              <td id="vprice"></td>
                            </tr>
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
  <?php include('manage-bill/includebill.php'); ?>
<script type="text/javascript">
			window.jQuery || document.write("<script src='dist/js/jquery.min.js'>"+"<"+"/script>");
		</script>
<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='dist/js/jquery1x.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
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
<!-- <script src="//code.jquery.com/jquery-1.12.4.js"></script> -->
<script src="dist/js/jquery.dataTables.min.js"></script>
<script src="dist/js/dataTables.buttons.min.js"></script>
<script src="dist/js/buttons.print.min.js"></script>


<style>

  #table-user-list_wrapper > .dt-buttons span{
    /*border: 2px solid #307ecc;
    padding: 5px 14px;
    background: #307ecc;
    color: white;
    position: absolute;
    float: right;
    clear: both;*/
  }
.buttons-print{

   background-color: #387fc7;
   padding: 7px;
   border: 1px #438eb9;
   color: #fff;
  }

  .btn-sm{
     padding: 2px;
  }

</style>
<script type="text/javascript">
	jQuery(function($) {
		//initiate dataTables plugin
    var myvar = "<?php echo $_SESSION['phar-role'] ?>" ;
    
    if(myvar=='1'){
		var oTable1 =
		$('#table-user-list').dataTable( {
			bAutoWidth: false,
       dom: 'Bfrtip',
        buttons: [
            'print'
        ],
			"bProcessing": true,
			"sAjaxSource": "manage-stock/return-stock-avail.php",
			"aoColumns": [
				{ mData: '#',"bSortable": true, "sClass": "tdcenter"},
				{ mData: 'type' },
				{ mData: 'product' },
        { mData: 'generic'},
				{ mData: 'batch', "sClass": "tdcenter" },
        { mData: 'supplier', "sClass": "tdcenter" },
        { mData: 'pharma', "sClass": "tdcenter" },
				{ mData: 'expiry', "sClass": "tdcenter" },
				{ mData: 'avail', "sClass": "tdcenter" },
				{ mData: 'shelf', "sClass": "tdcenter" },
				{ mData: 'rack', "sClass": "tdcenter" },
        		{ mData: 'cost', "sClass": "tdcenter" },
				{ mData: 'mrp', "sClass": "tdcenter" },
				{ mData: 'branch', "sClass": "tdcenter" },
				{ mData: 'alrt',"bSortable": false, "sClass": "tdhide" },
			],
			"aaSorting": [],
			"fnInitComplete": function(oSettings, json) {
				$("#table-user-list > tbody > tr").each(function(item,i) {
					if($(this).find('td').eq(8).text() == '1'){
						$(this).css('background-color','rgba(255, 0, 0, 0.4)');
					}
				});
			},
      "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column( 12 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Total over this page
            pageTotal = api
                .column( 12, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 12 ).footer() ).html(
               'Total: \n '+ Math.round(pageTotal) + '<br/>' +' ( Grand: '+ Math.round(total) +' )'
            );


            // Total over all pages
            total1 = api
                .column( 11 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Total over this page
            pageTotal1 = api
                .column( 11, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 11 ).footer() ).html(
               'Total:  ' + Math.round(pageTotal1) + '<br/>' +'( Grand: '+ Math.round(total1) +' )'
            );
        }

		} );
  }else if(myvar=='2')
  {
    var oTable1 =
    $('#table-user-list').dataTable( {
      bAutoWidth: false,
       dom: 'Bfrtip',
        buttons: [
            'print'
        ],
      "bProcessing": true,
      "sAjaxSource": "manage-stock/return-stock-avail.php",
      "aoColumns": [
        { mData: '#',"bSortable": true, "sClass": "tdcenter"},
        { mData: 'type' },
        { mData: 'product' },
        { mData: 'generic'},
        { mData: 'batch', "sClass": "tdcenter" },
        { mData: 'pharma', "sClass": "tdcenter" },
        { mData: 'expiry', "sClass": "tdcenter" },
        { mData: 'avail', "sClass": "tdcenter" },
        { mData: 'shelf', "sClass": "tdcenter" },
        { mData: 'rack', "sClass": "tdcenter" },
            
        { mData: 'mrp', "sClass": "tdcenter" },
        { mData: 'branch', "sClass": "tdcenter" },
        { mData: 'alrt',"bSortable": false, "sClass": "tdhide" },
      ],
      "aaSorting": [],
      "fnInitComplete": function(oSettings, json) {
        $("#table-user-list > tbody > tr").each(function(item,i) {
          if($(this).find('td').eq(8).text() == '1'){
            $(this).css('background-color','rgba(255, 0, 0, 0.4)');
          }
        });
      },
      "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
           
            // Total over all pages
            
        }

    } );
  }
	});
</script>
 <script>


function avlPrintpdf(){

	window.open("manage-report/print-avl-report.php?");

}

function rptPrintXLS(){
  window.open("manage-report/excel-stock-report.php?");
}

 </script>
</body>
</html>
