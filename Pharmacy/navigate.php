<div class="main-container container" id="main-container">
  <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
      </script>
  <div id="sidebar" class="sidebar      h-sidebar                navbar-collapse collapse">
    <script type="text/javascript">
          try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
        </script>
    <ul class="nav nav-list">
      <li class="<?php if($currenttab == "Dashboard")echo "active";?>"> <a href="index.php"> <i class="menu-icon fa fa-tachometer"></i> <span class="menu-text"> Dashboard </span> </a> <b class="arrow"></b> </li>
<?php
include("config.php"); 

// echo "Fourteen is ".($fourteen > $twelve ? "more than" : "not more than")." twelve"

      if($_SESSION['bill'] == 1 || $_SESSION['sr'] == 1 || $_SESSION['dreturn'] == 1){
    echo '<li class = "'. (($currenttab == "sales")? "active open hover":"hover").'" > <a href="#" class="dropdown-toggle"> <i class="menu-icon fa fa-pencil-square-o"></i> <span class="menu-text"> Sales </span> <b class="arrow fa fa-angle-down"></b> </a> <b class="arrow"></b><ul class="submenu">';
    if($_SESSION['bill'] == 1) echo '<li class="'.(($currentPage =="Billing")? "active hover":"hover") .'"> <a href="billing.php"> <i class="menu-icon fa fa-caret-right"></i>  Billing </a> <b class="arrow"></b> </li>';
    if($_SESSION['sr'] == 1) echo '<li class="'. (($currentPage =="Sales_Return")? "active hover":"hover") .'"> <a href="sales-return.php"> <i class="menu-icon fa fa-caret-right"></i> Sales Return</a> <b class="arrow"></b> </li>';
    if($_SESSION['dreturn'] == 1) echo '<li class="'. (($currentPage =="Drug_Return")? "active hover":"hover").'"> <a href="d_sales-return.php"> <i class="menu-icon fa fa-caret-right"></i> Drug Return</a> <b class="arrow"></b> </li>';
        echo '</ul></li>';
  }
  if($_SESSION['mp'] == 1 ||  $_SESSION['mm'] == 1 || $_SESSION['ms'] ==1 || $_SESSION['md'] == 1 ||  $_SESSION['mst'] == 1 || $_SESSION['mu'] == 1){
    echo '<li class="'. (($currenttab == "Master_Entry")? "active open hover":"hover").'"> <a href="#" class="dropdown-toggle"> <i class="menu-icon fa fa-desktop"></i> <span class="menu-text"> Master Entry </span> <b class="arrow fa fa-angle-down"></b> </a> <b class="arrow"></b><ul class="submenu">';
    if($_SESSION['mp'] == 1) echo '<li class="'.(($currentPage =="Manage_Products")? "active hover":" hover") .'"> <a href="manage-product.php"> <i class="menu-icon fa fa-caret-right"></i> Manage Products </a> <b class="arrow"></b> </li>';
    if($_SESSION['ms'] == 1) echo '<li class="'.(($currentPage =="Manage_Suppliers")? "active hover":"hover") .'"> <a href="manage-supplier.php"> <i class="menu-icon fa fa-caret-right"></i> Manage Suppliers </a> <b class="arrow"></b> </li>';
    if($_SESSION['mm'] == 1) echo '<li class="'.(($currentPage =="Manage_Manufacturers")? "active hover":"hover") .'"> <a href="manage-manufacturer.php"> <i class="menu-icon fa fa-caret-right"></i> Manage Manufacturers </a> <b class="arrow"></b> </li>';
    if($_SESSION['mu'] == 1) echo '<li class="'.(($currentPage =="Manage_Users")? "active hover":"hover") .'"> <a href="manage-user.php"> <i class="menu-icon fa fa-caret-right"></i> Manage Users </a> <b class="arrow"></b> </li>';
  if($_SESSION['md'] == 1) echo '<li class="'.(($currentPage =="Manage_Doctor")? "active hover":"hover") .'"> <a href="manage-doctor.php"> <i class="menu-icon fa fa-caret-right"></i> Manage Doctors </a> <b class="arrow"></b> </li>';
    if($_SESSION['mst'] == 1) echo '<li class="'.(($currentPage =="Manage_Store")? "active hover":"hover") .'"> <a href="manage-store.php"> <i class="menu-icon fa fa-caret-right"></i> Manage Stores </a> <b class="arrow"></b> </li>';  
if($config['module']['currency'] == true) echo '<li class="'.(($currentPage =="Manage_Currency")? "active hover":"hover") .'"> <a href="manage-currency.php"> <i class="menu-icon fa fa-caret-right"></i> Manage Currency </a> <b class="arrow"></b></li><li class=" hover"><a href="manage-currency-exchange.php"> <i class="menu-icon fa fa-caret-right"></i> Manage Exchange Rate </a></b></li>';  
    // if($_SESSION['sttra'] == 1) echo '<li class="open hover"> <a href="stock-transfer.php"> <i class="menu-icon fa fa-caret-right"></i> Store Transfer </a> <b class="arrow"></b> </li>';
    echo '</ul></li>';
  }

  if($_SESSION['pe'] == 1 || $_SESSION['pr'] == 1){
    echo '<li class="'. (($currenttab == "Purchase")? "active open hover":"hover").'"> <a href="#" class="dropdown-toggle"> <i class="menu-icon fa fa-shopping-cart"></i> <span class="menu-text"> Purchase </span> <b class="arrow fa fa-angle-down"></b> </a> <b class="arrow"></b><ul class="submenu">';
    if($_SESSION['pe'] == 1) echo '<li class="'.(($currentPage =="Purchase_Entry")? "active hover":"open hover") .'"> <a href="purchase-entry.php"> <i class="menu-icon fa fa-caret-right"></i> Purchase Entry </a> <b class="arrow"></b> </li>';
    if($_SESSION['pr'] == 1) echo '<li class="'.(($currentPage =="Purchase_Return")? "active hover":"hover") .'"> <a href="purchase-return.php"> <i class="menu-icon fa fa-caret-right"></i> Purchase Return </a> <b class="arrow"></b> </li>';
    if($_SESSION['pr'] == 1) echo '<li class="'.(($currentPage =="Purchase_Return_Others")? "active hover":"hover") .'"> <a href="purchasereturnothers.php"> <i class="menu-icon fa fa-caret-right"></i> Purchase Return - Others </a> <b class="arrow"></b> </li>';
        echo '</ul></li>';
  }
  if($_SESSION['sa'] == 1 || $_SESSION['ise'] == 1 || $_SESSION['stka'] == 1 || $_SESSION['sttra'] == 1){
    echo '<li class="'. (($currenttab == "Stocks")? "active open hover":"hover").'"> <a href="#" class="dropdown-toggle"> <i class="menu-icon fa fa-line-chart"></i> <span class="menu-text"> Stocks </span> <b class="arrow fa fa-angle-down"></b> </a> <b class="arrow"></b><ul class="submenu">';
    
    if($_SESSION['sa'] == 1) echo '<li class="'.(($currentPage =="Stock_Availability")? "active hover":"open hover") .'"> <a href="stock-availability.php"> <i class="menu-icon fa fa-caret-right"></i> Stock Availability </a> <b class="arrow"></b> </li>';
    if($_SESSION['ise'] == 1) echo '<li class="'.(($currentPage =="Initial_Stock_Entry")? "active hover":"hover") .'"> <a href="initial-stock-entry.php"> <i class="menu-icon fa fa-caret-right"></i> Initial Stock Entry </a> <b class="arrow"></b> </li>';
    if($_SESSION['clearstock'] == 1) echo '<li class="'.(($currentPage =="clearstock")? "active hover":"hover") .'"> <a href="unused-products.php"> <i class="menu-icon fa fa-caret-right"></i>Disposed Stocks</a> <b class="arrow"></b> </li>';

      if($_SESSION['ustock'] == 1) echo '<li class="'.(($currentPage =="stock_wastage")? "active hover":"hover") .'"> <a href="stock-wastage.php"> <i class="menu-icon fa fa-caret-right"></i>Stock Clearance</a> <b class="arrow"></b> </li>';

        if($_SESSION['stka'] == 1) echo '<li class="'.(($currentPage =="Stock_Adjustment")? "active hover":"hover") .'"> <a href="stock-adjustment.php"> <i class="menu-icon fa fa-caret-right"></i>Stock Adjustment </a> <b class="arrow"></b> </li>';
    if($_SESSION['sttra'] == 1) echo '<li class="'.(($currentPage =="Stock_Transfer")? "active hover":"open hover") .'"> <a href="stock-transfer.php"> <i class="menu-icon fa fa-caret-right"></i> Stock Transfer </a> <b class="arrow"></b> </li>';
        echo '</ul></li>';
  }
  if($_SESSION['prep'] == 1 || $_SESSION['srep'] == 1 || $_SESSION['doc'] == 1 || $_SESSION['vat'] == 1 || $_SESSION['pfrep'] == 1 || $_SESSION['purretrep'] == 1|| $_SESSION['sch'] == 1 || $_SESSION['exrep'] == 1 || $_SESSION['iprep'] == 1 || $_SESSION['storep'] == 1 || $_SESSION['dgrep'] == 1){
    echo '<li class="'. (($currenttab == "Reports")? "active open hover":"hover").'"> <a href="#" class="dropdown-toggle"> <i class="menu-icon fa fa-calendar"></i> <span class="menu-text"> Reports</span> <b class="arrow fa fa-angle-down"></b> </a> <b class="arrow"></b><ul class="submenu">';
    if($_SESSION['srep'] == 1) echo '<li class="'.(($currentPage =="Sales_Report")? "active hover":"open hover") .'"> <a href="sales-report.php"> <i class="menu-icon fa fa-caret-right"></i> Sales Report </a> <b class="arrow"></b> </li>';
    if($_SESSION['prep'] == 1) echo '<li class="'.(($currentPage =="Purchase_Report")? "active hover":"hover") .'"> <a href="purchase-report.php"> <i class="menu-icon fa fa-caret-right"></i> Purchase Report </a> <b class="arrow"></b> </li>';
    if($_SESSION['doc'] == 1) echo '<li class="'.(($currentPage =="Doctor_Report")? "active hover":"hover") .'"> <a href="doctor-report.php"> <i class="menu-icon fa fa-caret-right"></i> Doctor Report </a> <b class="arrow"></b> </li>';
    if($_SESSION['vat'] == 1) echo '<li class="'.(($currentPage =="TAX_Report")? "active hover":"hover") .'"> <a href="tax-report.php"> <i class="menu-icon fa fa-caret-right"></i> TAX Report </a> <b class="arrow"></b> </li>';
    if($_SESSION['sch'] == 1) echo '<li class="'.(($currentPage =="Schedule_Drug_Report")? "active hover":"hover") .'"> <a href="schedule-report.php"> <i class="menu-icon fa fa-caret-right"></i> Schedule Drug Report </a> <b class="arrow"></b> </li>';
    // if($_SESSION['sch'] == 1) echo '<li class="hover"> <a href="adj-report.php"> <i class="menu-icon fa fa-caret-right"></i> Stock Adjustment Report </a> <b class="arrow"></b> </li>';
    if($_SESSION['pfrep'] == 1) echo '<li class="'.(($currentPage =="PF_Report")? "active hover":"hover") .'"> <a href="pf-report.php"> <i class="menu-icon fa fa-caret-right"></i> PF Report </a> <b class="arrow"></b> </li>';
    if($_SESSION['iprep'] == 1) echo '<li class="'.(($currentPage =="Ip_Bill_Summary")? "active hover":"hover") .'"> <a href="ipbillsum.php"> <i class="menu-icon fa fa-caret-right"></i> Ip Bill Summary </a> <b class="arrow"></b> </li>';
      if($_SESSION['storep'] == 1) echo '<li class="'.(($currentPage =="Store_Report")? "active hover":"hover") .'"> <a href="stockreports.php"> <i class="menu-icon fa fa-caret-right"></i> Store Report </a> <b class="arrow"></b> </li>';
      if($_SESSION['purretrep'] == 1) echo '<li class="'.(($currentPage =="Purchase_Return_Report")? "active hover":"hover") .'"> <a href="preport.php"> <i class="menu-icon fa fa-caret-right"></i> Purchase Return Report</a> <b class="arrow"></b> </li>';
      if($_SESSION['exrep'] == 1) echo '<li class="'.(($currentPage =="Short_Expiry_Report")? "active hover":"hover") .'"> <a href="short_expiry_reports.php"> <i class="menu-icon fa fa-caret-right"></i>Short Expiry Report</a> <b class="arrow"></b> </li>';

        if($_SESSION['dispose_report'] == 1) echo '<li class="'.(($currentPage =="disposed_report")? "active hover":"hover") .'"> <a href="stock-disposedreport.php"> <i class="menu-icon fa fa-caret-right"></i>Disposed Report</a> <b class="arrow"></b> </li>';
      if($_SESSION['dgrep'] == 1) echo '<li class="'.(($currentPage =="Drug_Return_Report")? "active hover":"hover") .'"> <a href="drug-return-report.php"> <i class="menu-icon fa fa-caret-right"></i>Drug Return Report</a> <b class="arrow"></b> </li>';
      if($_SESSION['cmrep'] == 1) echo '<li class="'.(($currentPage =="camp_med_Report")? "active hover":"hover") .'"> <a href="camp_med_report.php"> <i class="menu-icon fa fa-caret-right"></i>Camp Medicine Report</a> <b class="arrow"></b> </li>';
     echo '</ul></li>';
  }
 if($_SESSION['sc'] == 1 || $_SESSION['cc'] == 1) {
        echo '<li class="'. (($currenttab == "Credit_Pay")? "active open hover":"hover").'"> <a href="#"> <i class="menu-icon fa fa-money"></i> <span class="menu-text"> Credit Pay </span> <b class="arrow fa fa-angle-down"></b> </a> <ul class="submenu">';
  if($_SESSION['sc'] == 1)   echo '<li class="'.(($currentPage =="Supplier_Credit")? "active hover":"hover") .'"> <a href="credit-supplier.php"> <i class="menu-icon fa fa-caret-right"></i> Supplier  Credit </a> <b class="arrow"></b> </li>';
   if($_SESSION['cc'] == 1)   echo '<li class="'.(($currentPage =="Customer_Credit")? "active hover":"hover") .'"> <a href="credit-customer.php"> <i class="menu-icon fa fa-caret-right"></i> Customer  Credit </a> <b class="arrow"></b> </li>';
 echo '</ul></li>';
    }
  if($_SESSION['phar-role'] == 1) {
        echo '<li class="'. (($currenttab == "License")? "active open hover":"hover").'"> <a href="manage-license.php"> <i class="menu-icon fa fa-key"></i> <span class="menu-text"> License </span> <b class="arrow fa fa-angle-down"></b> </a> </li>';
    }
     if($_SESSION['bill'] == 1) {
        echo '<li class="hover pull-right"> <a href="#" onClick="quickBilling(1)"> <i class="menu-icon fa fa-pencil-square-o"></i> <span class="menu-text"> Quick Bill </span> <b class="arrow fa fa-angle-down"></b> </a> </li>';
    }
   if($_SESSION['bill']==1 && $config['module']['quickBillip'] == true ) { 
       echo '<li class="hover pull-right"> <a href="#" onClick="quickBilling(2)"> <i class="menu-icon fa fa-pencil-square-o"></i> <span class="menu-text"> Quick Bill IP</span> <b class="arrow fa fa-angle-down"></b> </a> </li>';
   }
    ?>
    </ul>