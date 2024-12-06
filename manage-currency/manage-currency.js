$(function() {
	$("#newcurrency").submit(function(){
		var formValues = $(this).serialize();
		$.ajax({
			url: "manage-currency/new-currency-details.php",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success: function(msg){
				if(msg.includes("sucess")){
					window.location.href="manage-currency.php";
				}
				else{
					alert(msg);
				}
			}
		});
		return false;
	});
});


function updatecurrency(){
	var name = $('#ucurrency').val();
	if(name == "") return false;
	$.ajax({
        type: 'post',
        url: 'manage-currency/update-currency-details.php',
		data: $('#updatecurrency').serialize(),
        success: function(msg) {
			alert(msg);
			window.location.href="manage-currency.php";
        }
    });
}
$('table').on('click', 'a[id=edit]', function (e) {
	var txt = $(this).attr("data-val");
	$.ajax({	
		url: 'manage-currency/return-edit-currency-info.php?id='+txt,
		type: 'POST',
		success:function(msg){
			var x = JSON.parse(msg);
			$('#DBid').val(x.id);				$('#ucurrency').val(x.currency); $('#ubase_currency').val(x.base_currency);			
		}
	});
	var modal = $('#modal-update');
	modal.modal('show');
});
$('table').on('click', 'a[id=view]', function (e) {
	var txt = $(this).attr("data-val");
	$.ajax({	
		url: 'manage-currency/return-edit-currency-info.php?id='+txt,
		type: 'POST',
		success:function(msg){
			var x = JSON.parse(msg);
			$('#vcurrency').html(x.currency); $('#vbase_currency').html(x.base_currency);		$('#vstatus').html(x.status);			
		}
	});
	var modal = $('#modal-view');
	modal.modal('show');
});
$('table').on('click', 'a[id=disable]', function (e) {
	var txt = $(this).attr('data-val');
	var rid = $(this).closest("tr").index();
	if(confirm("Sure to disable currency?")){
		$.ajax({	
			url: 'manage-currency/disable-currency.php?id='+txt,
			type: 'POST',
			success:function(msg){
				var x = msg.split("~");
				if(x[0] != 'ok'){
					alert(msg);
					return false;
				}
				window.location.href="manage-currency.php";
			}
		});
	}
});
$('table').on('click', 'a[id=enable]', function (e) {
	var txt = $(this).attr('data-val');
	var rid = $(this).closest("tr").index();
	if(confirm("Sure to enable currency?")){
		$.ajax({	
			url: 'manage-currency/enable-currency.php?id='+txt,
			type: 'POST',
			success:function(msg){
				var x = msg.split("~");
				if(x[0] != 'ok'){
					alert(msg);
					return false;
				}
				window.location.href="manage-currency.php";
			}
		});
	}
});
$('table').on('click', 'a[id=delete]', function (e) {
	var txt = $(this).attr('data-val');
	var rid = $(this).closest("tr").index();
	if(confirm("Sure to delete Currency?")){
		$.ajax({	
			url: 'manage-currency/delete-currency.php?id='+txt,
			type: 'POST',
			success:function(msg){
				if(msg != 'ok'){
					alert(msg);
					return false;
				}
				alert('Currency Record Deleted !');
				window.location.href = 'manage-currency.php';
			}
		});
	}
});