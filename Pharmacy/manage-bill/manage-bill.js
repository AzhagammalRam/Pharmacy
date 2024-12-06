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
		url: 'manage-bill/new-billing.php',
		data: {
			pname: pname,
			dname: dname,
		},
		success: function(msg) {
			if($.trim(msg) != '') alert(msg);
			window.location.href = 'billing.php';
		}
   });
}
function createNewBill1(){
	var pname = $('#patientname').val(), dname = $('#drname').val();
	phno="";bill="";
	if($.trim(pname) == '') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/new-billing.php',
		data: {
			pname: pname,
			dname: dname,
			phno: phno,
			bill:bill,
		},
		success: function(msg) {
			if($.trim(msg) != '')
			window.location.href = 'billing.php';
		}
   });
}

function deleteBill1(x){
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
}

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
function deleteXItem(img, x){
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
}
function addXBillingItems(x){
	var prod = $('#pname'+x).val(), qty = $('#qty'+x).val(), batch = $('#batch'+x).val(), expiry = $('#expiry'+x).val(), type = $('#ptype'+x).val();
	if(prod == '' || qty == '' || batch == 'SELECT' || expiry == '') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/billing-items.php',
		data: {
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

function deleteItem(img, x){
	var row = img.closest("tr");
if(confirm("Are you sure to delete?")){
		$.ajax({
			type: 'post',
			url: 'manage-bill/delete-billed-item.php?id='+x,
			success: function(msg) {
				var xx = msg.split("~")
				// alert(xx[0]);
				var insur = $('#insur'+xx[2]).val(); 
				if(insur == '1')
			{
				$('#lblAmount'+xx[2]).html((parseFloat($('#lblAmount'+xx[2]).html()) - parseFloat(xx[1])).toFixed(2));
			}else if(insur != '1')
			{
				$('#lblAmount'+xx[2]).html((parseFloat(xx[3])).toFixed(2));	
				$('#lblAmount_ncm'+xx[2]).html(( parseFloat(xx[4])).toFixed(2));
			}
				
				row.remove();
			}
	   });
	}
}
//function retExpiry(x){
//	var prod = $('#pname'+x).val(), batch = $('#batch'+x).val(), type = $('#ptype'+x).val();
//	if(batch == 'SELECT') return false;
//	$.ajax({
//		type: 'post',
//		url: 'manage-bill/return-expiry.php?prod='+encodeURIComponent(prod)+"&batch="+batch,
//		success: function(msg) {
//				var xx = JSON.parse(msg);
//				$('#expiry'+x).empty();
//				//$('#expiry'+x).append(new Option("SELECT"));
//				for(var i=0;i<xx.length;i++)
//					$('#expiry'+x).append(new Option(xx[i].expiry));
//		}
//	});
//		if(batch == 'SELECT') return false;
//	$.ajax({
//		type: 'post',
//		url: 'manage-bill/return-aval.php?prod='+encodeURIComponent(prod)+"&batch="+batch,
//		success: function(msg) {
//				var xx = JSON.parse(msg);
//				$('#aval'+x).empty();
//				//$('#expiry'+x).append(new Option("SELECT"));
//				for(var i=0;i<xx.length;i++)
//					$('#aval'+x).append(new Option(xx[i].aval));
//		}
//	});
//}
function qbreturnExpiry(x){
	
	var prod = $('#pname'+x).val(), batch = $('#batch'+x).val(), type = $('#ptype'+x).val();
	if(batch == 'SELECT') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/return-expiry.php?prod='+encodeURIComponent(prod)+"&batch="+batch+"&type="+type,
		success: function(msg) {
      
			var xx = JSON.parse(msg);
			// alert(JSON.stringify(xx))
			$('#expiry'+x).empty();
            $('#expiry'+x).val(xx[0].expirydate); 
            $('#expiryval'+x).empty();
            $('#expiryval'+x).val(xx[0].expval);
            $('#suplr'+x).empty();
			for(var i=0;i<xx.length;i++)
					$('#suplr'+x).append(new Option(xx[i].sup_nm,xx[i].sup_id));
			//$('#expiry').append(new Option("SELECT"));
			//for(var i=0;i<xx.length;i++)
				//$('#expiry').append(new Option(xx[i].expiry));
	}
	});
		if(batch == 'SELECT') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/avail-qty.php?prod='+encodeURIComponent(prod)+"&batch="+batch,
		success: function(msg) {
			
			var xx = JSON.parse(msg);
			$('#aval'+x).empty();
			$('#aval'+x).val(msg);
			//for(var i=0;i<xx.length;i++)
				//$('#aval').append(new Option(msg));
			
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
	$.ajax({
		type: 'post',
		url: 'manage-bill/return-supplier.php?prod='+encodeURIComponent(prod)+"&type="+type,
		success: function(msg) {
			if($.trim(msg) == ''){
				alert('No Product Found !');	$('#pname'+x).val('');
			}else if($.trim(msg) == 'error1'){
				alert('Invalid Product !');		$('#pname'+x).val('');
			}else{
				var xx = JSON.parse(msg);
				$('#suplr'+x).empty();
				$('#suplr'+x).append(new Option("SELECT"));
				for(var i=0;i<xx.length;i++)
					$('#suplr'+x).append(new Option(xx[i].sup_nm,xx[i].sup_id));
			}
		}
	});
}
function validateQty(x){
	var prod = $('#pname'+x).val(), batch = $('#batch'+x).val(), qty = $('#qty'+x).val(), expiry = $('#expiry'+x).val(), type = $('#ptype'+x).val();
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
				$('#qty'+x).val('');
			}
		}
	});
}
function addBillingItems(x){
	
	var prod = $('#pname'+x).val(), qty = $('#qty'+x).val(), batch = $('#batch'+x).val(), expiry = $('#expiry'+x).val(), type = $('#ptype'+x).val();
	var dte=$('#invoicedate'+x).val();
	//if(prod == '' || qty == '' || batch == 'SELECT' || expiry == '') 
	if(prod == ''){ $('#pname'+x).css('border-color','red'); return false; }
	if(qty == ''){ $('#qty'+x).css('border-color','red'); return false; }
	if(batch == 'SELECT'){ $('#batch'+x).css('border-color','red'); return false; }
	if(expiry == ''){ $('#expiry'+x).css('border-color','red'); return false; }
	
	if(dte == ''){ $('#invoicedate'+x).css('border-color','red'); return false;}
	var insur = $('#insur'+x).val();
	
	$.ajax({
		type: 'post',
		url: 'manage-bill/billing-items.php',
		data: {
			prod: encodeURIComponent(prod),
			batch: batch,
			qty: qty,
			expiry: expiry,
			bid: x,
			dtee:dte
		},
		success: function(msg) {
			var t = JSON.parse(msg);
			
			var tr = "<tr><td>"+t.code+"</td><td>"+t.desc+"</td><td>"+t.qty+"</td><td>"+t.batch+"</td><td>"+t.expi+"</td><td>"+t.de+"</td><td>"+parseFloat(t.vatval).toFixed(2)+"</td><td>"+t.tax_percentage+"</td><td>"+parseFloat(t.amt).toFixed(2)+"</td><td><img src='images/delete.png' style='height:24px; cursor:pointer;' onClick='javascript:deleteItem(this,"+t.id+")'></td></tr>";
			$('#tbl-lists'+x+" > tbody").append(tr);
			var ttl=t.amt; 
			var amnt = ttl.replace(/\,/g,'');
			if(insur == '1')
			{
				$('#lblAmount'+x).html((parseFloat($('#lblAmount'+x).html()) + parseFloat(amnt)).toFixed(2));
			}else if(insur != '1')
			{
			var ttl1=t.cm_amt; 
			var cm_amt = ttl1.replace(/\,/g,'');
			var ttl2=t.ncm_amt; 
			var ncm_amt = ttl2.replace(/\,/g,'');
				$('#lblAmount'+x).html((parseFloat(cm_amt)).toFixed(2));	
				$('#lblAmount_ncm'+x).html(( parseFloat(ncm_amt)).toFixed(2));	
			}
			$('#pname'+x).val(''); $('#qty'+x).val(''); $('#batch'+x).empty(); $('#expiry'+x).empty(); $('#batch'+x).append(new Option('SELECT')); $('#expiry'+x).append(new Option('SELECT')); $('#ptype'+x).val('SELECT');$('#invoicedate'+x).val('');
			
		}
	});
	
	getdiscount(x);
		
}

function getdiscount(y) {
	var discount=$("#discount"+y).val();
	var userrole=$("#userrole").val();
	var insur = $('#insur'+y).val();
	if(discount=="")
	{
		discount=0;
	}
	if(discount < 0 ||discount > 100 || isNaN(discount) )
	{
	$("#discount"+y).css('border-color','red');
	$("#discount"+y).focus();
	return false;
	}else{
		$("#discount"+y).css('border-color','#858585');
	}
var disc = parseInt(discount);
if(userrole != 1 && disc > 10){
alert("Please enter discount below 10%");
return false;
}
	$.ajax({
		type: 'post',
		url: 'manage-bill/calcdiscount.php',
		data: {
			dis: discount,
			bid: y,
		},
		success: function(msg) {
			
			msg=$.trim(msg);
			var x=msg.split("~");
			var ttl=parseFloat(x[0]).toFixed(2);
			var dcs=parseFloat(x[1]).toFixed(2);

			if(insur == '1')
			{
			$("#lblAmount"+y).text(ttl);
			$("#discountamount"+y).text(dcs);
			}else if(insur != '1')
			{
				$("#lblAmount_ncm"+y).text(parseFloat(x[2]).toFixed(2));
				$("#discountamountncm"+y).text(parseFloat(x[3]).toFixed(2));
				$("#lblAmount"+y).text(parseFloat(x[4]).toFixed(2));
				$("#discountamount"+y).text(parseFloat(x[5]).toFixed(2));
			}
		}
	});

}






function closemodal(x) {
			$('#modal-view'+x).modal('toggle');
			$('#tbl-lists'+x+" > tbody").empty();
			}

$('.modal.direct-bill').on('show.bs.modal', function (event) { 
	var button = $(event.relatedTarget);
	var id = button.data('whatever');
	$('#tbl-lists'+id+" > tbody > tr").empty();
	$.ajax({
		type: 'post',
		url: 'manage-bill/return-billing-items.php?id='+id,
		success: function(msg) {
			var t = JSON.parse(msg);
			for(var i=1;i<t.length-1;i++){
				var tr = "<tr><td>"+t[i].code+"</td><td>"+t[i].type+"</td><td>"+t[i].desc+"</td><td>"+t[i].qty+"</td><td>"+t[i].batch+"</td><td>"+t[i].expi+"</td><td>"+t[i].tp+"</td><td>"+t[i].amt+"</td><td><img src='images/delete.png' style='height:24px; cursor:pointer;' onClick='javascript:deleteItem(this,"+t[i].id+")'></td></tr>";
			// $('#tbl-lists'+id+" > tbody").append(tr);
			// window.location.reload(true);
			$('#lblAmount'+id).html(t[i].tot);
			}
			
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
	var insur = $('#insur'+x).val();
	if(pm == 'SELECT'){ $('#paymentmode'+x).css('border-color','red'); return false; }
	//if(remind == ''){ $('#reminder'+x).css('border-color','red'); return false; }
	$.ajax({
		type: 'post',
		url: 'manage-bill/close-bill1.php',
		data: {
			pm: pm,
			id: id,
			dis:dis,
			remind:remind,
		},
		success: function(msg) {
			if($.isNumeric(msg)){
				if(p == '1')
					var win = window.open("printbill.php?billno="+msg);
				window.location.href = 'billing.php';
			}else
				alert("ERROR : "+msg);
		}
	});
}