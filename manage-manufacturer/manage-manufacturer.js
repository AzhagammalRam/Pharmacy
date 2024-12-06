// JavaScript Document

function newManufacturer(){
	var name = $('#manufacturer').val();
	if(name == "")
	{
		alert("Enter manufacturer name");
		return false;
	} 
	
	$.ajax({
        type: 'post',
        url: 'manage-manufacturer/new-manufacturer-details.php',
		data: $('#newManufacturer').serialize(),
        success: function(msg) {
			// alert(msg);
			// window.location.href="manage-manufacturer.php";
			if(msg.includes("New Manufacturer Added!"))
		{
	 window.location.href="manage-manufacturer.php";
			
				
		}
		else
		{
			alert(msg);
			 $('#newManufacturer')[0].reset();
			}
        }
    });
}
function updateManufacturer(){
	var name = $('#umanufacturer').val();
	if(name == "") return false;
	$.ajax({
        type: 'post',
        url: 'manage-manufacturer/update-manufacturer-details.php',
		data: $('#updateManufacturer').serialize(),
        success: function(msg) {
			alert(msg);
			window.location.href="manage-manufacturer.php";
        }
    });
}
$('table').on('click', 'a[id=edit]', function (e) {
	var txt = $(this).attr("data-val");
	$.ajax({	
		url: 'manage-manufacturer/return-edit-manufacturer-info.php?id='+txt,
		type: 'POST',
		success:function(msg){
			var x = JSON.parse(msg);
			$('#DBid').val(x.id);				$('#umanufacturer').val(x.manuf);		$('#uaddressline1').val(x.add1);
			$('#uaddressline2').val(x.add2);	$('#uaddressline3').val(x.add3);		$('#ucity').val(x.city);
			$('#ustate').val(x.state);			$('#upincode').val(x.pin);				$('#ucountry').val(x.country);
			$('#ucontact1').val(x.con1);		$('#ucontact2').val(x.con2);			$('#uemail').val(x.emailid);
		}
	});
	var modal = $('#modal-update');
	modal.modal('show');
});
$('table').on('click', 'a[id=view]', function (e) {
	var txt = $(this).attr("data-val");
	$.ajax({	
		url: 'manage-manufacturer/return-edit-manufacturer-info.php?id='+txt,
		type: 'POST',
		success:function(msg){
			var x = JSON.parse(msg);
			$('#vstatus').html(x.status);		$('#vmanufacturer').html(x.manuf);		$('#vaddressline1').html(x.add1);
			$('#vaddressline2').html(x.add2);	$('#vaddressline3').html(x.add3);		$('#vcity').html(x.city);
			$('#vstate').html(x.state);			$('#vpincode').html(x.pin);				$('#vcountry').html(x.country);
			$('#vcontact1').html(x.con1);		$('#vcontact2').html(x.con2);			$('#vemail').html(x.emailid);
		}
	});
	var modal = $('#modal-view');
	modal.modal('show');
});
$('table').on('click', 'a[id=disable]', function (e) {
	var txt = $(this).attr('data-val');
	var rid = $(this).closest("tr").index();
	if(confirm("Sure to disable Manufacturer?")){
		$.ajax({	
			url: 'manage-manufacturer/disable-manufacturer.php?id='+txt,
			type: 'POST',
			success:function(msg){
				var x = msg.split("~");
				if(x[0] != 'ok'){
					alert(msg);
					return false;
				}
				window.location.href="manage-manufacturer.php";
			}
		});
	}
});
$('table').on('click', 'a[id=enable]', function (e) {
	var txt = $(this).attr('data-val');
	var rid = $(this).closest("tr").index();
	if(confirm("Sure to enable Manufacturer?")){
		$.ajax({	
			url: 'manage-manufacturer/enable-manufacturer.php?id='+txt,
			type: 'POST',
			success:function(msg){
				var x = msg.split("~");
				if(x[0] != 'ok'){
					alert(msg);
					return false;
				}
				window.location.href="manage-manufacturer.php";
			}
		});
	}
});
$('table').on('click', 'a[id=delete]', function (e) {
	var txt = $(this).attr('data-val');
	var rid = $(this).closest("tr").index();
	if(confirm("Sure to delete Manufacturer?")){
		$.ajax({	
			url: 'manage-manufacturer/delete-manufacturer.php?id='+txt,
			type: 'POST',
			success:function(msg){
				if(msg != 'ok'){
					alert(msg);
					return false;
				}
				alert('Manufacturer Record Deleted !');
				window.location.href = 'manage-manufacturer.php';
			}
		});
	}
});