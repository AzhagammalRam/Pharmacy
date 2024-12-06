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
	var x = $('#adjtype').val();
	if(x == "SELECT"){ 
		$('#batch').replaceWith('<select class="form-control input-sm" name="batch" id="batch" onChange="retExpiry()"> <option>SELECT</option> </select>');
		$('#expiry').replaceWith('<select class="form-control input-sm" name="expiry" id="expiry" onChange="returnQty()"> <option>SELECT</option> </select>');
		$('#mr').replaceWith('<select class="form-control input-sm" name="mr" id="mr"> <option>SELECT</option> </select>');
		return false; 
	}
	else if(x == "Addition"){ 
		// $('#batch').replaceWith("<input type='text' class='form-control input-sm mand' name='batch' id='batch' />"); 
		// $('#expiry').replaceWith("<input type='text' class='form-control input-sm mand' name='expiry' id='expiry' placeholder='MM/YYYY' onBlur='validateExpiry()' />"); 
		// $('#mr').replaceWith("<input type='text' class='form-control input-sm mand' name='mr' id='mr' onBlur='validateMrp()' />"); 
		// return false; 
		$('#batch').replaceWith('<select class="form-control input-sm" name="batch" id="batch" onChange="retExpiry()"> <option>SELECT</option> </select>');
		$('#expiry').replaceWith('<input type="text" class="form-control input-sm" name="expiry" id="expiry" onBlur="validateExpiry()" />');
		$('#mr').replaceWith('<select class="form-control input-sm" name="mr" id="mr" onChange="returnQty()"> <option>SELECT</option> </select>');
	}else if(x == "Deletion")
	{ 
		$('#batch').replaceWith('<select class="form-control input-sm" name="batch" id="batch" onChange="retExpiry()"> <option>SELECT</option> </select>');
		$('#expiry').replaceWith('<input type="text" class="form-control input-sm" name="expiry" id="expiry" onBlur="validateExpiry()" />');
		$('#mr').replaceWith('<select class="form-control input-sm" name="mr" id="mr" onChange="returnQty()"> <option>SELECT</option> </select>');
	}
	
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
	// var x = $('#adjtype').val();
	// if(x == "Addition") return false;
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
			// var newdate = msg1.split("/").reverse().join("-");
			$('#expiry').val(xxy[0].expirydate);
			// $('#expiry').append(new Option("SELECT"));
			// for(var i=0;i<xxy.length;i++)
			// 	$('#expiry').append(new Option(xxy[i].expiry));
		}
	});
	
	
		var xxx = $('#adjtype').val();
	// if(xxx == "Addition") return false;
	var prod = $('#pname').val(), batch = $('#batch').val();
	if(batch == 'SELECT' || prod == '') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/return-mr.php?prod='+encodeURIComponent(prod)+"&batch="+batch,
		success: function(msg) {
			var xxxx = JSON.parse(msg);
			$('#mr').empty();
			$('#mr').append(new Option("SELECT"));
			for(var i=0;i<xxxx.length;i++)
				$('#mr').append(new Option(xxxx[i].mr));
		}
	});
}





function returnQty(){
	var x = $('#adjtype').val();
	// if(x == "Addition") return false;
	
	var prod = $('#pname').val(), batch = $('#batch').val(), expiry = $('#expiry').val();
	if(batch == 'SELECT' || prod == '' || expiry == 'SELECT') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/return-qty.php',
		data: {
			prod: encodeURIComponent(prod),
			batch: batch,
			qty: 999999,
			expiry: expiry,
		},
		success: function(msg) {
			var qty = msg.split(" : ");
			$('#avail').val($.trim(qty[1]));
		}
	});
}

function validateQty(){
	var x = $('#adjtype').val();
	if(x == "Addition") return false;
	var avail = $('#avail').val(), qty = $('#qty').val();
	if(parseFloat(avail) < parseFloat(qty)){
		alert('Qty must be lesser than Avail');
		$('#qty').val('');
	}
}

function validateExpiry(){
	// var x = $('#expiry').val();
	// if(x == ''){ $('#expiry').focus(); return false; }
	var xx = x.split("/");
	if(isNaN(xx[0])){ $('#expiry').val(''); $('#expiry').focus(); return false; }
	if(isNaN(xx[1])) { $('#expiry').val(''); $('#expiry').focus(); return false; }
	if(xx[0] > 12) { $('#expiry').val(''); $('#expiry').focus(); return false; }
	if(xx[1] < 2000 || xx[1] == 'undefined') { $('#expiry').val(''); $('#expiry').focus(); return false; }
	
}

function validateMrp()
{
	var mrp = $('#mr').val();
	if(mrp == ''){ $('#mr').focus(); return false; }
	if(isNaN(mrp)){ $('#mr').val(''); $('#mr').focus(); return false; }
}

function adjustItems(){
	var prod = $('#pname').val(), batch = $('#batch').val(), expiry = $('#expiry').val(),mr = $('#mr').val(),
		qty = $('#qty').val(),	adjtype = $('#adjtype').val(), reason = $('#reason').val();
	if(prod == '' || batch == '' || expiry == '' || qty == '' || adjtype == 'SELECT' || batch == 'SELECT' || expiry == 'SELECT' || mr == 'SELECT') return false;
	$.ajax({
		type: 'post',
		url: 'manage-stock/new-adjustment.php',
		data: $('#frmAdjustment').serialize(),
		success: function(msg) {
			alert(msg);
			window.location.href = 'stock-adjustment.php';
		}
	});
}