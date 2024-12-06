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

function quickBilling(x){
	if(x==1){
	$('#mdlNewQuickBill').modal('show');
	}
	if(x==2)
	{
	$('#mdlNewQuickBillIp').modal('show');
	}	
}

function createNewBill(){
	
	var pname = $('#qbpatientname').val(), dname = $('#qbdrname').val();
	var phno = $('#qbcontactnumber').val();
	
	if($.trim(pname) == '') return false;
	
	if(dname==0 && $('#qbdrname1').val()=="")
	dname="Not available";
	else if(dname==0 && $('#qbdrname1').val()!="")
	dname=$('#qbdrname1').val();
	else
	 dname = $('#qbdrname').val();
	$.ajax({
		type: 'post',
		url: 'manage-bill/dr_new-billing.php',
		data: {
			pname: pname,
			dname: dname,
			phno: phno,
		},
		success: function(msg) {
			//alert(msg)   -- to check the value passed
			if($.trim(msg) != '') {
			msg=msg.split("+");
			}
			if(msg[0] !="")
			alert(msg);
			else
			window.location.href = 'dr_billing.php?id='+msg[1];
		}
   });
}

function getdetails(x) {
	var phno=x.val();
//alert(phno);
$.ajax({
			type: 'post',
			url: 'manage-bill/dr_getpatient.php?phno='+phno,
			success: function(msg) {
				//alert(msg);
				var x = JSON.parse(msg);
				$('#qbpatientname').val(x[0].patientname);
				//window.location.href = 'billing.php';
			}
	   });
}
/*function deleteBill(x){   --------------commented out on 19th nov
	if(confirm("Are you sure to delete Bill?")){
		$.ajax({
			type: 'post',
			url: 'manage-bill/delete-billing.php?id='+x,
			success: function(msg) {
				alert(msg);
				window.location.href = 'billing.php';
			}
	   });
	}
}
function editItem(img, x){
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
}----------------commented out on 19th nov*/

function retX1Expiry(x){
	var prod = $('#xpname').val(), batch = $('#xpbatch').val(), type = $('#xptype').val();
	if(batch == 'SELECT') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/return-expiry.php?prod='+encodeURIComponent(prod)+"&batch="+batch+"&type="+type,
		success: function(msg) {
			var xx = JSON.parse(msg);
			$('#expiry'+x).empty();
				$('#expiry'+x).val(msg);
			// $('#pexpiry').append(new Option("SELECT"));
			// for(var i=0;i<xx.length;i++)
			// 	$('#pexpiry').append(new Option(xx[i].expiry));
	}
	});
	
	if(batch == 'SELECT') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/dr_return-aval.php?prod='+encodeURIComponent(prod)+"&batch="+batch,
		success: function(msg) {
			var xx = JSON.parse(msg);
			$('#paval').empty();
			$('#paval').append(new Option("SELECT"));
			for(var i=0;i<xx.length;i++)
				$('#paval').append(new Option(xx[i].expiry));
		}
	});
	
	
	
}
function validateX1Qty(){
	var prod = $('#xpname').val(), batch = $('#xpbatch').val(), qty = $('#pqty').val(), expiry = $('#pexpiry').val(), type = $('#xptype').val();
	if(batch == 'SELECT' || prod == '' || qty == '' || qty == 0 || expiry == '') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/dr_return-qty.php',
		data: {
			type: type,
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
		url: 'manage-bill/dr_update-med-info.php',
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
/*function deleteXItem(img, x){   -----------commented on 19th nov
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
}  ------------------ commented out on 19th Nov */
function addXBillingItems(x){
	var prod = $('#pname'+x).val(), qty = $('#qty'+x).val(), batch = $('#batch'+x).val(), expiry = $('#expiry'+x).val(), type = $('#ptype'+x).val();
	if(prod == '' || qty == '' || batch == 'SELECT' || expiry == '') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/dr_billing-items.php',
		data: {
			type: type,
			prod: encodeURIComponent(prod),
			batch: batch,
			qty: qty,
			expiry: expiry,
			bid: x,
		},
		success: function(msg) {
			var t = JSON.parse(msg);
			var tr = "<tr><td>"+t.code+"</td><td>"+t.desc+"</td><td>-</td><td>-</td><td>-</td><td>"+t.batch+"</td><td>"+t.expi+"</td><td>"+t.qty+"</td><td>"+t.amt+"</td><td><img src='images/delete.png' style='height:24px; cursor:pointer;' onClick='javascript:deleteXItem(this,"+t.id+")'></td></tr>";
			$('#tbl-list'+x+" > tbody").append(tr);
			$('#lblAmount'+x).html((parseFloat($('#lblAmount'+x).html()) + parseFloat(t.amt)).toFixed(2));
			$('#pname'+x).val(''); $('#qty'+x).val(''); $('#batch'+x).empty(); $('#expiry'+x).empty(); $('#batch'+x).append(new Option('SELECT')); $('#expiry'+x).append(new Option('SELECT')); $('#ptype'+x).val('SELECT')
		}
	});
}
/*----------------- commented on 19th nov
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
-------------------- commented out */
function retExpiry(x){
	var prod = $('#pname'+x).val(), batch = $('#batch'+x).val(), type = $('#ptype'+x).val();
	if(batch == 'SELECT') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/dr_return-expiry.php?prod='+encodeURIComponent(prod)+"&batch="+batch+"&type="+type,
		success: function(msg) {
				//var xx = JSON.parse(msg);
				$('#expiry'+x).empty();
				$('#expiry'+x).val(msg);
				// $('#expiry'+x).append(new Option("SELECT"));
				// for(var i=0;i<xx.length;i++)
				// 	$('#expiry'+x).append(new Option(xx[i].expiry));
		}
	});
	$.ajax({
		type: 'post',
		url: 'manage-bill/return-aval.php?prod='+encodeURIComponent(prod)+"&batch="+batch+"&type="+type,
		success: function(msg) {
				var xx = JSON.parse(msg);
				$('#aval'+x).empty();
				$('#aval'+x).append(new Option("SELECT"));
				for(var i=0;i<xx.length;i++)
					$('#aval'+x).append(new Option(xx[i].aval));
		}
	});
}

function returnExpiry(x){
	var prod = $('#xpname').val(), batch = $('#xpbatch').val(), type = $('#xptype').val();
	if(batch == 'SELECT') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/return-expiry.php?prod='+encodeURIComponent(prod)+"&batch="+batch+"&type="+type,
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
		url: 'manage-bill/avail-qty.php?prod='+encodeURIComponent(prod)+"&batch="+batch,
		success: function(msg) {
			var xx = JSON.parse(msg);
			$('#paval').empty();
			$('#paval').append(new Option("SELECT"));
			for(var i=0;i<xx.length;i++)
				$('#paval').append(new Option(xx[i].expiry));
		}
	});
		
}
function retBatchNo(x){
	var prod = $('#pname'+x).val(), type = $('#ptype'+x).val();
	if($.trim(prod) == '') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/dreturn-batchno.php?prod='+encodeURIComponent(prod)+"&type="+type,
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
			type: type,
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
function addBillingItems(x){
	var prod = $('#pname'+x).val(), qty = $('#qty'+x).val(), batch = $('#batch'+x).val(), expiry = $('#expiry'+x).val(), type = $('#ptype'+x).val();
	if(prod == '' || qty == '' || batch == 'SELECT' || expiry == '') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/dr_billing-items.php',
		data: {
			type: type,
			prod: encodeURIComponent(prod),
			batch: batch,
			qty: qty,
			expiry: expiry,
			bid: x,
		},
		success: function(msg) {
			var t = JSON.parse(msg);
			var tr = "<tr><td style='text-align:center'>"+t.code+"</td><td style='text-align:center'>"+t.type+"</td><td style='text-align:center'>"+t.desc+"</td><td style='text-align:center'>"+t.qty+"</td><td style='text-align:center'>"+t.batch+"</td><td style='text-align:center'>"+t.expi+"</td><td style='text-align:center'>"+t.vatval+"</td><td style='text-align:center'>"+t.amt+"</td><td style='text-align:center'><img src='images/delete.png' style='height:24px; cursor:pointer;' onClick='javascript:dr_deleteItem(this,"+t.id+")'></td></tr>";
			$('#tbl-list'+x+" > tbody").append(tr);
			$('#lblAmount'+x).html((parseFloat($('#lblAmount'+x).html()) + parseFloat(t.amt)).toFixed(2));
			$('#pname'+x).val(''); $('#qty'+x).val(''); $('#batch'+x).empty(); $('#expiry'+x).empty(); $('#batch'+x).append(new Option('SELECT')); $('#expiry'+x).append(new Option('SELECT')); $('#ptype'+x).val('SELECT')
		}
	});
}

$('.modal.direct-bill').on('show.bs.modal', function (event) { 
	var button = $(event.relatedTarget);
	var id = button.data('whatever');
	$.ajax({
		type: 'post',
		url: 'manage-bill/return-dr-billing-items.php?id='+id,
		success: function(msg) {
			var t = JSON.parse(msg);
			for(var i=0;i<t.length-1;i++){
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
		url: 'manage-bill/dr_return-patient-billing-items.php?id='+id,
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
	var id = x;
	var amountde = $('#lblAmount'+x).html();
	if(amountde==0.00)
	{
		alert("please enter the drug");
		return false;
	}
	
	if(pm == 'SELECT'){ $('#paymentmode'+x).css('border-color','red'); return false; }
	$.ajax({
		type: 'post',
		url: 'manage-bill/dr_close-bill.php',
		data: {
			pm: pm,
			id: id,
		},
		success: function(msg) {
			if($.isNumeric(msg)){
				if(p == '1')
					var win = window.open("dr_printbill.php?billno="+msg);
				window.location.reload();
			}else
				alert("ERROR : "+msg);
		}
	});
}