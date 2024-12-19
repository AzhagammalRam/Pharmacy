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

function deleteItem(img, x){
	var row = img.closest("tr"); 
	if(confirm("Are you sure to delete?")){
		$.ajax({
			type: 'post',
			url: 'manage-bill/edit-delete-billed-item.php?id='+x,
			success: function(msg) {
				var xx = msg.split("~")
				alert(xx[0]);
				$('#lblAmount').html((parseFloat($('#lblAmount').html()) - parseFloat(xx[1])).toFixed(2));
				row.remove();
			}
	   });
	}
}

function retExpirysalre(){
	var prod = $('#pname').val(), batch = $('#batch').val();
	if(batch == 'SELECT') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/return-expiry.php?prod='+encodeURIComponent(prod)+"&batch="+batch,
		success: function(msg) {

		var xx = JSON.parse(msg);
		// alert(JSON.stringify(xx[0].expirydate));
			$('#expirye').val(xx[0].expirydate);
			
		}
	});
}

function retBatchNosalre(){
	
	var prod = $('#pname').val();
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
				$('#batch').empty();
				$('#batch').append(new Option("SELECT"));
				for(var i=0;i<xx.length;i++)
					$('#batch').append(new Option(xx[i].batch));
			}
		}
	});
}

function validateQtysalre(){
	var prod = $('#pname').val(), batch = $('#batch').val(), qty = $('#qty').val(), expiry = $('#expirye').val();
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
				$('#qty').val('');
			}
		}
	});
}

function addBillingItemssalre(){
	var prod = $('#pname').val(), qty = $('#qty').val(), batch = $('#batch').val(), expiry = $('#expirye').val();
	if(prod == '' || qty == '' || batch == 'SELECT' || expiry == '') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/edit-billing-items.php',
		data: {
			prod: encodeURIComponent(prod),
			batch: batch,
			qty: qty,
			expiry: expiry,
			billno: $('#billno').val(),
		},
		success: function(msg) {
			var t = JSON.parse(msg);
			var tr = "<tr><td>"+t.code+"</td><td>"+t.desc+"</td><td>"+t.qty+"</td><td>"+t.batch+"</td><td>"+t.expi+"</td><td>"+t.amt+"</td><td><img src='images/delete.png' style='height:24px; cursor:pointer;' onClick='javascript:deleteItem(this,"+t.id+")'></td></tr>";
			$('#tbl-list > tbody').append(tr);
			$('#lblAmount').html((parseFloat($('#lblAmount').html()) + parseFloat(t.amt)).toFixed(2));
			$('#pname').val(''); $('#qty').val(''); $('#batch').empty(); $('#expiry').empty(); $('#batch').append(new Option('SELECT')); $('#expiry').append(new Option('SELECT'));
		}
	});
}
function editcloseBillsalre(x){
	var tbody = $("#tbl-list tbody");
		if (tbody.children().length == 0) {
			alert('Table should not blank');
			return false;
		}
	if(x == '2'){
		$('.save').removeAttr('disabled');
	}
}

function closeBillsalre(p){
	var pm = $('#paymentmode').val();
	if(pm == 'SELECT') return false;
	
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
        
    });
	
	$.ajax({
		type: 'post',
		url: 'manage-bill/edit-close-bill.php',
		data: {
			pm: pm,assets: asset,
			billno: $('#billno').val(),
			discount:null,
		},
		success: function(msg) {console.log(msg);
			
			if(msg=='1')
			{
				alert("Payment Mode successfully changed");
				window.location.href = 'sales-return.php';
			}else{
		
			var msg=$.trim(msg);
			var x=msg.split("~");
			// alert(x[1]);
			var bill = x[0];
			var ip_id =x[1];
			var sale_ret =x[2];
			if($.isNumeric(sale_ret)){
				if(p == '1')
			var win = window.open("printbill.php?billno="+bill+'&type=2'+'&payment='+ip_id+'&sale_ret='+sale_ret);
				window.location.href = 'sales-return.php';
			}else
				alert("ERROR : "+msg);
        }
		}
	});
}

function getBillData(){
	var billno = $.trim($('#billno1').val());
	$.ajax({
		type: 'post',
		url: 'manage-bill/getBillData.php',
		data: {
			opt: billno,
		},
		success: function(msg) {
			
			if(msg != 'error')
			{
				var t1 = JSON.parse(msg);
				var t = t1.res_arr;

				for(var i=0;i<t.length;i++){
					var tr = "<tr><td>"+(i+1)+"</td><td>"+t[i].billno+"</td><td>"+t[i].patientname+"</td><td>"+t[i].phno+"</td><td>"+t[i].drname+"</td><td>"+t[i].totalamt+"</td><td>"+t[i].balanceamt+"</td><td><img src='images/edit.png' style='height:24px; cursor:pointer;' onClick='javascript:getBill("+t[i].billno+")'></td></tr>";
					$('#billingtbl-list > tbody').append(tr);
				}
				
				$('#modalviewBillList').modal('toggle');
				// alert(msg);
			} else {
				alert("ERROR : "+msg);
        }
		}
	});
}

function getBill(billno){
	// var billno = $.trim($('#billno').val());
	if(billno == '') return false;
	window.location.href = 'sales-return.php?billno='+billno;
}
