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

function retBatchNo(){
var prod = $('#pname').val();
if($.trim(prod) == '' || prod == 'SELECT') return false;
$.ajax({
type: 'post',
url: 'manage-bill/return-batchno.php?prod='+encodeURIComponent(prod),
success: function(msg) {
if($.trim(msg) == ''){
alert('No Product Found !');	$('#pname'+x).val('');
}else if($.trim(msg) == 'error1'){
alert('Invalid Product !');		$('#pname'+x).val('');
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

function retExpiry(){
var x = $('#adjtype').val();
if(x == "Addition") return false;
var prod = $('#pname').val(), batch = $('#batch').val();
if(batch == 'SELECT' || prod == '') return false;
$.ajax({
type: 'post',
url: 'manage-bill/return-expiry.php?prod='+encodeURIComponent(prod)+"&batch="+batch,
success: function(msg1) {
// alert(msg1);
var xxy = JSON.parse(msg1);
// alert(JSON.stringify(xxy[0].expirydate))
$('#expiry').empty();
$('#expiry').val(xxy[0].expirydate);
}
});
if(batch == 'SELECT') return false;
$.ajax({
type: 'post',
url: 'manage-bill/avail-qty.php?prod='+encodeURIComponent(prod)+"&batch="+batch,
success: function(msg) {

var xx = JSON.parse(msg);
$('#qty').empty();
$('#qty').val(xx);

}
});
}

function validateQty(){
var x = $('#qty').val();
// if(x == "Addition") return false;
var prod = $('#pname').val(), batch = $('#batch').val();

$.ajax({
type: 'post',
url: 'manage-bill/avail-qty.php?prod='+encodeURIComponent(prod)+"&batch="+batch,
success: function(msg) {

var xx = JSON.parse(msg);
if(parseFloat(msg) < parseFloat(x)){
alert('Qty must be lesser than Avail');
$('#qty').val('');
}
}


});
}


function addstockclearance(){
	var Product = $('#pname').val();
	var batch = $('#batch').val()
	var quantity = $('#qty').val();
	var expiry = $('#expiry').val();
	var reason = $('#reason').val();
if(Product == '') 
{
	alert("Product name cannot be empty");
	return false;
}
if(batch == 'SELECT') 
{
	alert("Select Batch Number");
	return false;
}
if(quantity == '') 
{
	alert("Quantity name cannot be empty");
	return false;
}
if(expiry == '') 
{
	alert("Expiry name cannot be empty");
	return false;
}
	// var prod = $.trim($('#peproductname').val()), qty = $.trim($('#peqty').val()), 
	$.ajax({
        type: 'post',
        url: 'manage-stock/new-stockclearance.php?prod='+encodeURIComponent(Product)+"&expiry="+expiry+"&quantity="+quantity,
		data: $('#frmclearance').serialize(),
        success: function(msg) {
			$('#batch').val(''); $('#expiry').val('');
			$('#qty').val(''); 	$('#reason').val('');
			 $('#pname').val('');
			 console.log(msg);
      $('#results').html(msg)
        }
    });
}
function deleteclearance(x){
	if(confirm("Are you sure to delete?")){
		$.ajax({
			type: 'post',
			url: 'manage-stock/delete-stock-clearance.php?id='+x,
			success: function(msg) {
      $('#results').html(msg)
			}
	   });
	}
}

function saveallwastage(){
		$.ajax({
			type: 'post',
			url: 'manage-stock/save-stockclearance.php',
			success: function(msg) {
				alert(msg);
window.location.href = 'stock-wastage.php';
			}
	   });
}


function deleteunused(){
	var tbody = $("#tbl-list tbody");
	if (tbody.children().length == 0) {
	alert('Table should not blank');
	return false;}
	var table = $("#tbl-list");
    var asset = [];
    table.find('tbody > tr').each(function (rowIndex, r) {
        var cols = [];
        $(this).find('td').each(function (colIndex, c) {       	
			if (colIndex==0)			
		{
			if($('#checkind_'+rowIndex).prop('checked')==true)
			{
			cols.push(1);
			}
			else
			{
			cols.push(0);
			}
			}
            cols.push($.trim(c.textContent));
        });
        asset.push(cols);
        alert(asset);
        
    });
	$.ajax({
		type: 'post',
		url: 'manage-stock/unusedstocks.php',
		data: {
			assets: asset,
		},
		success: function(msg) {
		alert(msg);
		window.location.href = 'unused-products.php';
		}
	});
}



function validateExpiry(){
var x = $('#expiry').val();
if(x == ''){ $('#expiry').focus(); return false; }
var xx = x.split("/");
if(isNaN(xx[0])){ $('#expiry').val(''); $('#expiry').focus(); return false; }
if(isNaN(xx[1])) { $('#expiry').val(''); $('#expiry').focus(); return false; }
if(xx[0] > 12) { $('#expiry').val(''); $('#expiry').focus(); return false; }
if(xx[1] < 2000 || xx[1] == 'undefined') { $('#expiry').val(''); $('#expiry').focus(); return false; }

}