$(function() {
	
		$("#newdoctor").submit(function(){
			var formValues = $(this).serialize();

         $.ajax({
url: "manage-doctor/new-doctor-details.php",
type: "POST",
data:  new FormData(this),
contentType: false,
cache: false,
processData:false,
 success: function(msg) {
	 
		if(msg.includes("success"))
		{
	 window.location.href="manage-doctor.php";
			
				
		}
		else
		{
			alert(msg)
			}
		}
		 });
return false;
		});

		
	});


function updatedoctor(){
	var name = $('#udoctor').val();
	if(name == "") return false;
	$.ajax({
        type: 'post',
        url: 'manage-doctor/update-doctor-details.php',
		data: $('#updatedoctor').serialize(),
        success: function(msg) {
			alert(msg);
			window.location.href="manage-doctor.php";
        }
    });
}
$('table').on('click', 'a[id=edit]', function (e) {
	var txt = $(this).attr("data-val");
	$.ajax({	
		url: 'manage-doctor/return-edit-doctor-info.php?id='+txt,
		type: 'POST',
		success:function(msg){
			var x = JSON.parse(msg);
			$('#DBid').val(x.id);				$('#udoctor').val(x.supp);			$('#uaddressline1').val(x.add1);
			$('#uaddressline2').val(x.add2);	$('#uaddressline3').val(x.add3);		$('#ucity').val(x.city);
			$('#ustate').val(x.state);			$('#upincode').val(x.pin);				$('#ucountry').val(x.country);
			$('#ucontact1').val(x.con1);		$('#ucontact2').val(x.con2);			$('#uemail').val(x.emailid);
			$('#utin').val(x.tin);				$('#ucst').val(x.cst);
		}
	});
	var modal = $('#modal-update');
	modal.modal('show');
});
$('table').on('click', 'a[id=view]', function (e) {
	var txt = $(this).attr("data-val");
	$.ajax({	
		url: 'manage-doctor/return-edit-doctor-info.php?id='+txt,
		type: 'POST',
		success:function(msg){
			var x = JSON.parse(msg);
			$('#vstatus').html(x.status);		$('#vdoctor').html(x.supp);			$('#vaddressline1').html(x.add1);
			$('#vaddressline2').html(x.add2);	$('#vaddressline3').html(x.add3);		$('#vcity').html(x.city);
			$('#vstate').html(x.state);			$('#vpincode').html(x.pin);				$('#vcountry').html(x.country);
			$('#vcontact1').html(x.con1);		$('#vcontact2').html(x.con2);			$('#vemail').html(x.emailid);
			$('#vtin').html(x.tin);				$('#vcst').html(x.cst);
		}
	});
	var modal = $('#modal-view');
	modal.modal('show');
});
$('table').on('click', 'a[id=disable]', function (e) {
	var txt = $(this).attr('data-val');
	var rid = $(this).closest("tr").index();
	if(confirm("Sure to disable doctor?")){
		$.ajax({	
			url: 'manage-doctor/disable-doctor.php?id='+txt,
			type: 'POST',
			success:function(msg){
				var x = msg.split("~");
				if(x[0] != 'ok'){
					alert(msg);
					return false;
				}
				window.location.href="manage-doctor.php";
			}
		});
	}
});
$('table').on('click', 'a[id=enable]', function (e) {
	var txt = $(this).attr('data-val');
	var rid = $(this).closest("tr").index();
	if(confirm("Sure to enable doctor?")){
		$.ajax({	
			url: 'manage-doctor/enable-doctor.php?id='+txt,
			type: 'POST',
			success:function(msg){
				var x = msg.split("~");
				if(x[0] != 'ok'){
					alert(msg);
					return false;
				}
				window.location.href="manage-doctor.php";
			}
		});
	}
});
$('table').on('click', 'a[id=delete]', function (e) {
	var txt = $(this).attr('data-val');
	var rid = $(this).closest("tr").index();
	if(confirm("Sure to delete Doctor?")){
		$.ajax({	
			url: 'manage-doctor/delete-doctor.php?id='+txt,
			type: 'POST',
			success:function(msg){
				if(msg != 'ok'){
					alert(msg);
					return false;
				}
				alert('Doctor Record Deleted !');
				window.location.href = 'manage-doctor.php';
			}
		});
	}
});