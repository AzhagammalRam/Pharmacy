<?php
	$id = $_REQUEST['id'];
	include("../config.php");
	$sql = "UPDATE tbl_supplier SET status = 0 WHERE id = ".$id;
	if(mysqli_query($db,$sql)){
		$msg = 'ok~'.'<div class="hidden-sm hidden-xs action-buttons"> 
										<a id="view" class="blue" href="#" data-val="'.$id.'"> <i class="ace-icon fa fa-search-plus bigger-130"></i> </a> 
										<a id="enable" class="green" href="#" data-val="'.$id.'"> <i class="ace-icon fa fa-check bigger-130"></i> </a>
										<a id="delete" class="red" href="#" data-val="'.$id.'"> <i class="ace-icon fa fa-trash-o bigger-130"></i> </a> 
									</div>
									<div class="hidden-md hidden-lg">
										<div class="inline pos-rel">
											<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto"> <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i> </button>
											<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
												<li> <a href="#" id="view" data-val="'.$id.'" class="tooltip-info" data-rel="tooltip" title="View"> <span class="blue"> <i class="ace-icon fa fa-search-plus bigger-120"></i> </span> </a> </li>
												<li> <a href="#" id="enable" data-val="'.$id.'" class="tooltip-error" data-rel="tooltip" title="Enable"> <span class="green"> <i class="ace-icon fa fa-check bigger-120"></i> </span> </a> </li>
												<li> <a href="#" id="delete"  data-val="'.$id.'" class="tooltip-error" data-rel="tooltip" title="Delete"> <span class="red"> <i class="ace-icon fa fa-trash-o bigger-120"></i> </span> </a> </li>
											</ul>
										  </div>
									</div>~'. "<span class='label label-sm label-arrowed arrowed-in arrowed-in-right'>Expired</span>";
		echo $msg;
					
	}else
		echo mysqli_error($db);
?>