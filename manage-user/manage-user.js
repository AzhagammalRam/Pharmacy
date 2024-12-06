// JavaScript Document

function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('#imgPhoto').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
function readNewURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('#newimgPhoto').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
function newUser(){
	var username = $('#newUserName').val(), userid = $('#newUserId').val(), pass = $('#newPassword').val(), role = $('#newRole').val(); store = $('#newstore').val();
	var	opt1 = $('#opt1').is(':checked') ? "1" : "0",	opt2= $('#opt2').is(':checked') ? "1" : "0",
		opt3 = $('#opt3').is(':checked') ? "1" : "0",	opt4 = $('#opt4').is(':checked') ? "1" : "0",
		opt5 = $('#opt5').is(':checked') ? "1" : "0",	opt6 = $('#opt6').is(':checked') ? "1" : "0",
		opt7 = $('#opt7').is(':checked') ? "1" : "0",	opt8 = $('#opt8').is(':checked') ? "1" : "0",
		opt9 = $('#opt9').is(':checked') ? "1" : "0",	opt10 = $('#opt10').is(':checked') ? "1" : "0",
		opt11 = $('#opt11').is(':checked') ? "1" : "0",	opt12 = $('#opt12').is(':checked') ? "1" : "0",
		opt13 = $('#opt13').is(':checked') ? "1" : "0", opt14 = $('#opt14').is(':checked') ? "1" : "0",
		opt15 = $('#opt15').is(':checked') ? "1" : "0", opt16 = $('#opt16').is(':checked') ? "1" : "0" ,
		opt17 = $('#opt17').is(':checked') ? "1" : "0", opt18 = $('#opt18').is(':checked') ? "1" : "0",  
		opt19 = $('#opt19').is(':checked') ? "1" : "0",	opt20 = $('#opt20').is(':checked') ? "1" : "0", 
		opt21 = $('#opt21').is(':checked') ? "1" : "0", opt22 = $('#opt22').is(':checked') ? "1" : "0",
		opt23 = $('#opt23').is(':checked') ? "1" : "0", opt24 = $('#opt24').is(':checked') ? "1" : "0",
		opt25 = $('#opt25').is(':checked') ? "1" : "0", opt26 = $('#opt26').is(':checked') ? "1" : "0",
		opt27 = $('#opt27').is(':checked') ? "1" : "0", opt28 = $('#opt28').is(':checked') ? "1" : "0",
		opt29 = $('#opt29').is(':checked') ? "1" : "0"; opt30 = $('#opt30').is(':checked') ? "1" : "0";
		opt31 = $('#opt31').is(':checked') ? "1" : "0"; opt32 = $('#opt32').is(':checked') ? "1" : "0";
		opt33 = $('#opt33').is(':checked') ? "1" : "0"; opt34 = $('#opt34').is(':checked') ? "1" : "0";
	// if(username == "" || userid == "" || pass == "" || role == 0)
		// return false;
	if(username == ''){ alert('Name Cannot be Left Blank'); return false; }
	if(userid == ''){ alert('User Id Details Cannot be Left Blank'); return false; }
	if(role == '0'){ alert('Select the Role'); return false; }
	if(pass == ''){ alert('Password Details Cannot be Left Blank'); return false; }
	var photo = $('#newPhoto').prop('files')[0];
	var fd = new FormData();
	fd.append('photo',photo);
	fd.append('username',username);
	fd.append('userid',userid);
	fd.append('pass',pass);
	fd.append('role',role);
	fd.append('store',store);
	fd.append('opt1',opt1);
	fd.append('opt2',opt2);
	fd.append('opt3',opt3);
	fd.append('opt4',opt4);
	fd.append('opt5',opt5);
	fd.append('opt6',opt6);
	fd.append('opt7',opt7);
	fd.append('opt8',opt8);
	fd.append('opt9',opt9);
	fd.append('opt10',opt10);
	fd.append('opt11',opt11);
	fd.append('opt12',opt12);
	fd.append('opt13',opt13);
	fd.append('opt14',opt14);
	fd.append('opt15',opt15);
	fd.append('opt16',opt16);
	fd.append('opt17',opt17);
    fd.append('opt18',opt18);
     fd.append('opt19',opt19);
    fd.append('opt20',opt20);
    fd.append('opt21',opt21);
    fd.append('opt22',opt22);
    fd.append('opt23',opt23);
    fd.append('opt24',opt24);
    fd.append('opt25',opt25);
    fd.append('opt26',opt26);
    fd.append('opt27',opt27);
    fd.append('opt28',opt28);
    fd.append('opt29',opt29);
    fd.append('opt30',opt30);
    fd.append('opt31',opt31);
    fd.append('opt32',opt32);
    fd.append('opt33',opt33);
    fd.append('opt34',opt34);
	$.ajax({
        type: 'post',
        url: 'manage-user/new-user-details.php?'+fd,
		contentType: false,
		processData: false,
		data: fd,
        success: function(msg) {
			// alert(msg);
			// window.location.href="manage-user.php";
			if(msg.includes("New User Added!"))
		{
	 			window.location.href="manage-user.php";
				
		}
		else
		{
			alert(msg);
			
			}
        }
    });
}
function updateUser(){

	var username = $('#UserName').val(), userid = $('#UserId').val(), pass = $('#Password').val(), role = $('#Role').val(), dbid = $('#DBid').val(); store = $('#newstore').val();
	var	opt1 = $('#xopt1').is(':checked') ? "1" : "0",		opt2= $('#xopt2').is(':checked') ? "1" : "0",
		opt3 = $('#xopt3').is(':checked') ? "1" : "0",		opt4 = $('#xopt4').is(':checked') ? "1" : "0",
		opt5 = $('#xopt5').is(':checked') ? "1" : "0",		opt6 = $('#xopt6').is(':checked') ? "1" : "0",
		opt7 = $('#xopt7').is(':checked') ? "1" : "0",		opt8 = $('#xopt8').is(':checked') ? "1" : "0",
		opt9 = $('#xopt9').is(':checked') ? "1" : "0",		opt10 = $('#xopt10').is(':checked') ? "1" : "0",
		opt11 = $('#xopt11').is(':checked') ? "1" : "0",	opt12 = $('#xopt12').is(':checked') ? "1" : "0",
		opt13 = $('#xopt13').is(':checked') ? "1" : "0",    opt14 = $('#xopt14').is(':checked') ? "1" : "0",
		opt15 = $('#xopt15').is(':checked') ? "1" : "0",    opt16 = $('#xopt16').is(':checked') ? "1" : "0",
		opt17 = $('#xopt17').is(':checked') ? "1" : "0",    opt19 = $('#xopt19').is(':checked') ? "1" : "0",
		opt20 = $('#xopt20').is(':checked') ? "1" : "0",
		opt21 = $('#xopt21').is(':checked') ? "1" : "0",    opt22 = $('#xopt22').is(':checked') ? "1" : "0",
		opt23 = $('#xopt23').is(':checked') ? "1" : "0",    opt24 = $('#xopt24').is(':checked') ? "1" : "0",
		opt25 = $('#xopt25').is(':checked') ? "1" : "0",    opt26 = $('#xopt26').is(':checked') ? "1" : "0",
		opt27 = $('#xopt27').is(':checked') ? "1" : "0",    opt28 = $('#xopt28').is(':checked') ? "1" : "0",
		opt29 = $('#xopt29').is(':checked') ? "1" : "0";	opt30 = $('#xopt30').is(':checked') ? "1" : "0";
		opt31 = $('#xopt31').is(':checked') ? "1" : "0";    opt32 = $('#xopt32').is(':checked') ? "1" : "0";
		opt33 = $('#xopt33').is(':checked') ? "1" : "0";	opt34 = $('#xopt34').is(':checked') ? "1" : "0";
	if(username == "" || userid == "")
		return false;
	if(pass == ''){ alert('Password Details Cannot be Left Blank'); return false; }
	var photo = $('#Photo').prop('files')[0];
	var fd = new FormData();
	fd.append('photo',photo);
	fd.append('username',username);
	fd.append('userid',userid);
	fd.append('pass',pass);
	fd.append('role',role);
	fd.append('store',store);
	fd.append('opt1',opt1);
	fd.append('opt2',opt2);
	fd.append('opt3',opt3);
	fd.append('opt4',opt4);
	fd.append('opt5',opt5);
	fd.append('opt6',opt6);
	fd.append('opt7',opt7);
	fd.append('opt8',opt8);
	fd.append('opt9',opt9);
	fd.append('opt10',opt10);
	fd.append('opt11',opt11);
	fd.append('opt12',opt12);
	fd.append('opt13',opt13);
	fd.append('opt14',opt14);
	fd.append('opt15',opt15);
	fd.append('opt16',opt16);
	fd.append('opt17',opt17);
	fd.append('opt19',opt19);
	fd.append('opt20',opt20);
	fd.append('opt21',opt21);
	fd.append('opt22',opt22);
	fd.append('opt23',opt23);
	fd.append('opt24',opt24);
	fd.append('opt25',opt25);
	fd.append('opt26',opt26);
	fd.append('opt27',opt27);
	fd.append('opt28',opt28);
	fd.append('opt29',opt29);
	fd.append('opt30',opt30);
	fd.append('opt31',opt31);
	fd.append('opt32',opt32);
	fd.append('opt33',opt33);
	fd.append('opt34',opt34);
	fd.append('id',dbid);
	$.ajax({
        type: 'post',
        url: 'manage-user/update-user-details.php?'+fd,
		contentType: false,
		processData: false,
		data: fd,
        success: function(msg) {
			alert(msg);
			window.location.href="manage-user.php";
        }
    });
}
$('table').on('click', 'a[id=edit]', function (e) {
	var txt = $(this).attr("data-val");
	$.ajax({	
		url: 'manage-user/return-edit-user-info.php?id='+txt,
		type: 'POST',
		success:function(msg){
			var x = msg.split("~");
			$('#DBid').val(x[4]);
			$('#UserName').val(x[0]);	$('#UserId').val(x[1]);
			$('#Role').val(x[2]);       $('#Password').val(x[33]); $('#newstore').val(x[34]);
			$('#imgPhoto').attr("src", "return-user-img.php?id="+x[4]);
			if(x[5] == 1) $('#xopt1').prop("checked", true); else $('#xopt1').prop("checked", false);
			if(x[6] == 1) $('#xopt2').prop("checked", true); else $('#xopt2').prop("checked", false);
			if(x[7] == 1) $('#xopt3').prop("checked", true); else $('#xopt3').prop("checked", false);
			if(x[8] == 1) $('#xopt4').prop("checked", true); else $('#xopt4').prop("checked", false);
			if(x[9] == 1) $('#xopt5').prop("checked", true); else $('#xopt5').prop("checked", false);
			if(x[10] == 1) $('#xopt6').prop("checked", true); else $('#xopt6').prop("checked", false);
			if(x[11] == 1) $('#xopt7').prop("checked", true); else $('#xopt7').prop("checked", false);
			if(x[12] == 1) $('#xopt8').prop("checked", true); else $('#xopt8').prop("checked", false);
			if(x[13] == 1) $('#xopt9').prop("checked", true); else $('#xopt9').prop("checked", false);
			if(x[14] == 1) $('#xopt10').prop("checked", true); else $('#xopt10').prop("checked", false);
			if(x[15] == 1) $('#xopt11').prop("checked", true); else $('#xopt11').prop("checked", false);
			if(x[16] == 1) $('#xopt12').prop("checked", true); else $('#xopt12').prop("checked", false);
			if(x[17] == 1) $('#xopt13').prop("checked", true); else $('#xopt13').prop("checked", false);
			if(x[18] == 1) $('#xopt14').prop("checked", true); else $('#xopt14').prop("checked", false);
			if(x[19] == 1) $('#xopt15').prop("checked", true); else $('#xopt15').prop("checked", false);
			if(x[20] == 1) $('#xopt16').prop("checked", true); else $('#xopt16').prop("checked", false);
			if(x[21] == 1) $('#xopt17').prop("checked", true); else $('#xopt17').prop("checked", false);
			if(x[22] == 1) $('#xopt20').prop("checked", true); else $('#xopt20').prop("checked", false);
			if(x[23] == 1) $('#xopt21').prop("checked", true); else $('#xopt21').prop("checked", false);
			if(x[24] == 1) $('#xopt22').prop("checked", true); else $('#xopt22').prop("checked", false);
			if(x[25] == 1) $('#xopt23').prop("checked", true); else $('#xopt23').prop("checked", false);
			if(x[26] == 1) $('#xopt24').prop("checked", true); else $('#xopt24').prop("checked", false);
			if(x[27] == 1) $('#xopt25').prop("checked", true); else $('#xopt25').prop("checked", false);
			if(x[28] == 1) $('#xopt26').prop("checked", true); else $('#xopt26').prop("checked", false);
			if(x[29] == 1) $('#xopt27').prop("checked", true); else $('#xopt27').prop("checked", false);
			if(x[30] == 1) $('#xopt19').prop("checked", true); else $('#xopt19').prop("checked", false);
			if(x[31] == 1) $('#xopt28').prop("checked", true); else $('#xopt28').prop("checked", false);
			if(x[32] == 1) $('#xopt29').prop("checked", true); else $('#xopt29').prop("checked", false);
			if(x[35] == 1) $('#xopt30').prop("checked", true); else $('#xopt30').prop("checked", false);
			if(x[36] == 1) $('#xopt31').prop("checked", true); else $('#xopt31').prop("checked", false);
			if(x[37] == 1) $('#xopt32').prop("checked", true); else $('#xopt32').prop("checked", false);
			if(x[38] == 1) $('#xopt33').prop("checked", true); else $('#xopt33').prop("checked", false);
			if(x[39] == 1) $('#xopt34').prop("checked", true); else $('#xopt34').prop("checked", false);

		}
	});
	var modal = $('#modal-update');
	modal.modal('show');
});
$('table').on('click', 'a[id=view]', function (e) {
	var txt = $(this).attr("data-val");
	$.ajax({	
		url: 'manage-user/return-user-info.php?id='+txt,
		type: 'POST',
		success:function(msg){
			var x = msg.split("~");
			// alert(x);
			$('#txtUserName').html(x[0]);	$('#txtUserId').html(x[1]);
			$('#txtRole').html(x[2]);		$('#txtStatus').html(x[3]);
			$('#txtstore').html(x[4]);
			$('#txtPhoto').attr("src", "return-user-img.php?id="+x[5]);
			$('#vopt1').html(x[6]);		$('#vopt2').html(x[7]);	$('#vopt3').html(x[8]);	$('#vopt4').html(x[9]);
			$('#vopt5').html(x[10]);		$('#vopt6').html(x[11]);
			$('#vopt7').html(x[12]);	$('#vopt8').html(x[13]);
			$('#vopt9').html(x[14]);	$('#vopt10').html(x[15]); $('#vopt11').html(x[16]);
			$('#vopt12').html(x[17]);	$('#vopt13').html(x[18]); $('#vopt14').html(x[19]);
			$('#vopt15').html(x[20]);   $('#vopt16').html(x[21]);
			$('#vopt17').html(x[22]);   $('#vopt20').html(x[23]); $('#vopt21').html(x[24]);
			$('#vopt22').html(x[25]);   $('#vopt23').html(x[26]); $('#vopt24').html(x[27]); $('#vopt25').html(x[28]);
			$('#vopt26').html(x[29]);   $('#vopt27').html(x[30]); $('#vopt19').html(x[31]); $('#vopt28').html(x[32]);
			 $('#vopt29').html(x[33]);  $('#vopt30').html(x[34]); $('#vopt31').html(x[35]); $('#vopt32').html(x[36]);
			 $('#vopt33').html(x[37]); $('#vopt34').html(x[38]); 
		}
	});
	var modal = $('#modal-view');
	modal.modal('show');
});
$('table').on('click', 'a[id=disable]', function (e) {
	var txt = $(this).attr('data-val');
	var rid = $(this).closest("tr").index();
	if(confirm("Sure to disable user?")){
		$.ajax({	
			url: 'manage-user/disable-user.php?id='+txt,
			type: 'POST',
			success:function(msg){
				var x = msg.split("~");
				if(x[0] != 'ok'){
					alert(msg);
					return false;
				}
				window.location.href="manage-user.php";
			}
		});
	}
});
$('table').on('click', 'a[id=enable]', function (e) {
	var txt = $(this).attr('data-val');
	var rid = $(this).closest("tr").index();
	if(confirm("Sure to enable user?")){
		$.ajax({	
			url: 'manage-user/enable-user.php?id='+txt,
			type: 'POST',
			success:function(msg){
				var x = msg.split("~");
				if(x[0] != 'ok'){
					alert(msg);
					return false;
				}
				window.location.href="manage-user.php";
			}
		});
	}
});
$('table').on('click', 'a[id=delete]', function (e) {
	var txt = $(this).attr('data-val');
	var rid = $(this).closest("tr").index();
	if(confirm("Sure to delete user?")){
		$.ajax({	
			url: 'manage-user/delete-user.php?id='+txt,
			type: 'POST',
			success:function(msg){
				if(msg != 'ok'){
					alert(msg);
					return false;
				}
				alert('User Record Deleted !');
				window.location.href = 'manage-user.php';
			}
		});
	}
});