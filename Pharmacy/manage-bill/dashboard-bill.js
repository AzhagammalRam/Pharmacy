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
