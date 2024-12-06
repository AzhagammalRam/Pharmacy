// JavaScript Document

// function newdoctor(){
// 	var name = $('#doctor').val();
// 	if(name == "") return false;
// 	$.ajax({
//         type: 'post',
//         url: 'manage-store/new-store-details.php',
// 		data: $('#newdoctor').serialize(),
//         success: function(msg) {
// 			alert(msg);
// 			window.location.href="manage-doctor.php";
//         }
//     });
// }
function newstore(){
	var name = $('#branch').val();
	if(name == "") return false;
	 var seloptions = $("select#status").val()
	  if (seloptions === "")
	  {
	  	alert("select the status");
	  	return false;

	  }
	$.ajax({
        type: 'post',
        url: 'manage-store/new-store-details.php',
		data: $('#newstore').serialize(),
        success: function(msg) {
			// alert(msg);
			// window.location.href="manage-store.php";
        if(msg.includes("New Store Added!"))
		{
	 window.location.href="manage-store.php";
			
				
		}
		else
		{
			alert(msg);
			 $('#newstore')[0].reset();
			}
        }
    });
}
function updatestore(){
	var name = $('#ustore').val();
	var id = $('#uid').val();
	if(name == "") return false;
	$.ajax({
        type: 'post',
        url: 'manage-store/update-store-details.php',
		data: $('#updatestore').serialize(),
        success: function(msg) {
			alert(msg);
			window.location.href="manage-store.php";
        }
    });
}
$('table').on('click', 'a[id=edit]', function (e) {
	var txt = $(this).attr("data-val");
	$.ajax({	
		url: 'manage-store/return-edit-store-info.php?id='+txt,
		type: 'POST',
		success:function(msg){
			var x = JSON.parse(msg);
			$('#uid').val(x.id);
			$('#ustatus').val(x.status);				
			$('#ustore').val(x.name);
			
		}
	});
	var modal = $('#modal-update');
	modal.modal('show');
});
$('table').on('click', 'a[id=view]', function (e) {
	var txt = $(this).attr("data-val");
	$.ajax({	
		url: 'manage-store/return-edit-store-info.php?id='+txt,
		type: 'POST',
		success:function(msg){
			var x = JSON.parse(msg);
			$('#vstatus').html(x.status);		$('#vbranch').html(x.name);	;
			
		}
	});
	var modal = $('#modal-view');
	modal.modal('show');
});
$('table').on('click', 'a[id=disable]', function (e) {
	var txt = $(this).attr('data-val');
	var rid = $(this).closest("tr").index();
	if(confirm("Sure to disable store?")){
		$.ajax({	
			url: 'manage-store/disable-store.php?id='+txt,
			type: 'POST',
			success:function(msg){
				var x = msg.split("~");
				if(x[0] != 'ok'){
					alert(msg);
					return false;
				}
				window.location.href="manage-store.php";
			}
		});
	}
});
$('table').on('click', 'a[id=enable]', function (e) {
	var txt = $(this).attr('data-val');
	var rid = $(this).closest("tr").index();
	if(confirm("Sure to enable store?")){
		$.ajax({	
			url: 'manage-store/enable-store.php?id='+txt,
			type: 'POST',
			success:function(msg){
				var x = msg.split("~");
				if(x[0] != 'ok'){
					alert(msg);
					return false;
				}
				window.location.href="manage-store.php";
			}
		});
	}
});
$('table').on('click', 'a[id=delete]', function (e) {
	var txt = $(this).attr('data-val');
	var rid = $(this).closest("tr").index();
	if(confirm("Sure to delete Store?")){
		$.ajax({	
			url: 'manage-store/delete-store.php?id='+txt,
			type: 'POST',
			success:function(msg){
				if(msg != 'ok'){
					alert(msg);
					return false;
				}
				alert('Store Record Deleted !');
				window.location.href = 'manage-store.php';
			}
		});
	}
});
