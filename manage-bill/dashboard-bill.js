// JavaScript Document

function createNewBill(x){
	$.ajax({
		type: 'post',
		url: 'manage-bill/dashboard-new-billing.php?id='+x,
		success: function(msg) {
			alert(msg);
			window.location.href = 'billing.php';
		}
   });
}

function deleteBill(x){
	if(confirm("Are you sure to cancel Bill?")){
		$.ajax({
			type: 'post',
			url: 'manage-bill/dashboard-delete-billing.php?id='+x,
			success: function(msg) {
				alert(msg);
				window.location.href = 'index.php';
			}
	   });
	}
}

$('table').on('click', 'a[id=deletestc]', function (e) {
	var txt = $(this).attr('data-val');
	var rid = $(this).closest("tr").index();
	if(confirm("Sure to delete Product?")){
		$.ajax({	
			url: 'manage-product/dashboard-delete-product.php?id='+txt+'&&opt=stc',
			type: 'POST',
			success:function(msg){
				if(msg != 'ok'){
					alert(msg);
					return false;
				}
				alert('Product Record Deleted !');
				window.location.href = 'index.php';
			}
		});
	}
});

$('table').on('click', 'a[id=deleteexp]', function (e) {
	var txt = $(this).attr('data-val');
	var rid = $(this).closest("tr").index();
	if(confirm("Sure to delete Product?")){
		$.ajax({	
			url: 'manage-product/dashboard-delete-product.php?id='+txt+'&&opt=exp',
			type: 'POST',
			success:function(msg){
				if(msg != 'ok'){
					alert(msg);
					return false;
				}
				alert('Product Record Deleted !');
				window.location.href = 'index.php';
			}
		});
	}
});