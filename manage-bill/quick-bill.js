// JavaScript Document
var batch_ids=[];
var exp_dt=[];
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

shortcut.add("Shift+1",function() {
	// alert("x");
	quickBilling(1);
});
shortcut.add("Shift+2",function() {
	// alert("x");
	quickBilling(2);
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
$(function() {
    $('input,select').on('keypress', function(e) {
        e.which !== 13 || $('[tabIndex=' + (+this.tabIndex + 1) + ']')[0].focus();
    });
});  


$(function() {
    $('.input-sm').on('keypress', function(e) {
        e.which !== 13 || $('[tabIndex=' + (+this.tabIndex + 1) + ']').focus();
    });
})
function createNewBill(){
	
	var pname = $('#qbpatientname').val(), dname = $('#qbdrname').val();
	var phno = $('#qbcontactnumber').val();
	var bill =$('#billdate').val();
	// alert(billno);
	if($.trim(pname) == '') return false;
	
	if(dname==0 && $('#qbdrname1').val()=="")
	dname="Not available";
	else if(dname==0 && $('#qbdrname1').val()!="")
	dname=$('#qbdrname1').val();
	else
	 dname = $('#qbdrname').val();
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
			if($.trim(msg) != '') {
			msg=msg.split("+");
			}
			if(msg[0] !="")
			alert(msg);
			else
			window.location.href = 'billing.php?id='+msg[1]+'&type=2';
		}
   });
}
function createNewIPBill(x){
	
	var pname = $('#ippatientname').val(), dname = $('#ipdrname').val();
	var phno = $('#inv_pat_id').val();
	var billda =$('#billdates').val();
	
	var dob =$('#ipdob').val();
	var age =$('#ipage').val();
	
	if($.trim(pname) == '') return false;
	
	if(dname==0 && $('#ipdrname1').val()=="")
	dname="Not available";
	else if(dname==0 && $('#ipdrname1').val()!="")
	dname=$('#ipdrname1').val();
	else
	 dname = $('#ipdrname').val();
	$.ajax({
		type: 'post',
		url: 'manage-bill/new-billingip.php',
		data: {
			pname: pname,
			dname: dname,
			phno: phno,
			billda:billda,
			dob:dob,
			age:age,
		},
		success: function(msg) {
			if($.trim(msg) != '') {
			msg=msg.split("+");
			}
			if(msg[0] !="")
			alert(msg);
			else
			// window.location.href = 'billingip.php?id='+msg[1]+'&type=2';
			window.location.href = 'billing.php?id='+msg[1]+'&type=2';
			//addBillingItemsip(x);
		}
   });
}
//var inv_pat_id;
function getdetails(x,y) {
	var phno=x.val();
	//inv_pat_id=phno;
	var chk=y;
//alert(phno);
if(phno!='')
{
$.ajax({
			type: 'post',
			url: 'manage-bill/getpatient.php?phno='+phno,
			data: {
			chk: chk,
		},
			success: function(msg) {
				var x = JSON.parse(msg);
				$('#qbpatientname').val(x[0].patientname);
				$('#qbdrname1').val(x[0].reference);
				$('#ippatientname').val(x[0].patientname1);
				$('#ipdrname1').val(x[0].reference1);
				$('#ippaymode').val(x[0].paymode);
				//window.location.href = 'billing.php';
			}
	   });
}}
function deleteBill(x){
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
		url: 'manage-bill/return-aval.php?prod='+encodeURIComponent(prod)+"&batch="+batch,
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
		url: 'manage-bill/return-qty.php',
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

function deleteItem(img, x){
	var row = img.closest("tr"); 
	
	if(confirm("Are you sure to delete?")){
		$.ajax({
			type: 'post',
			url: 'manage-bill/delete-billed-item.php?id='+x,
			success: function(msg) {
				var xx = msg.split("~")
				alert(xx[0]);
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
/*function retExpiry(x){
	
	var prod = $('#pname'+x).val(), batch = $('#batch'+x).val(), type = $('#ptype'+x).val();
	if(batch == 'SELECT') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/return-expiry.php?prod='+encodeURIComponent(prod)+"&batch="+batch+"&type="+type,
		success: function(msg) {
				var xx = JSON.parse(msg);
				$('#expiry'+x).empty();
				$('#expiry'+x).append(new Option("SELECT"));
				for(var i=0;i<xx.length;i++)
					$('#expiry'+x).append(new Option(xx[i].expiry));
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
}*/

function returnExpiry(x){
	
	var prod = $('#pname'+x).val(), batch = $('#batch'+x).val(), type = $('#ptype'+x).val();
	if(batch == 'SELECT') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/return-expiry.php?prod='+encodeURIComponent(prod)+"&batch="+batch+"&type="+type,
		success: function(msg) {
      // alert(msg);
      var xx = JSON.parse(msg);
			// alert(JSON.stringify(xx))
			$('#expiry'+x).empty();
            $('#expiry'+x).val(xx[0].expirydate); 
            $('#expiryval'+x).empty();
            $('#expiryval'+x).val(xx[0].expval);
            // $('#aval').empty("");
		//	var xx = JSON.parse(msg);
			// $('#aval').empty();
                  	     $('#aval').val();
           	}
	});
	
	if(batch == 'SELECT') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/avail-qty.php?prod='+encodeURIComponent(prod)+"&batch="+batch,
		success: function(msg) {
			var xx = JSON.parse(msg);
			$('#aval').empty();
			$('#aval').val( Math.trunc(msg));
			//for(var i=0;i<xx.length;i++)
				//$('#aval').append(new Option(msg));
			
		}
	});
		
}
function Updatestock(){
	
	
	$.ajax({
		type: 'post',
		url: 'update-change-stock.php?prod=&batch='+batch_ids+'&exp_dt='+exp_dt,
		success: function(msg) {
		location.reload();
		}
	});
}
function returnbatExpiry(x)
{
var prod = $('#pname'+x).val(), type = $('#ptype'+x).val();
var suplrid = $('#suplr'+x).val()
	if($.trim(prod) == '') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/return-batchno.php?prod='+encodeURIComponent(prod)+"&suplr="+suplrid,
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

function retBatchNo(x){
	var prod = $('#pname'+x).val(), type = $('#ptype'+x).val();
	if($.trim(prod) == '') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/return-batchno.php?prod='+encodeURIComponent(prod)+"&type="+type,
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

	var prod = $('#pname'+x).val(), qty = $('#qty'+x).val(), expiryval = $('#expiryval'+x).val(), batch = $('#batch'+x).val(), expiry = $('#expiry'+x).val(), type = $('#ptype'+x).val();
	// var dte=$('#invoicedate'+x).val();
	if(prod == '' || qty == '' || batch == 'SELECT' || expiry == '') return false;

	if(expiryval==0)
	{
	 var r = confirm("Selected Item Expires Within 90 Days.Press OK To Confirm!");
    if (r == false) {
    	$('#pname'+x).val('');
    	$('#qty'+x).val('');
    	$('#batch'+x).val('');
    	$('#expiry'+x).val('');
    	$('#aval'+x).val('');
       return false;
    }
	}
		var insur = $('#insur'+x).val();

	$.ajax({
		type: 'post',
		url: 'manage-bill/billing-items-new.php',
		data: {
			type: type,
			prod: encodeURIComponent(prod),
			batch: batch,
			qty: qty,
			expiry: expiry,
			bid: x,
			
		},
		success: function(msg) {
			var t1 = JSON.parse(msg);
			var t = t1.res_arr;
		var tr1 = "<tr><td id='codei"+t.id+"'>"+t.code+"</td><td>"+t.type+"</td><td>"+t.desc+"</td><td><input type='text' class='edqty' onkeypress = 'return qtycheck(event);' data-qty="+t.qty+" id='edqty"+t.id+"'  value="+t.qty+" onBlur='edittotal("+t.id+","+t.bid+")' style='width:50px; height:30px;' ></td><td><select class='form-control input-sm' name='edsup"+t.id+"'  id='edsup"+t.id+"' onchange='editsupplier("+t.id+",'edbat"+t.id+"','#tbl-lists"+t.bid+"' )'><option>SELECT</option>";
		var options = '';
		for(var i=0; i<t1.sup_arr.length; i++){ 
			sup_nm2 = t1.sup_arr[i].suppliername;
			sup_id2 = t1.sup_arr[i].id;
			var sel = "";
			if(t.sup_nm == sup_nm2){sel = "Selected";} else {sel ="";}
			options += '<option value="' + sup_id2+ '" '+sel+' >' + sup_nm2 + '</option>';
		}
		 var tr2 = tr1+options+"</select></td><td><select class='form-control input-sm' name='edbat"+t.id+"'  id='edbat"+t.id+"' onchange='editbatch("+t.id+","+t.purchaseid+",'#tbl-lists"+t.bid+"' )'><option>SELECT</option>";
		 var batchopt = '';
		for(var i=0; i<t1.batch_arr.length; i++){ 
			bt_no = t1.batch_arr[i].batchno;
			purbt_id = t1.batch_arr[i].purchaseid;
			tbl_pur_id = t1.batch_arr[i].id;
			if(t.pur_id == tbl_pur_id){sel1 = "Selected";} else {sel1 ="";}
			batchopt += '<option value="' + tbl_pur_id+ '" '+sel1+' >' + bt_no + '</option>';
		}
		 var tr = tr2+batchopt+"</select></td><td><input type='text' id='edexp"+t.id+"' class='edttl'  value="+t.expi+" disabled style='width:80px; height:30px;'></td><td>"+t.tax_percentage+"</td><td><input type='text' id='edttl"+t.id+"' class='edttl' data-qty='"+t.amt+"' value='"+t.id+"' disabled style='width:80px; height:30px;'></td><td><img src='images/delete.png' style='height:24px; cursor:pointer;' onClick='javascript:deleteItem(this,"+t.id+")'></td></tr>";
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
			$('#pname'+x).val(''); $('#qty'+x).val(''); $('#aval'+x).val(''); $('#expiry'+x).val(''); $('#batch'+x).empty(); $('#expiry'+x).empty(); $('#batch'+x).append(new Option('SELECT')); $('#expiry'+x).append(new Option('SELECT')); $('#ptype'+x).val('SELECT');$('#invoicedate'+x).val('');
		}
	});
}
function addBillingItemsip(x){
	//alert("cx")
	//var prod = $('#pname'+x).val(), qty = $('#qty'+x).val(), batch = $('#batch'+x).val(), expiry = $('#expiry'+x).val(), type = $('#ptype'+x).val();
	//var dte=$('#invoicedate'+x).val();
    var inv_pat_id = $('#inv_pat_id').val();
	//alert(inv_pat_id);
	//alert(x)
	//if(prod == '' || qty == '' || batch == 'SELECT' || expiry == ''|| dte == '') return false;
	$.ajax({
		type: 'post',
		url: 'manage-bill/billing-itemsip.php',
		data: {
			inv_pat_id: inv_pat_id
			//prod: encodeURIComponent(prod),
			//batch: batch,
			//qty: qty,
			//expiry: expiry,
			//bid: x,
			//dtee:dte
		},
		
		success: function(msg) {
			alert(msg)
			alert(x)
			var t = JSON.parse(msg);
			var table = $('#tbl-list'+x+' > tbody');
			alert(table)
			var tr = "<tr><td>"+t.code+"</td><td>"+t.type+"</td><td>"+t.desc+"</td><td>"+t.qty+"</td><td>"+t.batch+"</td><td>"+t.expi+"</td><td>"+t.de+"</td><td>"+t.amt+"</td><td><img src='images/delete.png' style='height:24px; cursor:pointer;' onClick='javascript:deleteItem(this,"+t.id+")'></td></tr>";
			table.append(tr);
			$('#lblAmount'+x).html((parseFloat($('#lblAmount'+x).html()) + parseFloat(t.amt)).toFixed(2));
			//$('#pname'+x).val(''); $('#qty'+x).val(''); $('#batch'+x).empty(); $('#expiry'+x).empty(); $('#batch'+x).append(new Option('SELECT')); $('#expiry'+x).append(new Option('SELECT')); $('#ptype'+x).val('SELECT');$('#invoicedate'+x).val('');
		}
	});
	//createNewIPBill();
	
}


function ChangeStock(){
	var prod = $('#pname').val(), qty = $('#qty').val(), batch = $('#batch').val(), expiry = $('#expiry').val(), type = $('#ptype').val();
	if(prod == '' || qty == '' || batch == 'SELECT' || expiry == '') return false;
	
	var dataObj={
			type: type,
			prod: prod,
			batch: batch,
			qty: qty,
			expiry: expiry,
		}
		
	
	$.ajax({
		type: 'post',
		url: 'change-stock.php',
		data: dataObj,
		success: function(msg) {
			var t = JSON.parse(msg);
			var tr = "<tr><td>"+t.code+"</td><td>"+t.descrip+"</td><td>"+t.qty+"</td><td>"+t.batch+"</td><td>"+t.expiry+"</td><td><img src='images/delete.png' style='height:24px; cursor:pointer;' onClick='javascript:deleteItem(this,"+t.id+")'></td></tr>";
			$('#tbl-list > tbody').append(tr);
			$('#lblAmount').html((parseFloat($('#lblAmount').html()) + parseFloat(t.amt)).toFixed(2));
			$('#pname').val(''); $('#qty').val(''); $('#batch').empty(); $('#expiry').empty(); $('#batch').append(new Option('SELECT')); $('#expiry').append(new Option('SELECT'));
				$('#aval').empty();
				$('#aval').val(t.remain);
			batch_ids.push(t.batch);
			exp_dt.push(t.expiry);
		}
	});
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
			for(var i=0;i<t.length-1;i++){
				var tr = "<tr><td>"+t[i].code+"</td><td>"+t[i].type+"</td><td>"+t[i].desc+"</td><td>"+t[i].qty+"</td><td>"+t[i].batch+"</td><td>"+t[i].expi+"</td><td>"+t[i].tp+"</td><td>"+t[i].amt+"</td><td><img src='images/delete.png' style='height:24px; cursor:pointer;' onClick='javascript:deleteItem(this,"+t[i].id+")'></td></tr>";
			// $('#tbl-lists'+id+" > tbody").append(tr);
			// window.location.reload(true);
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
	var insur = $('#insur'+x).val();
	var ncm_paymode =  $('#ncmpaymentmode'+x).val();
	if(pm == 'SELECT'){ $('#paymentmode'+x).css('border-color','red'); return false; }
	if(insur == '1')
	{
	$.ajax({
		type: 'post',
		url: 'manage-bill/close-bill.php',
		data: {
			pm: pm,
			id: id,
			dis:dis,
			remind:remind,
			ncm_pm : ncm_paymode
		},
		success: function(msg) {
			// alert(msg)
			var msg=$.trim(msg);
			var x=msg.split("~");
			// alert(x[0]);
			var bill = x[1];
			var ip_id =x[2];
			if($.isNumeric(bill)){
				if(p == '1')
					var win = window.open("printbill.php?billno="+bill+'&type=1'+'&payment='+ip_id);
				window.location.href = 'billing.php';
			}else
				alert("ERROR : "+msg);
		}
	});
}else if(insur != '1')
	{ 
		var ncm_paymode =  $('#ncmpaymentmode'+x).val();
		if(ncm_paymode == 'SELECT'){ $('#ncmpaymentmode'+x).css('border-color','red'); return false; }
		$.ajax({
		type: 'post',
		url: 'manage-bill/close-bill.php',
		data: {
			pm: pm,
			id: id,
			dis:dis,
			remind:remind,
			ncm_pm : ncm_paymode,
		},
		success: function(msg) {console.log(msg);
			//alert(msg)
			var msg=$.trim(msg);
			var x=msg.split("~");
			// alert(x[0]);
			var type = x[0];
			var bill = x[1];
			var ip_id =x[2];
			if(type == '1')
			{
			var billncm = x[4];
			var billcm = x[3];
			var cmlen = x[3].length;
			var ncmlen =  x[4].length;
			}
			
			// alert(cmlen +"~~~~"+ ncmlen);
			if($.isNumeric(bill)){
				if(p == '1')
					if(type==='2')
					{
						var win = window.open("printbill.php?billno="+bill+'&type=1'+'&payment='+ip_id);
					} else {
						if(cmlen > 0)
					{
						var win = window.open("printbill.php?billno="+billcm+'&type=1'+'&payment='+ip_id);
					}
					 if(ncmlen > 0)
					{
						var win = window.open("printbill.php?billno="+billncm+'&type=1'+'&payment='+ip_id);	
					} else {
						var win = window.open("printbill.php?billno="+bill+'&type=1'+'&payment='+ip_id);
					}
					}
					
					
					
				// window.location.href = 'billing.php';
			}else
				alert("ERROR : "+msg);
		}
	});
	}
}