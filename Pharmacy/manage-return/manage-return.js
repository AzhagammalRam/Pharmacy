function returnPurchase(){
	var supp = $.trim($('#supplier').val());
	if(supp == ''){ alert('Supplier Details Cannot be Left Blank'); return false; }
	
	
	$.ajax({
        type: 'post',
        url: 'manage-return/new-purchase-return-entry.php',
		data: $('#frmPurchase').serialize(),
        success: function(msg) {
			if($.trim(msg) != "ERROR"){
			 	$('#preturnno').val($.trim(msg));		
				$('#mdlPurchaseReturn').modal('show');
				$('#supplier').val(''), $('#address1').val(''), $('#address2').val(''), $('#address3').val(''), $('#contact1').val('');
			}else
				alert(msg);
        }
    });
}

function supplierDetails(){
	var supp = $.trim($('#supplier').val());
	if(supp == '') return false;
	$.ajax({
        type: 'post',
        url: 'manage-supplier/return-supplier-info.php?supplier='+encodeURIComponent(supp),
        success: function(msg) {
			var x = JSON.parse(msg);
			if(x.id == null){
				alert('Enter Valid Supplier Name');
				$('#supplier').val('');
				$('#address1').val('');	$('#address2').val('');	$('#supplierid').val('');
				$('#address3').val('');	$('#contact1').val(''); $('#creditval') .val('');
				return false;
			}
			$('#address1').val(x.add1);	$('#address2').val(x.add2);	$('#supplierid').val(x.id);
			$('#address3').val(x.add3);	$('#contact1').val(x.con1); $('#creditval') .val(x.credit),$('#purchase_val') .val(x.credit);
        }
    });
}

$('#mdlPurchaseReturn').on('show.bs.modal', function (event) {
	// var pr = $('#preturnno').val();
	// $.ajax({
 //        type: 'post',
 //        url: 'manage-return/return-purchase-return-others.php?pr='+pr,
 //        success: function(msg) {
	// 		var x = JSON.parse(msg);
	// 		var tot = 0;
	// 		for(var i=0;i<x.length;i++){
	// 			var tr = '<tr><td>'+x[i].code+'</td><td>'+x[i].descrip+'</td><td>'+x[i].qty+'</td><td>'+x[i].free+'</td><td>'+x[i].batch+'</td><td>'+x[i].expiry+'</td><td>'+x[i].price+'</td><td>'+x[i].mrp+'</td><td>'+x[i].vat+'</td><td>'+x[i].gross+'</td><td>'+x[i].net+'</td><td><img src="images/delete.png" style="width: 24px; cursor: pointer;" onClick="javascript:deletepurItem(this,'+x[i].id+')" /></td></tr>';
	// 			tot += parseFloat(x[i].net);
	// 			$('#tbl-purchase-return-others > tbody').append(tr);
	// 		}
	// 		$('#lblpamount').html(parseFloat(tot - parseFloat($('#lblpamount').html())).toFixed(2));
 //        }
 //    });
});

function retBatchNoother(){
	var prod = $('#peproductname').val(), type = $('#ptype').val();
	if($.trim(prod) == '') return false;
	
	$.ajax({
		type: 'post',
		url: 'manage-return/return-batchno.php?prod='+encodeURIComponent(prod)+"&type="+type,
		success: function(msg) {
			if($.trim(msg) == ''){
				alert('No Product Found !');	$('#pname').val('');
			}else if($.trim(msg) == 'error1'){
				alert('Invalid Product !');		$('#pname').val('');
			}else{
				var xx = JSON.parse(msg);
				$('#batch').empty();
				$('#batch').append(new Option("SELECT"));
				for(var i=0;i<xx.length;i++)
					$('#batch').append(new Option(xx[i].batch));
			}
		}
	});
}
function returnExpiryothers(){
	
	var prod = $('#peproductname').val(), batch = $('#batch').val(), type = $('#ptype').val();
	if(batch == 'SELECT') return false;
	$.ajax({
		type: 'post',
		url: 'manage-return/return-aval.php?prod='+encodeURIComponent(prod)+"&batch="+batch,
		success: function(msg) {
			var x = JSON.parse(msg);
			$('#aval').empty();
            $('#expiry').val(x.expirydate);
            $('#aval').val(x.aval);
            $('#product_id').val(x.id);
		}
	});
	
		


}

function addPurchaseReturnItems()
{
	var prod = $('#peproductname').val(), qty=$('#qty').val(), reason=$('#reason').val(),price=$('#uprice').val(), aval=$('#aval').val(), id = $('#preturnno').val(), productid=$('#product_id').val();
	$.ajax({
		type: 'post',
		url: 'manage-return/update-return-items.php',
		data:{
			pname:prod,
			qty:qty,
			reason:reason,
			price:price,
			id:id,
			purchaseid:productid
		},
		success: function(msg) {
			var x = JSON.parse(msg);
			for(var i=0;i<x.length;i++){
			var tr = '<tr><td><input type="hidden" name="name" value="'+x[i].pname+'">'+x[i].pname+'</td><td><input type="hidden" name="qty" value="'+x[i].qty+'">'+x[i].qty+'</td><td>'+x[i].reason+'</td><td><input type="hidden" name="price" value="'+x[i].price+'">'+x[i].price+'</td><input type="hidden" name="purchaseid" value="'+x[i].purchaseid+'"><td><img src="images/delete.png" style="width: 24px; cursor: pointer;" onClick="javascript:deletereturnItem(this,'+x[i].id+','+x[i].price+')" /></td></tr>';
			$('#tbl-purchase-return-others > tbody').append(tr);
			 
			 $('#peproductname').val(''),$('#qty').val(''),$('#reason').val(''),$('#uprice').val(''),$('#aval').val(''), 
			 $('#expiry').val(''), $('#batch').val('SELECT');
		}
		}
	});
}

function deletereturnItem(img, x, amt){
	var row = img.closest("tr");
	if(confirm("Are you sure to delete?")){
		$.ajax({
			type: 'post',
			url: 'manage-return/delete-purchase-return-entry.php?id='+x+"&amt="+amt,
			success: function(msg) {
				if(msg == 'ok'){
					row.remove();
				}else
					alert(msg);
			}
	   });
	}
}
function savePurchaseReturnItems(){
var data = $('#purchasereturnitems').serializeArray();
var id=$('#preturnno').val();
var prdata=[];

	for (var i=0;i<data.length;i+=4) {
	
		prdata.push({
			pname: data[i].value, 
			qty: data[i+1].value, 
			price: data[i+2].value,
			purchaseid: data[i+3].value
		 });
	}
	$.ajax({
		type: 'post',
		url: 'manage-return/update-return-item-status.php',
		data:{
			data:prdata,
			id:id
			
		},
		success: function(msg) {
			$('#mdlPurchaseReturn').hide();
			$('#supplier').val('');
			$('#address1').val('');	$('#address2').val('');	$('#supplierid').val('');
			$('#address3').val('');	$('#contact1').val('');
			var win = window.open("purchase-returnbill.php?rid="+msg);
		}
	});
}