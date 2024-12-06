
<?php
  session_start();
  if (!isset($_SESSION['phar-username']) || (trim($_SESSION['phar-username']) == '')) {
      header("location:login.php");
      exit();
  }
  
  if ($_SESSION['days'] <= -0) {
      echo '<script> alert("Your licence expired please contact Raagaamed admin"); window.open("", "_self").close(); </script>';
      header("location:license-expired.php");
      exit();
  }
  
  require_once("config.php");
  $bill_no = '""';
  if (isset($_REQUEST['billno'])) {
      $opt = $_REQUEST['billno'];
      mysqli_query($db, "UPDATE tbl_billing SET status = 8 WHERE (billno = '$opt' OR phno = '$opt' OR patientname = '$opt') AND status = 1 AND del_status != 1");
      
      $result = mysqli_query($db, "SELECT GROUP_CONCAT(billno) as billno FROM tbl_billing WHERE billno = '$opt' OR phno = '$opt' OR patientname = '$opt'");
      $row = mysqli_fetch_assoc($result);

      // Split the string into an array
      $array = explode(",", $row['billno']);

      // Add single quotes around each element
      $quotedArray = array_map(function($item) {
      return "'" . $item . "'";
      }, $array);

      // Join the array back into a string
      $output = implode(",", $quotedArray);

      // Output the result
      $bill_no =  $output;

      mysqli_query($db, "UPDATE tbl_billing_items SET status = 8 WHERE billno IN(".$bill_no.") AND status = 1 AND del_status != 1");

      $sql = "SELECT * FROM tbl_billing WHERE billno IN(".$bill_no.") AND status = 8 AND del_status != 1";
}      
  else {
      $sql = "SELECT * FROM tbl_billing WHERE status = 8 AND del_status != 1";
  }
  
  $res = mysqli_query($db, $sql);
  
  if (mysqli_num_rows($res) != 0) {
      $r = mysqli_fetch_array($res);
      $date= $r['datentime'];
      $date_only = date("Y-m-d", strtotime($date));
      $lbl_id = $r['id'];
      $billno = $r['billno'];
      $flag1 = 'readonly';
      $paidamt = $r['paidamt'];
      $flag11 = '';
      $billingid = $r['billingid'];
      $flag2 = 'disabled';
      $pm = $r['paymentmode'];
      $flag22 = '';
      
      if ($pm == 'Cash') {
          $cash = 'selected';
          $card = '';
      } elseif ($pm == 'Card') {
          $card = 'selected';
          $cash = '';
      } elseif ($pm == 'Credit-Staff') {
          $Credit_Staff = 'selected';
      } elseif ($pm == 'Credit') {
          $Credit = 'selected';
      } elseif ($pm == 'Credit-NC') {
          $Credit_NC = 'selected';
      } elseif ($pm == 'Credit-Claim') {
          $Credit_Claim = 'selected';
      }
  } else {
    $date= '';
      $billno = '';
      $flag1 = '';
      $flag2 = '';
      $cash = '';
      $card = '';
      $Credit_Staff = '';
      $Credit = '';
      $Credit_NC = '';
      $Credit_Claim = '';
      $flag11 = 'readonly';
      $flag22 = 'disabled';
      $pm = '';
      $paidamt = 0;
      $billingid = '';
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta charset="utf-8" />
<title>Sales Return</title>
<meta name="description" content="top menu &amp; navigation" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<link rel="stylesheet" href="dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="font/font-awesome.min.css" />
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
    <div class="navbar-header pull-left"> <a href="#" class="navbar-brand"> <small> <img height="80" width="130" src="images/logo1.png" /> Pharmacy </small> </a>
      <button class="pull-right navbar-toggle navbar-toggle-img collapsed" type="button" data-toggle="collapse" data-target=".navbar-buttons,.navbar-menu"> <span class="sr-only">Toggle user menu</span> <img src="return-user-img.php?id=<?php echo $_SESSION['phar-loginid']; ?>" alt="<?php echo $_SESSION['phar-username']; ?>" /> </button>
      <button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#sidebar"> <span class="sr-only">Toggle sidebar</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    </div>
    <div class="navbar-buttons navbar-header pull-right  collapse navbar-collapse" role="navigation">
      <ul class="nav ace-nav">
        <li class="light-blue user-min"> <a id="usermenu" data-toggle="dropdown" href="#" class="dropdown-toggle"> <img class="nav-user-photo" src="return-user-img.php?id=<?php echo $_SESSION['phar-loginid']; ?>" alt="<?php echo $_SESSION['mp-username']; ?>" /> <span class="user-info"> <small>Welcome,</small> <?php echo $_SESSION['phar-username']; ?> </span> <i class="ace-icon fa fa-caret-down"></i> </a>
          <ul style="margin-top: 25px;" class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
            <li> <a href="logout.php"> <i class="ace-icon fa fa-power-off"></i> Logout </a> </li>
          </ul>
        </li>
      </ul>
    </div>
  </div >
  <style>
    .return-qty-span,.qty-span{
      padding:5px 10px
    }
	#usermenu{
		margin-top: 25px;
	}
	.form-group {
    	margin-bottom: 5px;
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
 $currentPage = 'Sales_Return';
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
          <h1> Sales <small> <i class="ace-icon fa fa-angle-double-right"></i> Sales Return </small> </h1>
        </div>
        <!-- /.page-header -->
        <div class="row">
          <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="center"> <br />
              <form class="form-horizontal" id="frmBilling">
                <div class="form-group">
                  <label class="col-xs-4 control-label">Bill No / Phone No / Patient Name</label>
                  <div class="col-xs-3">
                    <input type="text" class="form-control input-sm " name="billno1" id="billno1" value="<?php echo $_REQUEST['billno']; ?>" placeholder="Bill No"  />
                    
                    <input type="hidden" class="form-control input-sm " name="billno" id="billno" value="<?php echo $bill_no; ?>" placeholder="Bill No"  />
                  </div>
                  <input type="button" class="btn btn-info btn-sm col-xs-1" value="Get Bill" onClick="getBill()"  />
</div>
<!-- onClick="getBill()" -->

                
                <br />
                <div style="text-align: center; margin-left: -100px;">
                <?php
$now = new DateTime();
$billDate = new DateTime($date);

// Calculate the difference in days
$interval = $now->diff($billDate);
$daysDifference = $interval->days;

// Check if the bill number is set
if (isset($bill_no) && $bill_no != '""') {
    // Output JavaScript for confirmation dialog
    if ($daysDifference > 14) {
        echo '<h5 style="color: red;">Cannot Return Bill (Exceeded 14 days) Bill Date: ' . $date_only . '</h5>';
        echo '<button onclick="customAlert()">Continue</button>';
               echo '<script>
               function customAlert() {
                   var confirmation = confirm("The bill date is more than 14 days old. Do you want to continue?");
                   if (confirmation) {
                       window.location.href = "sales-return.php";
                   } else {
                        window.location.href = "sales-return-summary.php";
                   }
               }
             </script>';
    } else {
        echo '<h5>Bill Date: ' . $date_only . '</h5>';
 
    }
}
?>
<br/>
</div>
                <div style="min-height: 350px; max-height: 450px; overflow-y: auto;">
                <br/>
                  <table id="tbl-list" class="table table-striped record_table">
                    <thead>
                      <tr>
                    <th><input class="checkbox" type="checkbox" id="checkall" name="checkall[]" style="height:15px; width:15px;"/></th>
                    <th style="text-align:center">Item ID</th>
                        <th style="text-align:center">Code</th>
                        <th style="text-align:center">Description</th>
                        <th style="text-align:center">Qty.</th>
                        <th style="text-align:center">Return Qty.</th>
                        <th style="text-align:center">Batch#</th>
                        <th style="text-align:center">Expiry</th>
                        <th style ="text-align:center">Item Price</th>
                        <th style="text-align:center">Amount</th>
                        <th style="text-align:center">Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                <?php
              require_once("config.php");
              $sql = mysqli_query($db,"SELECT * FROM tbl_billing_items WHERE status = 8 AND billno IN(".$bill_no.") and del_status != 1");
              $i = 0;
              $tot_amt = 0;
              $deducted_amt=0; 
              while($r = mysqli_fetch_array($sql)) {
                  $itemId= $r['id'];
                  $date = $r['datentime'];
                  $code = $r['code'];
                  $qty = $r['qty'];
                  $returnQty = $r['returnqty'];
                  $batchno = $r['batchno'];
                  $amount = $r['amount'];
                  $totalqty = $qty - $returnqty;
                  $ref = mysqli_query($db, "SELECT * FROM `tbl_purchaseitems` WHERE `batchno`='$batchno'");
                  $rt = mysqli_fetch_array($ref);
                  $perprice = $rt['mrp'];
                  $newperprice = $amount / $qty;
                  $totalprice = $perprice * $totalqty; 

                  $original_amt +=$totalprice;
                  $tot_amt += $totalprice; 
                  $deducted_amt += $newperprice * $returnQty;
            
                  $expirydate = implode("/",array_reverse(explode("-",$r['expirydate'])));
                  $expiry = substr($expirydate,3);
                  $q = mysqli_query($db, "SELECT * FROM tbl_productlist WHERE id = $code");
                  $rq = mysqli_fetch_array($q);
        
                  echo '<tr>
                  <td><input type="checkbox" class="checkbox" style="text-align:center;"id=checkind_'.$i++.'></td>
                  <td style="text-align:center" class="item_id">'.$itemId.'</td>
                  <td style="text-align:center" class="code">'.$r['code'].'</td>
                  <td style="text-align:center">'.$rq['productname'].'</td>
                  <td style="text-align:center">
                      <span class="qty-span"  id="qty'.$i.'">'.$qty.'</span>
                  </td>
                  <td style="text-align:center">
                      <span class="return-qty-span" contenteditable="true" id="returnqty'.$i.'">'.$returnQty.'</span>
                  </td>
                  <td style="text-align:center" class="batchno" >'.$r['batchno'].'</td>
                  <td style="text-align:center">'.$expiry.'</td>
                  <td style="text-align:center" class="per-price-span">' . $perprice . '</td>
                  <td style="text-align:center" class="amount-span">'.$totalprice.'</td>
                  <td style="text-align:center"><img src="images/delete.png" style="height:24px; cursor:pointer;" onClick="javascript:deleteItem(this,\''.$r['id'].'\')"></td>
              </tr>'; 
      }   
                ?>
                    </tbody>
                  </table>
                </div>
                <div class="form-group">
                  <label class="col-xs-2 control-label">Original Amount : </label>
                  <label class="col-xs-1 control-label amount-span"><?php echo $tot_amt; ?></label>
                  <label class="col-xs-2 control-label">Deducted Amount:</label>
                  <label class="col-xs-1 control-label deducted-amount-span"><?php echo $deducted_amt; ?></label>
                  <div class="pull-left col-xs-2">
                    <select id="paymentmode" name="paymentmode" class="form-control input-sm">
                    <option>SELECT</option>
                    <option <?php echo $cash; ?>>Cash</option>
                    <option <?php echo $card; ?>>Card</option>
                    <option <?php echo $Credit_Staff; ?>>Credit-Staff</option>
                    <option <?php echo $Credit; ?>>Credit</option>
                    <option <?php echo $Credit_NC; ?>>Credit-NC</option>
                    <option <?php echo $Credit_Claim; ?>>Credit-Claim</option>
                    </select>
                  </div>
                  <button type="button" class="btn btn-primary btn-sm pull-right" onClick="summary('<?php echo $bill_no; ?>')" <?php echo $flag22; ?>>Summary</button>


                </div>
              </form>
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

<script src="libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript">
			window.jQuery || document.write("<script src='dist/js/jquery.min.js'>"+"<"+"/script>");
		</script>

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
<script src="manage-bill/sales-return.js"></script>
<script src="manage-bill/quick-bill.js"></script>
<script>
  

  function summary(billno) {

    if (billno.trim() !== '') {
    
        window.location.href = 'sales-return-summary.php?billno=' + encodeURIComponent(billno);
    } else {
 
        alert('Bill number is empty.');
    }
}


$(".return-qty-span").blur(function(){
    var row = $(this).closest("tr");
    var qtySpan = row.find(".qty-span");
    var originalQty = parseInt(qtySpan.text());
    var returnQty = parseInt(row.find(".return-qty-span").text().trim());

      
    var newQty = originalQty - returnQty;
    if (!isNaN(returnQty) && newQty >= 0) {
        newQty = Math.max(0, newQty);
        qtySpan.text(newQty);

        var perPrice = parseFloat(row.find(".per-price-span").text());
        var originalAmount = newQty * perPrice;
        var deductedAmount = returnQty * perPrice; 
        row.find(".amount-span").text(originalAmount.toFixed(2)); 
        row.find(".deducted-amount-span").text(deductedAmount.toFixed(2)); 

        var billno = $("#billno").val();
        var code = row.find(".code").text();
        var updatedQty = newQty;
        var amount = originalAmount; 
        var batchno = row.find(".batchno").text();
        var item_id = row.find(".item_id").text();
        $.ajax({
            type: 'post',
            url: 'update_quantities.php',
            data: {
                billno: billno,
                code: code,
                qty: updatedQty,
                returnQty: returnQty,
                amount: amount,
                batchno :batchno,
                id : item_id
            },
            success: function(response) {alert(response);
                alert('Item updated successfully.');
            },
            error: function(xhr, status, error) {
                alert('Error updating item: ' + error);
            }
        });
    } else {
       alert('Invalid return quantity.');
    }
});

    $("#checkall").change(function(){
    var status = this.checked; 
    $('.checkbox').each(function(){ 
        this.checked = status;
    });
});
$('.checkbox').change(function(){  
    
    if(this.checked == false){ 
        $("#checkall")[0].checked = false; 
    }
    
    
    if ($('.checkbox:checked').length == $('.checkbox').length ){ 
        $("checkall")[0].checked = true; 
    }
});

$(document).ready(function() {
    $('.record_table tr').click(function(event) {
        if (event.target.type !== 'checkbox') {
            $(':checkbox', this).trigger('click');
        }
    });
});

function qtycheck(event) {
  if ((event.keyCode >= 48 && event.keyCode <= 57) || event.keyCode === 13) {
    return true;
  } else {
    return false;
  }

}
</script>
</body>
</html>
