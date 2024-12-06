<?php
	include("../config.php");
	$sql = "SELECT * FROM tbl_productlist ORDER BY productname asc";
	if(isset($_REQUEST['claim_type']))
	{
		$clm_type = $_REQUEST['claim_type'];
		if($_REQUEST['claim_type'] != "All")
		{
			$sql = "SELECT * FROM tbl_productlist WHERE `claimtype` = '$clm_type' ORDER BY productname asc";
		}
		
		
	}

	$res = mysqli_query($db,$sql);
	$i = 1;
	$data = array();
	while($rs = mysqli_fetch_array($res)){
		$manu = $rs['manufacturer'];
		$status = $rs['status'];
		$q = mysqli_query($db,"SELECT * FROM tbl_manufacturer WHERE id = $manu");
		$r = mysqli_fetch_array($q);
		$manufacturername = $r['manufacturername'];
		$option1 = ($status == 1) ? '<div class="hidden-sm hidden-xs action-buttons">
										<a id="view" title="View" class="blue" href="#" data-val="'.$rs['id'].'"> <i class="ace-icon fa fa-search-plus bigger-130"></i> </a> 
										<a id="edit" title="Edit" class="green" href="#" data-val="'.$rs['id'].'"> <i class="ace-icon fa fa-pencil bigger-130"></i> </a> 
										<a id="disable" title="Disable" class="orange" href="#" data-val="'.$rs['id'].'"> <i class="ace-icon fa fa-lock bigger-130"></i> </a> 
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
										<a id="view" title="View" class="blue" href="#" data-val="'.$rs['id'].'"> <i class="ace-icon fa fa-search-plus bigger-130"></i> </a> 
										<a id="enable" title="Enable" class="green" href="#" data-val="'.$rs['id'].'"> <i class="ace-icon fa fa-check bigger-130"></i> </a>
										<a id="delete" title="Delete" class="red" href="#" data-val="'.$rs['id'].'"> <i class="ace-icon fa fa-trash-o bigger-130"></i> </a> 
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
											
		$x = array('#'=>$i++,
					 'type'=>$rs['stocktype'],
					 'product'=>$rs['productname'], 
					 'manufacturer'=>$manufacturername, 
					 'shelf'=>$rs['shelf'], 
					 'rack'=>$rs['rack'],
					 'generic'=>$rs['genericname'], 
					 'Action'=>$option1);
		array_push($data, $x);
	}
    $results = array(
            "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
          "aaData"=>$data);
echo json_encode($results);
?>