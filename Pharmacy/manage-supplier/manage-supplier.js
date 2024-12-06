// JavaScript Document

function newSupplier(){
	var name = $('#supplier').val();
	var tin = $('#tin').val();
	var cst = $('#cst').val();
	if(name == "") {
		alert("Enter Supplier name");
		return false;
	}
	if(cst =="")
	{
		alert("Enter Tax number");
		return false;
	}
	$.ajax({
        type: 'post',
        url: 'manage-supplier/new-supplier-details.php',
		data: $('#newSupplier').serialize(),
        success: function(msg) {
			// alert(msg);
			// window.location.href="manage-supplier.php";
			if(msg.includes("New Supplier Added!"))
		{
	window.location.href="manage-supplier.php";			
				
		}
		else
		{
			alert(msg);
			 $('#newSupplier')[0].reset();
			}
        }
    });
}
function updateSupplier(){
	var name = $('#usupplier').val();
	if(name == "") {
		alert("Enter Supplier name");
		return false;
	}
	$.ajax({
        type: 'post',
        url: 'manage-supplier/update-supplier-details.php',
		data: $('#updateSupplier').serialize(),
        success: function(msg) {
			alert(msg);
			window.location.href="manage-supplier.php";
        }
    });
}
$('table').on('click', 'a[id=edit]', function (e) {
	var txt = $(this).attr("data-val");
	$.ajax({	
		url: 'manage-supplier/return-edit-supplier-info.php?id='+txt,
		type: 'POST',
		success:function(msg){
			var x = JSON.parse(msg);
			$('#DBid').val(x.id);				$('#usupplier').val(x.supp);			$('#uaddressline1').val(x.add1);
			$('#uaddressline2').val(x.add2);	$('#uaddressline3').val(x.add3);		$('#ucity').val(x.city);
			$('#ustate').val(x.state);			$('#upincode').val(x.pin);				$('#ucountry').val(x.country);
			$('#ucontact1').val(x.con1);		$('#ucontact2').val(x.con2);			$('#uemail').val(x.emailid);
			$('#utin').val(x.tin);				$('#ucst').val(x.cst);					$('#ugstnumber').val(x.gstnumber);
		}
	});
	var modal = $('#modal-update');
	modal.modal('show');
});
$('table').on('click', 'a[id=view]', function (e) {
	var txt = $(this).attr("data-val");
	$.ajax({	
		url: 'manage-supplier/return-edit-supplier-info.php?id='+txt,
		type: 'POST',
		success:function(msg){
			var x = JSON.parse(msg);
			$('#vstatus').html(x.status);		$('#vsupplier').html(x.supp);			$('#vaddressline1').html(x.add1);
			$('#vaddressline2').html(x.add2);	$('#vaddressline3').html(x.add3);		$('#vcity').html(x.city);
			$('#vstate').html(x.state);			$('#vpincode').html(x.pin);				$('#vcountry').html(x.country);
			$('#vcontact1').html(x.con1);		$('#vcontact2').html(x.con2);			$('#vemail').html(x.emailid);
			$('#vtin').html(x.tin);				$('#vcst').html(x.cst);					$('#vgstnumber').html(x.gstnumber);
		}
	});
	var modal = $('#modal-view');
	modal.modal('show');
});
$('table').on('click', 'a[id=disable]', function (e) {
	var txt = $(this).attr('data-val');
	var rid = $(this).closest("tr").index();
	if(confirm("Sure to disable Supplier?")){
		$.ajax({	
			url: 'manage-supplier/disable-supplier.php?id='+txt,
			type: 'POST',
			success:function(msg){
				var x = msg.split("~");
				if(x[0] != 'ok'){
					alert(msg);
					return false;
				}
				window.location.href="manage-supplier.php";
			}
		});
	}
});
$('table').on('click', 'a[id=enable]', function (e) {
	var txt = $(this).attr('data-val');
	var rid = $(this).closest("tr").index();
	if(confirm("Sure to enable Supplier?")){
		$.ajax({	
			url: 'manage-supplier/enable-supplier.php?id='+txt,
			type: 'POST',
			success:function(msg){
				var x = msg.split("~");
				if(x[0] != 'ok'){
					alert(msg);
					return false;
				}
				window.location.href="manage-supplier.php";
			}
		});
	}
});
$('table').on('click', 'a[id=delete]', function (e) {
	var txt = $(this).attr('data-val');
	var rid = $(this).closest("tr").index();
	if(confirm("Sure to delete Supplier?")){
		$.ajax({	
			url: 'manage-supplier/delete-supplier.php?id='+txt,
			type: 'POST',
			success:function(msg){
				if(msg != 'ok'){
					alert(msg);
					return false;
				}
				alert('Supplier Record Deleted !');
				window.location.href = 'manage-supplier.php';
			}
		});
	}
});