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

function createNewBill(){
	var pname = $('#patientname').val(), dname = $('#drname').val();
	if($.trim(pname) == '') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/dr_new-billing.php',
		data: {
			pname: pname,
			dname: dname,
		},
		success: function(msg) {
			if($.trim(msg) != '') alert(msg);
			window.location.href = 'dr_billing.php';
		}
   });
}
/* commented as not used*/
function deleteBill(x){
	if(confirm("Are you sure to delete Bill?")){
		$.ajax({
			type: 'post',
			url: 'manage-bill/dr-delete-billing.php?id='+x,
			success: function(msg) {
				alert(msg);
				window.location.href = 'dr_billing.php';
			}
	   });
	}
}
/*function editItem(img, x){
	var row = img.closest("tr");
	var table = $(row).closest('table').attr('id');
	var index = $(row).index();
	$('#dbval').val(x);
	$('#trval').val(table +'~'+ index);
	$.ajax({
		type: 'post',
		url: 'manage-bill/return-patient-billing-info.php?id='+x,
		success: function(msg) {
			var x = JSON.parse(msg);
			$('#xptype').val(x[0].type);	$('#xpname').val(x[1].desc);
			$('#xpbatch').empty(); $('#xpbatch').append(new Option('SELECT'));
			for(var i = 2; i<x.length; i++){
				$('#xpbatch').append(new Option(x[i].batch));
			}
		}
   });
	$('#patModal').modal('show');
}*/

function retX1Expiry(){
	var prod = $('#xpname').val(), batch = $('#xpbatch').val(), type = $('#xptype').val();
	if(batch == 'SELECT') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/return-expiry.php?prod='+encodeURIComponent(prod)+"&batch="+batch,
		success: function(msg) {
			var xx = JSON.parse(msg);
			$('#pexpiry').empty();
			$('#pexpiry').append(new Option("SELECT"));
			for(var i=0;i<xx.length;i++)
				$('#pexpiry').append(new Option(xx[i].expiry));
		}
	});
	
	if(batch == 'SELECT') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/return-aval.php?prod='+encodeURIComponent(prod)+"&batch="+batch,
		success: function(msg) {
			var xx = JSON.parse(msg);
			$('#paval').empty();
			$('#paval').append(new Option("SELECT"));
			for(var i=0;i<xx.length;i++)
				$('#paval').append(new Option(xx[i].aval));
		}
	});
	
}







function validateX1Qty(){
	var prod = $('#xpname').val(), batch = $('#xpbatch').val(), qty = $('#pqty').val(), expiry = $('#pexpiry').val();
	if(batch == 'SELECT' || prod == '' || qty == '' || qty == 0 || expiry == '') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/return-qty.php',
		data: {
			prod: encodeURIComponent(prod),
			batch: batch,
			qty: qty,
			expiry: expiry,
		},
		success: function(msg) {
			if($.trim(msg) != ''){
				alert(msg);
				$('#pqty').val('');
			}
		}
	});
}
function updatePItems(){
	var id = $('#dbval').val();
	var prod = $('#xpname').val(), batch = $('#xpbatch').val(), qty = $('#pqty').val(), expiry = $('#pexpiry').val(), type = $('#xptype').val();
	if(id == '' || batch == 'SELECT' || prod == '' || qty == '' || qty == 0 || expiry == '') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/update-med-info.php',
		data: $('#updForm').serialize(),
		success: function(msg) {
			var x = JSON.parse(msg);
			var t = $('#trval').val().split("~");
			$("#"+t[0]+" > tbody tr:eq("+t[1]+")").find("td").eq(5).text(x.batch);
			$("#"+t[0]+" > tbody tr:eq("+t[1]+")").find("td").eq(6).text(x.expi);
			$("#"+t[0]+" > tbody tr:eq("+t[1]+")").find("td").eq(7).text(x.qty);
			$("#"+t[0]+" > tbody tr:eq("+t[1]+")").find("td").eq(8).text(x.amt);
			var opt = "<img src='images/delete.png' style='height:24px; cursor:pointer;' onClick='javascript:deleteXItem(this,"+x.id+")'>";
			$("#"+t[0]+" > tbody tr:eq("+t[1]+")").find("td").eq(9).html(opt);
			$('#patModal').modal('hide');
			var amt = parseFloat($('#lblAmount'+x.bid).html()) + x.amt;
			$('#lblAmount'+x.bid).html(amt.toFixed(2));
			
			$('#xpname').val(''); $('#xpbatch').empty(); $('#pqty').val(''); $('#pexpiry').empty(); $('#xptype').val('SELECT'); $('#dbval').val('');
		}
	});
}
/* commented by vikram */
/*function deleteXItem(img, x){
	var row = img.closest("tr"); 
	if(confirm("Are you sure to delete?")){
		$.ajax({
			type: 'post',
			url: 'manage-bill/delete-pat-billed-item.php?id='+x,
			success: function(msg) {
				var xx = msg.split("~")
				alert(xx[0]);
				$('#lblAmount'+xx[2]).html((parseFloat($('#lblAmount'+xx[2]).html()) - parseFloat(xx[1])).toFixed(2));
				row.remove();
			}
	   });
	}
}
function deleteXBill(x){
	if(confirm("Are you sure to delete Bill?")){
		$.ajax({
			type: 'post',
			url: 'manage-bill/delete-pat-billing.php?id='+x,
			success: function(msg) {
				alert(msg);
				window.location.href = 'billing.php';
			}
	   });
	}
}*/
function addXBillingItems(x){
	var prod = $('#pname'+x).val(), qty = $('#qty'+x).val(), batch = $('#batch'+x).val(), expiry = $('#expiry'+x).val(), type = $('#ptype'+x).val();
	if(prod == '' || qty == '' || batch == 'SELECT' || expiry == '') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/dr_billing-items.php',
		data: {
			prod: encodeURIComponent(prod),
			batch: batch,
			qty: qty,
			expiry: expiry,
			bid: x,
		},
		success: function(msg) {
			var t = JSON.parse(msg);
			var tr = "<tr><td>"+t.code+"</td><td>"+t.desc+"</td><td>-</td><td>-</td><td>-</td><td>"+t.batch+"</td><td>"+t.expi+"</td><td>"+t.qty+"</td><td>"+t.amt+"</td><td><img src='images/delete.png' style='height:24px; cursor:pointer;' onClick='javascript:deleteXItem(this,"+t.code+")'></td></tr>";
			$('#tbl-list'+x+" > tbody").append(tr);
			$('#lblAmount'+x).html((parseFloat($('#lblAmount'+x).html()) + parseFloat(t.amt)).toFixed(2));
			$('#pname'+x).val(''); $('#qty'+x).val(''); $('#batch'+x).empty(); $('#expiry'+x).empty(); $('#batch'+x).append(new Option('SELECT')); $('#expiry'+x).append(new Option('SELECT')); $('#ptype'+x).val('SELECT')
		}
	});
}

/*Commented by vikram */
function deleteItem(img, x){
	var row = img.closest("tr"); 
	if(confirm("Are you sure to delete?")){
		$.ajax({
			type: 'post',
			url: 'manage-bill/delete-billed-item.php?id='+x,
			success: function(msg) {
				var xx = msg.split("~")
				alert(xx[0]);
				$('#lblAmount'+xx[2]).html((parseFloat($('#lblAmount'+xx[2]).html()) - parseFloat(xx[1])).toFixed(2));
				row.remove();
			}
	   });
	}
}

function dr_deleteItem(img, x){
	var row = img.closest("tr"); 
	if(confirm("Are you sure to delete?")){
		$.ajax({
			type: 'post',
			url: 'manage-bill/dr_delete_billed_item.php?id='+x,
			success: function(msg) {
				var xx = msg.split("~")
				alert(xx[0]);
				$('#lblAmount'+xx[2]).html((parseFloat($('#lblAmount'+xx[2]).html()) - parseFloat(xx[1])).toFixed(2));
				row.remove();
			}
	   });
	}
}

function retExpiry(x){
	var prod = $('#pname'+x).val(), batch = $('#batch'+x).val(), type = $('#ptype'+x).val();
	if(batch == 'SELECT') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/return-expiry.php?prod='+encodeURIComponent(prod)+"&batch="+batch,
		success: function(msg) {
				var xx = JSON.parse(msg);
				$('#expiry'+x).empty();
				//$('#expiry'+x).append(new Option("SELECT"));
				for(var i=0;i<xx.length;i++)
					$('#expiry'+x).append(new Option(xx[i].expiry));
		}
	});
		if(batch == 'SELECT') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/return-aval.php?prod='+encodeURIComponent(prod)+"&batch="+batch,
		success: function(msg) {
				var xx = JSON.parse(msg);
				$('#aval'+x).empty();
				//$('#expiry'+x).append(new Option("SELECT"));
				for(var i=0;i<xx.length;i++)
					$('#aval'+x).append(new Option(xx[i].aval));
		}
	});
}
function retBatchNo(x){
	var prod = $('#pname'+x).val(), type = $('#ptype'+x).val();
	if($.trim(prod) == '') return false;
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
				$('#batch'+x).empty();
				$('#batch'+x).append(new Option("SELECT"));
				for(var i=0;i<xx.length;i++)
					$('#batch'+x).append(new Option(xx[i].batch));
			}
		}
	});
}
function validateQty(x){
	var prod = $('#pname'+x).val(), batch = $('#batch'+x).val(), qty = $('#qty'+x).val(), expiry = $('#expiry'+x).val(), type = $('#ptype'+x).val();
	if(batch == 'SELECT' || prod == '' || qty == '' || qty == 0 || expiry == '') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/dr_return-qty.php',
		data: {
			prod: encodeURIComponent(prod),
			batch: batch,
			qty: qty,
			expiry: expiry,
		},
		success: function(msg) {
			if($.trim(msg) != ''){
				alert(msg);
				$('#qty'+x).val('');
			}
		}
	});
}
function addBilling_Items(x){
	var prod = $('#pname'+x).val(), qty = $('#qty'+x).val(), batch = $('#batch'+x).val(), expiry = $('#expiry'+x).val(), type = $('#ptype'+x).val();
	//if(prod == '' || qty == '' || batch == 'SELECT' || expiry == '') 
	if(prod == ''){ $('#pname'+x).css('border-color','red'); return false; }
	if(qty == ''){ $('#qty'+x).css('border-color','red'); return false; }
	if(batch == 'SELECT'){ $('#batch'+x).css('border-color','red'); return false; }
	if(expiry == ''){ $('#expiry'+x).css('border-color','red'); return false; }
	
	
	
	$.ajax({
		type: 'post',
		url: 'manage-bill/dr_getaval.php',
		data: {
			prod: encodeURIComponent(prod),
			batch: batch,
			qty: qty,
			expiry: expiry,
			bid: x,
		},
		success: function(msg) {
			alert("Current Available Quantity "+msg);
		}
	});
	
	
	$.ajax({
		type: 'post',
		url: 'manage-bill/dr_billing-items.php',
		data: {
			prod: encodeURIComponent(prod),
			batch: batch,
			qty: qty,
			expiry: expiry,
			bid: x,
		},
		success: function(msg) {
			var t = JSON.parse(msg);
			var tr = "<tr><td>"+t.code+"</td><td>"+t.desc+"</td><td>"+t.qty+"</td><td>"+t.batch+"</td><td>"+t.expi+"</td><td>"+parseFloat(t.vatval).toFixed(2)+"</td><td>"+parseFloat(t.amt).toFixed(2)+"</td><td><img src='images/delete.png' style='height:24px; cursor:pointer;' onClick='javascript:dr_deleteItem(this,"+t.id+")'></td></tr>";
			$('#tbl-list'+x+" > tbody").append(tr);
			$('#lblAmount'+x).html((parseFloat($('#lblAmount'+x).html()) + parseFloat(t.amt)).toFixed(2));
			$('#pname'+x).val(''); $('#qty'+x).val(''); $('#batch'+x).empty(); $('#expiry'+x).empty(); $('#batch'+x).append(new Option('SELECT')); $('#expiry'+x).append(new Option('SELECT')); $('#ptype'+x).val('SELECT')
			
		}
	});
	
//	getdiscount(x);   ----------commented on 20th Nov
		
}

function getdiscount(y) {
	var discount=$("#discount"+y).val();
	if(discount=="")
	return false;
	//var tot=$("#lblAmount"+y).text();
	//var disper=discount/100;
	
	
	//tot=parseFloat(tot);
	//var disamt=disper*tot;
	//disamt=parseFloat(disamt).toFixed(2);
	//alert(disamt);
	$.ajax({
		type: 'post',
		url: 'manage-bill/calcdiscount.php',
		data: {
			dis: discount,
			bid: y,
		},
		success: function(msg) {
			
			mas=$.trim(msg);
			msg=parseFloat(msg).toFixed(2);
			//alert(msg);
			$("#lblAmount"+y).text(msg);
		}
	});

}






function closemodal(x) {
			$('#modal-view'+x).modal('toggle');
			$('#tbl-list'+x+" > tbody").empty();
			}

$('.modal.direct-bill').on('show.bs.modal', function (event) { 
	var button = $(event.relatedTarget);
	var id = button.data('whatever');
	$.ajax({
		type: 'post',
		// url: 'manage-bill/return-dr-billing-items.php?id='+id,
		success: function(msg) {
			var t = JSON.parse(msg);
			for(var i=1;i<t.length-1;i++){
				var tr = "<tr><td>"+t[i].code+"</td><td>"+t[i].desc+"</td><td>"+t[i].qty+"</td><td>"+t[i].batch+"</td><td>"+t[i].expi+"</td><td>"+t[i].vatval+"</td><td>"+t[i].amt+"</td><td><img src='images/delete.png' style='height:24px; cursor:pointer;' onClick='javascript:dr_deleteItem(this,"+t[i].id+")'></td></tr>";
			$('#tbl-list'+id+" > tbody").append(tr);
			}
			$('#lblAmount'+id).html(t[i].tot);
		}
	});
});
$('.modal.patient-bill').on('show.bs.modal', function (event) { 
	var button = $(event.relatedTarget);
	var id = button.data('whatever');
	$('#tbl-list'+id+" > tfoot > tr").empty();
	$('#tbl-list'+id+" > tbody > tr").empty();
	$.ajax({
		type: 'post',
		url: 'manage-bill/return-patient-billing-items.php?id='+id,
		success: function(msg) {
			var t = JSON.parse(msg);
			for(var i=0;i<t.length-1;i++){
				if(t[i].code == '-'){
					var tr = "<tr style='background-color: rgba(255, 0, 0, 0.15);'><td>"+t[i].code+"</td><td>"+t[i].desc+"</td><td>"+t[i].freq+"</td><td>"+t[i].dur+"</td><td>"+t[i].spec+"</td><td>"+t[i].batch+"</td><td>"+t[i].expi+"</td><td>"+t[i].qty+"</td><td>"+t[i].amt+"</td><td>-</td></tr>";
					$('#tbl-list'+id+" > tfoot").append(tr);
				}else{
					if(t[i].qty == 0)
						var tr = "<tr><td>"+t[i].code+"</td><td>"+t[i].desc+"</td><td>"+t[i].freq+"</td><td>"+t[i].dur+"</td><td>"+t[i].spec+"</td><td>"+t[i].batch+"</td><td>"+t[i].expi+"</td><td>"+t[i].qty+"</td><td>"+t[i].amt+"</td><td><img src='images/edit.png' style='height:24px; cursor:pointer;' onClick='javascript:editItem(this,"+t[i].id+")'>   <img src='images/delete.png' style='height:24px; cursor:pointer;' onClick='javascript:deleteXItem(this,"+t[i].id+")'></td></tr>";
					else
						var tr = "<tr><td>"+t[i].code+"</td><td>"+t[i].desc+"</td><td>"+t[i].freq+"</td><td>"+t[i].dur+"</td><td>"+t[i].spec+"</td><td>"+t[i].batch+"</td><td>"+t[i].expi+"</td><td>"+t[i].qty+"</td><td>"+t[i].amt+"</td><td><img src='images/delete.png' style='height:24px; cursor:pointer;' onClick='javascript:deleteXItem(this,"+t[i].id+")'></td></tr>";
					$('#tbl-list'+id+" > tbody").append(tr);
				}
			}
			$('#lblAmount'+id).html(t[i].tot);
		}
	});
});

function closeBill(x,p){
	var pm = $('#paymentmode'+x).val();
	var dis = $('#discount'+x).val();
	var remind=$('#reminder'+x).val();
	if(dis=="")
	dis=0;
	var id = x;
	if(pm == 'SELECT'){ $('#paymentmode'+x).css('border-color','red'); return false; }
	//if(remind == ''){ $('#reminder'+x).css('border-color','red'); return false; }
	$.ajax({
		type: 'post',
		url: 'manage-bill/dr_close-bill.php',
		data: {
			pm: pm,
			id: id,
			dis:dis,
			remind:remind,
		},
		
		success: function(msg) {
			
			if($.isNumeric(msg)){
				if(p == '1')
					var win = window.open("dr_printbill.php?billno="+msg);
				//window.location.href = 'dr_billing.php'; --------------commented for want to display the screen
			}else
				alert("ERROR : "+msg);
		}
	});
}