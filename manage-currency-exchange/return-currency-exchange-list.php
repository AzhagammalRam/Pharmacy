<?php
	include("../config.php");
	$sql = "SELECT * FROM `tbl_currency_exchange` ORDER BY id";
	$res = mysql_query($sql);
	$i = 1;
	$data = array();
	while($rs = mysql_fetch_array($res)){
		$status = $rs['status'];
		$option1 = ($status == 1) ? '<div class="hidden-sm hidden-xs action-buttons">
										<a id="view" class="blue" href="#" data-val="'.$rs['id'].'"> <i class="ace-icon fa fa-search-plus bigger-130"></i> </a> 
										<a id="edit" class="green" href="#" data-val="'.$rs['id'].'"> <i class="ace-icon fa fa-pencil bigger-130"></i> </a> 
										<a id="disable" class="orange" href="#" data-val="'.$rs['id'].'"> <i class="ace-icon fa fa-lock bigger-130"></i> </a> 
									</div>
									<div class="hidden-md hidden-lg">
										<div class="inline pos-rel">
										    <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto"> <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i> </button>
										    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
										    	<li> <a href="#" id="view" class="tooltip-info" data-val="'.$rs['id'].'" data-rel="tooltip" title="View"> <span class="blue"> <i class="ace-icon fa fa-search-plus bigger-120"></i> </span> </a> </li>
											    <li> <a href="#" id="edit" class="tooltip-success" data-val="'.$rs['id'].'" data-rel="tooltip" title="Edit"> <span class="green"> <i class="ace-icon fa fa-pencil-square-o bigger-120"></i> </span> </a> </li>
												<li> <a href="#" id="disable" class="tooltip-success" data-val="'.$rs['id'].'" data-rel="tooltip" title="Disable"> <span class="orange"> <i class="ace-icon fa fa-lock bigger-120"></i> </span> </a> </li>
										    </ul>
									  </div>
									</div>' : '
									<div class="hidden-sm hidden-xs action-buttons"> 
										<a id="view" class="blue" href="#" data-val="'.$rs['id'].'"> <i class="ace-icon fa fa-search-plus bigger-130"></i> </a> 
										<a id="enable" class="green" href="#" data-val="'.$rs['id'].'"> <i class="ace-icon fa fa-check bigger-130"></i> </a>
										<a id="delete" class="red" href="#" data-val="'.$rs['id'].'"> <i class="ace-icon fa fa-trash-o bigger-130"></i> </a> 
									</div>
									<div class="hidden-md hidden-lg">
										<div class="inline pos-rel">
											<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto"> <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i> </button>
											<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
												<li> <a href="#" id="view" data-val="'.$rs['id'].'" class="tooltip-info" data-rel="tooltip" title="View"> <span class="blue"> <i class="ace-icon fa fa-search-plus bigger-120"></i> </span> </a> </li>
												<li> <a href="#" id="enable" data-val="'.$rs['id'].'" class="tooltip-error" data-rel="tooltip" title="Enable"> <span class="green"> <i class="ace-icon fa fa-check bigger-120"></i> </span> </a> </li>
												<li> <a href="#" id="delete"  data-val="'.$rs['id'].'" class="tooltip-error" data-rel="tooltip" title="Delete"> <span class="red"> <i class="ace-icon fa fa-trash-o bigger-120"></i> </span> </a> </li>
											</ul>
										  </div>
									</div>';
									     
		$statustype = ($status == 1) ? "<span class='label label-sm label-success arrowed-in arrowed-in-right'>Active</span>" : "<span class='label label-sm label-arrowed arrowed-in arrowed-in-right'>Expired</span>";
		$id=$rs['id'];
		$exchange_currency=$rs['exchange_currency'];
		$get_base_currency_query =mysql_query("select * from `tbl_currency` where `id`='$id'");
		$get_base_currency=mysql_fetch_array($get_base_currency_query);
		$base_currency=$get_base_currency['currency'];
		


		$get_exchange_currency_query =mysql_query("select * from `tbl_currency` where `id`='$exchange_currency'");
		$get_exchange_currency=mysql_fetch_array($get_exchange_currency_query);
		$exchange_currency=$get_exchange_currency['currency'];


		$x = array('#'=>$i++,
					 'base_currency_amnt'=>$rs['base_currency_amnt'], 
					 'exchange_currency'=>$exchange_currency, 
					 'exchange_rate'=>$rs['exchange_rate'], 
					 'base_currency'=>$base_currency, 
					 'Status'=>$statustype);
		array_push($data, $x);
	}
    $results = array(
            "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
          "aaData"=>$data);
		 
echo json_encode($results);
?>
