<?php
	$id = $_REQUEST['id'];
	require_once("../config.php");
	$sql = "UPDATE branch SET status = 1 WHERE id = ".$id;
	if(mysqli_query($db,$sql))
		echo 'ok~<div class="hidden-sm hidden-xs action-buttons">
										<a id="view" class="blue" href="#" data-val="'.$id.'"> <i class="ace-icon fa fa-search-plus bigger-130"></i> </a> 
										<a id="edit" class="green" href="#" data-val="'.$id.'"> <i class="ace-icon fa fa-pencil bigger-130"></i> </a> 
										<a id="disable" class="orange" href="#" data-val="'.$id.'"> <i class="ace-icon fa fa-lock bigger-130"></i> </a> 
									</div>
									<div class="hidden-md hidden-lg">
										<div class="inline pos-rel">
										    <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto"> <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i> </button>
										    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
										    	<li> <a href="#" id="view" class="tooltip-info" data-val="'.$id.'" data-rel="tooltip" title="View"> <span class="blue"> <i class="ace-icon fa fa-search-plus bigger-120"></i> </span> </a> </li>
											    <li> <a href="#" id="edit" class="tooltip-success" data-val="'.$id.'" data-rel="tooltip" title="Edit"> <span class="green"> <i class="ace-icon fa fa-pencil-square-o bigger-120"></i> </span> </a> </li>
												<li> <a href="#" id="disable" class="tooltip-success" data-val="'.$id.'" data-rel="tooltip" title="Disable"> <span class="orange"> <i class="ace-icon fa fa-lock bigger-120"></i> </span> </a> </li>
										    </ul>
									  </div>
									</div>~<span class="label label-sm label-success arrowed-in arrowed-in-right">Active</span>';
	else
		echo mysqli_error($db);
?>