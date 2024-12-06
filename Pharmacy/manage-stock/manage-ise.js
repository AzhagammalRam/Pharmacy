// JavaScript Document

$(".number").blur(function(){
	var x = $(this);
	if(!$.isNumeric(x.val())){ x.css("border","2px dotted red"); x.val(''); return false; }
	else{ x.css("border","1px solid #d5d5d5"); }
});
$(".mand").blur(function(){
	var x = $(this);
	if($.trim(x.val()) == ''){ x.css("border","2px dotted red"); x.focus(); return false; }
	else{ x.css("border","1px solid #d5d5d5"); }
});

function validateExpiry(){
	var x = $('#peexpiry').val();
	if(x == ''){ $('#peexpiry').focus(); return false; }
	var xx = x.split("/");
	if(xx[0] > 12) { $('#peexpiry').val(''); $('#peexpiry').focus(); return false; }
	if(xx[1] < 2000 || xx[1] == 'undefined') { $('#peexpiry').val(''); $('#peexpiry').focus(); return false; }
}

function saveInitialItems(){
	var len = $('#tbl-purchase-entry > tbody > tr').length;
	if(len == 0){ alert('Enter atleast one Item'); return false; }
	$.ajax({
        type: 'post',
        url: 'manage-stock/save-ise-info.php',
        success: function(msg) {
			alert(msg);
			window.location.href = 'initial-stock-entry.php';
        }
    });
}

function returnProductInfo(){
	var product = $.trim($('#peproductname').val());
	if(product == '') return false;
	$.ajax({
        type: 'post',
        url: 'manage-stock/return-product-info.php?product='+encodeURIComponent(product),
        success: function(msg) {
			var x = JSON.parse(msg);
			if(x.mrp == null){
				alert('Enter Valid Product Name');
				$('#peproductname').val(''); $('#peproductname').focus();
				return false;
			}
			$('#pemrp').val(x.mrp);
        }
    });
}

function addPurchaseItems(){
	var prod = $.trim($('#peproductname').val()), qty = $.trim($('#peqty').val()), 
	batch = $.trim($('#pebatch').val()), expiry = $.trim($('#peexpiry').val()), mrp = $.trim($('#pemrp').val());
	if(prod == '' || qty == '' || batch == '' || expiry == '')
	{
		alert("Enter All Fields");
		return false;
	}
	if(mrp=='0.00')
		{alert("Enter Mrp amount");
return false;}
	
	$.ajax({
        type: 'post',
        url: 'manage-stock/new-ise.php',
		data: $('#frmPurchaseEntry').serialize(),
        success: function(msg) {
			$('#peproductname').val(''); $('#peqty').val(''); 	$('#pebatch').val('');
			$('#peexpiry').val(''); 	 $('#pemrp').val(''); 	$('#pepprice').val('');
			$('#pevatp').val('');		 $('#pevat').val('');
			var x = JSON.parse(msg);
			var tr = "<tr><td>"+x.code+"</td><td>"+x.descrip+"</td><td>"+x.qty+"</td><td>"+x.batch+"</td><td>"+x.expiry+"</td><td>"+x.pepprice+"</td><td>"+x.mrp+"</td><td>"+x.taxp+"</td><td>"+x.tax_amount+"</td><td><img src='images/delete.png' style='width: 24px; cursor: pointer;' onClick='javascript:deleteItem(this,"+x.id+")' /></td></tr>";
			$('#tbl-purchase-entry > tbody').append(tr);
        }
    });
}

function deleteItem(img, x){
	var row = img.closest("tr"); 
	if(confirm("Are you sure to delete?")){
		$.ajax({
			type: 'post',
			url: 'manage-stock/delete-ise.php?id='+x,
			success: function(msg) {
				if(msg == 'ok'){
					row.remove();
				}else
					alert(msg);
			}
	   });
	}
}