// JavaScript Document

/*function stockTypeList(op){
	if(op == 'u')
		var stocktype = $('#ustocktype').val();
	else
		var stocktype = $('#stocktype').val();
	if(stocktype != "") return false;
	$('#lstStockType').empty();
	$.ajax({
        type: 'post',
        url: 'manage-product/return-stocktype-list.php',
        success: function(msg) {
			var x = JSON.parse(msg);
			for(var i=0;i<x.length;i++)
				$('#lstStockType').append(new Option(x[i].stocktype));
        }
    });
}*/
function calvalidation(x) {
	var maxval=x.val();
	var minval = $('#minqty').val();
	maxval=parseInt(maxval);
	minval=parseInt(minval);
	
	if(maxval < minval) {
	alert('Maximun Quantity should not greater than Minimum');
	$('#minqty').val("");
	x.val("");
	return false;
	}
	//alert(maxval);
	}
		
		
function manuList(op){
	if(op == 'u')
		var manufact = $('#umanufact').val();
	else
		var manufact = $('#manufact').val();
	if(manufact != "") return false;
	$('#lstmanufact').empty();
	$.ajax({
        type: 'post',
        url: 'manage-product/return-manufacturer-list.php',
        success: function(msg) {
			var x = JSON.parse(msg);
			for(var i=0;i<x.length;i++)
				$('#lstmanufact').append(new Option(x[i].manufacturer));
        }
    });
}
function valManuf(op){
	if(op == 'u')
		var manufact = $('#umanufact');
	else
		var manufact = $('#manufact');
	var val = $(manufact).val();
	if(val == "") return false;
	$.ajax({
        type: 'post',
        url: 'manage-product/validate-manufacturer.php?manuf='+encodeURIComponent(val),
        success: function(msg) {
			if($.trim(msg) == 'invalid'){
				if(confirm('Invalid Manufacturer Detail \n Do You want to add Manufacturer Detail')){
					$('#modal-new-manufacturer').modal('show');
				}
				$(manufact).val('');
				$(manufact).focus();
			}
        }
    });
}
function calcUnitPrice(op){
	if(op == 'u'){
		var mrp = $('#umrp').val(), u = $('#uunitdesc').val();
	}else{
		var mrp = $('#mrp').val(), u = $('#unitdesc').val();
	}
	if($.isNumeric(mrp) && $.isNumeric(u) && mrp != 0 && u != 0){
		var x = (parseFloat(mrp) / parseFloat(u)).toFixed(2);
		if(op == 'u') $('#uprice').val(x); else $('#price').val(x);
	}else{
		if(op == 'u') $('#uprice').val('0'); else $('#price').val('0');
	}
}
function newManufacturer(){
	var name = $('#manufacturer').val();
	if(name == "") return false;
	$.ajax({
        type: 'post',
        url: 'manage-manufacturer/new-manufacturer-details.php',
		data: $('#newManufacturer').serialize(),
        success: function(msg) {
			alert(msg);
			$('#newManufacturer')[0].reset();
			$('#modal-new-manufacturer').modal('hide');
        }
    });
}
function newProduct(){
	if($.trim($('#product').val())== ""){ $('#product').css("border","2px dotted red"); return false; }
	else{ $('#product').css("border","1px solid #d5d5d5"); }
	if($.trim($('#manufact').val())== ""){ $('#manufact').css("border","2px dotted red"); return false; }
	else{ $('#manufact').css("border","1px solid #d5d5d5"); }
	if($.trim($('#unitdesc').val())== ""){ $('#unitdesc').css("border","2px dotted red"); return false; }
	else{ $('#unitdesc').css("border","1px solid #d5d5d5"); }
	$.ajax({
        type: 'post',
        url: 'manage-product/new-product-details.php',
		data: $('#newProduct').serialize(),
        success: function(msg) {
			alert(msg);
			$('#newProduct')[0].reset();
			window.location.href="manage-product.php";
        }
    });
}
function updateProduct(){
	if($.trim($('#uproduct').val())== ""){ $('#uproduct').css("border","2px dotted red"); return false; }
	else{ $('#uproduct').css("border","1px solid #d5d5d5"); }
	if($.trim($('#umanufact').val())== ""){ $('#umanufact').css("border","2px dotted red"); return false; }
	else{ $('#umanufact').css("border","1px solid #d5d5d5"); }
	if($.trim($('#uunitdesc').val())== ""){ $('#uunitdesc').css("border","2px dotted red"); return false; }
	else{ $('#uunitdesc').css("border","1px solid #d5d5d5"); }
	$.ajax({
        type: 'post',
        url: 'manage-product/update-product-details.php',
		data: $('#updateProduct').serialize(),
        success: function(msg) {
			alert(msg);
			$('#updateProduct')[0].reset();
			window.location.href="manage-product.php";
        }
    });
}
$('table').on('click', 'a[id=edit]', function (e) {
	var txt = $(this).attr("data-val");
	$.ajax({	
		url: 'manage-product/return-edit-product-info.php?id='+txt,
		type: 'POST',
		success:function(msg){
			var x = JSON.parse(msg);
			$('#DBid').val(x.id);				$('#uproduct').val(x.product);		$('#ugeneric').val(x.generic);
			$('#umanufact').val(x.manuf);		$('#uschedule').val(x.schedule);	$('#uproducttype').val(x.ptype);
			$('#uunitdesc').val(x.unitd);		$('#ustocktype').val(x.stype);		$('#uptax').val(x.ptax);
			$('#ustax').val(x.stax);			$('#umrp').val(x.mrp);				$('#uprice').val(x.price);
			$('#uminqty').val(x.minqty);		$('#umaxqty').val(x.maxqty);		$('#ushelf').val(x.shelf);	$('#urack').val(x.rack); $('#uhsncode').val(x.hsncode);
			$('#ucliam_type').val(x.claim_type);
		}
	});
	var modal = $('#modal-update');
	modal.modal('show');
});
$('table').on('click', 'a[id=view]', function (e) {
	var txt = $(this).attr("data-val");
	$.ajax({	
		url: 'manage-product/return-edit-product-info.php?id='+txt,
		type: 'POST',
		success:function(msg){
			var x = JSON.parse(msg);
			$('#vstatus').html(x.status);		$('#vproduct').html(x.product);		$('#vgeneric').html(x.generic);
			$('#vmanufact').html(x.manuf);		
			$('#vunitdesc').html(x.unitd);		$('#vstocktype').html(x.stype);		$('#vptax').html(x.ptax);
			$('#vstax').html(x.stax);			$('#vmrp').html(x.mrp);				$('#vprice').html(x.price);
			$('#vminqty').html(x.minqty);		$('#vmaxqty').html(x.maxqty);		$('#vshelf').html(x.shelf);			$('#vrack').html(x.rack); $('#vhsncode').html(x.hsncode);
			
			var clm = (x.claim_type == "CM") ? "Claimable" : ((x.claim_type == "NCM") ? "Non-Claimable" : "" )
			$('#vcliam_type').html(clm);

			var phar = (x.ptype == "P") ? "Pharma (P)" : ((x.ptype == "NP") ? "Non-Pharma (NP)" : "Others (O)")
			$('#vproducttype').html(phar);
			
			var sch = (x.schedule == "") ? "-" : "Scheduled("+x.schedule+")";
			$('#vschedule').html(sch);
		}
	});
	var modal = $('#modal-view');
	modal.modal('show');
});
$('table').on('click', 'a[id=disable]', function (e) {
	var txt = $(this).attr('data-val');
	var rid = $(this).closest("tr").index();
	if(confirm("Sure to disable Product?")){
		$.ajax({	
			url: 'manage-product/disable-product.php?id='+txt,
			type: 'POST',
			success:function(msg){
				var x = msg.split("~");
				if(x[0] != 'ok'){
					alert(msg);
					return false;
				}
				window.location.href="manage-product.php";
			}
		});
	}
});
$('table').on('click', 'a[id=enable]', function (e) {
	var txt = $(this).attr('data-val');
	var rid = $(this).closest("tr").index();
	if(confirm("Sure to enable Product?")){
		$.ajax({	
			url: 'manage-product/enable-product.php?id='+txt,
			type: 'POST',
			success:function(msg){
				var x = msg.split("~");
				if(x[0] != 'ok'){
					alert(msg);
					return false;
				}
				window.location.href="manage-product.php";
			}
		});
	}
});
$('table').on('click', 'a[id=delete]', function (e) {
	var txt = $(this).attr('data-val');
	var rid = $(this).closest("tr").index();
	if(confirm("Sure to delete Product?")){
		$.ajax({	
			url: 'manage-product/delete-product.php?id='+txt,
			type: 'POST',
			success:function(msg){
				if(msg != 'ok'){
					alert(msg);
					return false;
				}
				alert('Product Record Deleted !');
				window.location.href = 'manage-product.php';
			}
		});
	}
});

$(".number").blur(function(){
	var x = $(this);
	if(!$.isNumeric(x.val())){ x.css("border","2px dotted red"); x.val(''); x.focus(); return false; }
	else{ x.css("border","1px solid #d5d5d5"); }
});


