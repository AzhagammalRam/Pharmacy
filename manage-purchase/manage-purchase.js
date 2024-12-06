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
function validatevat(){
	var x = $('#pepprice').val();
	if(x == ''){ $('#pepprice').focus(); return false; }
	var y = $('#pevatp').val();
	if(y == ''){ $('#pevatp').focus(); return false; }
	var z;
	z= x *(y/100);
	$('#pevat').val(truncator(z, 2));
	
}
function validatevatprice(){
	var x = $('#pepprice').val();
	if(x == ''){ $('#pepprice').focus(); return false; }
	
	var y = $('#pevatp').val();
	if(y!=''){
		var z;
		z= x *(y/100);
		
		$('#pevat').val(truncator(z, 2));
	}
}


function truncator(numToTruncate, intDecimalPlaces) {    
    var numPower = Math.pow(10, intDecimalPlaces); // "numPowerConverter" might be better
    return ~~(numToTruncate * numPower)/numPower;
}
shortcut.add("Shift+3",function() {
	// alert("x");
	var product = $.trim($('#peproductname').val());
	if(product == '') return false;
	savePurchaseItems();
});
function savePurchaseItems(){
	var amt = parseFloat($('#lblpamount').html()), adj = parseFloat($('#lblpadj').val());
	var rd_off = parseFloat($('#round_off').val());
	var len = $('#tbl-purchase-entry > tbody > tr').length;
	var peinvoiceno = $('#peinvoiceno').val(), pepurchaseno = $('#pepurchaseno').val();
	var cred = $('#camount').val();
	// if(rd_off > 1 || rd_off < -1)
	// {
	// 	alert('round off value should not be  greater than 1 or lesser than -1'); return false; 
	// }
	if(rd_off < 0)
	{
		rd_off = Math.abs(rd_off);
		if((amt+adj+rd_off) != 0){ alert('Purchase Amount greater / lesser than Invoice Amount'); return false; }	
	}else if(rd_off > 0)
	{
		if((amt+adj-rd_off) != 0){ alert('Purchase Amount greater / lesser than Invoice Amount'); return false; }	
	}
	
	if(len == 0){ alert('Enter atleast one Item'); return false; }
	$.ajax({
        type: 'post',
        url: 'manage-purchase/save-purchase-info.php?invoiceno='+peinvoiceno+'&cred='+cred,
        success: function(msg) {
			alert(msg);
			window.location.href = 'purchase-entry.php';
        }
    });
}

function returnProductInfo(){
	var product = $.trim($('#peproductname').val()), type = $('#petype').val();
	if(product == '' || type == 'SELECT') return false;
	$.ajax({
        type: 'post',
        url: 'manage-purchase/return-product-info.php?product='+encodeURIComponent(product)+"&type="+type,
        success: function(msg) {
			var x = JSON.parse(msg);
			if(x.mrp == null){
				alert('Enter Valid Product Name');
				$('#peproductname').val(''); $('#peproductname').focus(); 	$('#petype').val('SELECT');
				return false;
			}
			
			$('#pemrp').val(x.mrp);		$('#pevatp').val(x.vat); $('#unitdesc').val(x.unitdec)	
        }
    });
}

function returnpreviousprice(){
	var product = $.trim($('#peproductname').val()), type = $('#petype').val();
	var supplierid=$.trim($('#supplierid').val());

	var intqty= parseInt($('#peqty').val());
	var intpepprice= $('#pepprice').val();
// alert(qty);
	$.ajax({
        type: 'post',
        url: 'manage-purchase/return-purchase-price.php?product='+encodeURIComponent(product)+"&type="+type+"&supplierid="+supplierid+"&intqty="+intqty+"&intpepprice="+intpepprice,
        success: function(msg) {
		if(msg =='Empty'){
			return false;
		}
		if(msg !=''){
			alert(msg);
		}
        }
    });
}


function getAval()

{
	var totalavail=0;
	var unitdesc= $('#unitdesc').val();
	var qty= parseInt($('#peqty').val());
	var free= parseInt($('#pefree').val());
	 totalavail=(qty+free)*unitdesc
	$('#totaval').val(totalavail);
	
	}

function addPurchaseItems(){
	//alert($('#frmPurchaseEntry').serialize())
	var x=$.trim($('#taxtype').val());
	//alert(x)
	var prod = $.trim($('#peproductname').val()), qty = $.trim($('#peqty').val()), free = $.trim($('#pefree').val()), batch = $.trim($('#pebatch').val()),
		expiry = $.trim($('#peexpiry').val()), price = $.trim($('#pepprice').val()), mrp = $.trim($('#pemrp').val());
	if(prod == '' || qty == '' || free == '' || batch == '' || expiry == '' || price == '')
		return false;
	if(mrp=='0.00')
		{alert("Enter Mrp Amount");
return false;}
	$.ajax({
        type: 'post',
        url: 'manage-purchase/new-purchase-item.php',
		data: $('#frmPurchaseEntry').serialize(),
        success: function(msg) {
			$('#peproductname').val(''); $('#peqty').val(''); 	$('#pefree').val('0'); 	$('#pebatch').val('');    $('#unitdesc').val(''); $('#totaval').val('');
			$('#peexpiry').val(''); 	$('#pepprice').val(''); $('#pemrp').val('');	$('#petype').val('SELECT');		$('#pevat').val(''); $('#pevat').val('');
			var x = JSON.parse(msg);
			var tr = "<tr><td>"+x.code+"</td><td>"+x.type+"</td><td>"+x.descrip+"</td><td>"+x.qty+"</td><td>"+x.free+"</td><td>"+x.batch+"</td><td>"+x.expiry+"</td><td>"+x.price+"</td><td>"+x.mrp+"</td><td>"+x.vat+"</td><td>"+x.gross+"</td><td>"+x.net+"</td><td><img src='images/delete.png' style='width: 24px; cursor: pointer;' onClick='javascript:deletepurItem(this,"+x.id+")' /></td></tr>";
			$('#tbl-purchase-entry > tbody').append(tr);
			var tot = x.qty * x.price + x.gross;
			$('#lblpamount').html(parseFloat(tot + parseFloat($('#lblpamount').html())).toFixed(2));
			$('#round_off').val(parseFloat($('#lblpamount').html()).toFixed(2));
        }
    });
}

$('#invoicetype').on('change',function(){
	var x = $('#invoicetype').val();
	if(x == 0){
		$('#divcash').hide();
		$('#divcr').hide();
		$('#paymentamt').val('');	$('#payable').val('');
	}else if(x == 'CASH'){
		$('#divcash').show();
		$('#divcr').hide();
	}else if(x == 'CR'){
		$('#divcr').show();
		$('#paymentamt').val('');	$('#payable').val('');
		$('#divcash').hide();
	}
});

function deletePurchase(){
	var id = $('#purchaseid').val();
	if(id == '') return false;
	if(confirm("Are you sure to delete this Purchase details?")){
		$.ajax({
			type: 'post',
			url: 'manage-purchase/delete-purchase-info.php?id='+id,
			success: function(msg) {
				alert(msg);
				window.location.href = 'purchase-entry.php';
			}
		});
	}
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

function savePurchase(){
	var credit_check=$('#purchase_val').val();
	
	var supp = $.trim($('#supplier').val()), invoiceno = $.trim($('#invoiceno').val()), invoiceamt = $.trim($('#invoiceamt').val()),creditval = $.trim($('#creditval').val());
	var invoicetype = $('#invoicetype').val();
	if(parseInt(credit_check) < parseInt(creditval)){alert(' Credit balance cannot be greater than invoice amount'); return false;}
	if(supp == ''){ alert('Supplier Details Cannot be Left Blank'); return false; }
	if(invoiceno == ''){ alert('Invoice # Cannot be Left Blank'); return false; }
	if(invoiceamt == ''){ alert('Invoice Amount Cannot be Left Blank'); return false; }
	if(invoicetype == 0){ alert('Select Invoice Type'); return false; }
	else if(invoicetype == 'CASH'){
		if($.trim($('#paymentdate').val()) == ''){ alert('Payment Date Cannot be Left Blank'); return false; }
		if($.trim($('#paymentamt').val()) == ''){ alert('Amount Cannot be Left Blank'); return false; }
		if($.trim($('#payable').val()) == ''){ alert('Payable Cannot be Left Blank'); return false; }
	}else if(invoicetype == 'CR'){
		if($.trim($('#creditdate').val()) == ''){ alert('Credit Date Cannot be Left Blank'); return false; }
	}
	
	var paymentamt = $('#paymentamt').val();
	var creditval = $('#creditval').val();
	

	if(parseFloat(invoiceamt) < parseFloat(paymentamt)){
		alert('Payment Amount must be lesser or equal to Invoice amount');
		$('#paymentamt').val('');
		return false;
	}
	
	$.ajax({
        type: 'post',
        url: 'manage-purchase/new-purchase-entry.php',
		data: $('#frmPurchase').serialize(),
        success: function(msg) {
			if($.trim(msg) != "ERROR"){
			 // localStorage.setItem('creditstore', creditval);

				$('#purchaseid').val($.trim(msg));		$('#pepurchaseno').val($.trim(msg));
				$('#peinvoiceno').val($.trim(invoiceno));
				window.location.href = 'purchase-entry.php';
			}else
				alert(msg);
        }
    });
}

$('#mdlPurchase').on('show.bs.modal', function (event) {
	var inv = $('#peinvoiceno').val(), pur = $('#pepurchaseno').val();
	if(pur == '' || inv == '') return false;
						// var cerd =  localStorage.getItem('creditstore', creditval);
						// $('#prev_credit').html(cerd);
	$.ajax({
        type: 'post',
        url: 'manage-purchase/return-purchase-entry.php?pur='+pur+"&inv="+inv,
        success: function(msg) {
			var x = JSON.parse(msg);
			var tot = 0;
			for(var i=0;i<x.length;i++){
				var tr = '<tr><td>'+x[i].code+'</td><td>'+x[i].stocktype+'</td><td>'+x[i].descrip+'</td><td>'+x[i].qty+'</td><td>'+x[i].free+'</td><td>'+x[i].batch+'</td><td>'+x[i].expiry+'</td><td>'+x[i].price+'</td><td>'+x[i].mrp+'</td><td>'+x[i].vat+'</td><td>'+x[i].gross+'</td><td>'+x[i].net+'</td><td><img src="images/delete.png" style="width: 24px; cursor: pointer;" onClick="javascript:deletepurItem(this,'+x[i].id+')" /></td></tr>';
				tot += parseFloat(x[i].net);
				$('#tbl-purchase-entry > tbody').append(tr);
			}
			$('#lblpamount').html(parseFloat(tot - parseFloat($('#lblpamount').html())).toFixed(2));
			$('#round_off').val(parseFloat($('#lblpamount').html()).toFixed(2));
        }
    });
});

function deletepurItem(img, x){
	var row = img.closest("tr");
	var qty = $(row).find("td").eq(3).text();
	var price = $(row).find("td").eq(7).text();
	// var tax_percent = $(row).find("td").eq(9).text();
	var tax = $(row).find("td").eq(10).text();
	var tax_amt = parseFloat(tax);
	var amt1 = parseFloat(qty) * parseFloat(price);
	var amt = amt1 + tax_amt;
	if(confirm("Are you sure to delete?")){
		$.ajax({
			type: 'post',
			url: 'manage-purchase/delete-purchase-entry.php?id='+x,
			success: function(msg) {
				if(msg == 'ok'){
					row.remove();
					
					$('#lblpamount').html("-"+(amt - parseFloat($('#lblpamount').html())).toFixed(2));
					$('#round_off').val(parseFloat($('#lblpamount').html()).toFixed(2));

				}else
					alert(msg);
			}
	   });
	}
}
$(document).ready(function() {
	$("#peexpiry").keyup(function(){
		if ($(this).val().length == 2){
			$(this).val($(this).val() + "/");
		}
	});
});

function rptDisplay(){
var dtfrom = $('#dtfrom').val(), dtto = $('#dtto').val(),invoice = $('#invoice').val(), supplier = $('#supplier').val();
	if(dtfrom == '' || dtto == '' || supplier == '' || invoice == '') return false;
	$.ajax({
        type: 'post',
        url: 'manage-purchase/return-purchase-return.php?dtfrom='+dtfrom+"&dtto="+dtto+"&invoice="+invoice+"&supplier="+supplier,
        success: function(msg) {
			var x = JSON.parse(msg);
			var tot = 0;
			for(var i=0;i<x.length;i++){
				var tr = '<tr><td>'+x[i].date+'</td><td>'+x[i].invoice+'</td><td>'+x[i].supplier+'</td><td>'+x[i].amount+'</td></tr>';
				tot += parseFloat(x[i].net);
				$('#tbl-purchase-return > tbody').append(tr);
			}
			// $('#lblpamount').html(parseFloat(tot - parseFloat($('#lblpamount').html())).toFixed(2));
        }
    });
}


function savePurchareReturnData(){
	var data = $("#tbl-purchase-return-data").serializeArray();

if(error <= 0){	
var pdata=[];

	for (var i=0;i<data.length;i+=7) {
		if(!data[i+3].value || !data[i+4].value || !data[i+5].value )
		{
			alert('please enter all fields correctly');
			return false;
			
		}
	pdata.push({invoice: data[i].value, 
		supplierid: data[i+1].value, 
		pname: data[i+2].value, 
		qty: data[i+3].value , 
		reason: data[i+4].value, 
		price: data[i+5].value,
		pid: data[i+6].value });
	}


	$.ajax({
        type: 'post',
        url: 'manage-purchase/update-purchase-return-items.php',
        data: {
  		    data: pdata
  		},
        success: function(msg) {
			var x = JSON.parse(msg);
			for(var i=0;i<x.length;i++){
				alert('Return Invoice: '+x[i].return_invoice);
				var win = window.open("purchase-returnbill.php?rid="+x[i].lastid);
				$('#mdlpurchaseitems').modal('hide');
			}
        }
    });
}
else
{
	alert('Please check available quantity')
}
}
var error=0;
function checkqty(x,id)
{
	
	var aval=x;
	var qty=
	$('#qty'+id).val();
	if(parseInt(aval) < parseInt(qty))
	{
		error=error+1;
		$('#qty'+id).addClass('errorqty');
	$('#qty'+id).focus();
	}
	else{
	 error-=1;
	 $('#qty'+id).removeClass('errorqty');
	}

}