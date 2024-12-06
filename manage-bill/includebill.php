<div class="modal fade" tabindex="-1" role="dialog" id="mdlNewQuickBill">
    <div class="modal-dialog modal-xs">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" tabindex="111" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">New Bill</h4>
        </div>
        <div>
       <!-- <center><button id="other" class="btn btn-primary btn-sm" value="others" onClick="other_bill()">Others</button>
        <button id="ip_patient" class="btn btn-primary btn-sm" value="ip_patient" onClick="Ip_bill()">Ip Patient</button></center> -->
        <div id="other_bill">
          <div class="modal-body">
          <form class="form-horizontal">
		  	 <div class="form-group">
              <label class="col-xs-3 control-label">Bill Date</label>
              <div class="col-xs-8">
      <input type="text"  class="form-control input-sm mand invoicedate" tabindex="112" value="<?php echo date("d-m-Y");?>" disabled placeholder="YYYY/MM/DD" name="billdate" id="billdate">
              </div>
            </div>
        <div class="form-group">
              <label class="col-xs-3 control-label">UHID / Phno</label>
              <div class="col-xs-8">
                <input type="text" class="form-control input-sm mand" tabindex="113" name="qbcontactnumber" id="qbcontactnumber" placeholder="UHID/Phone Number" onBlur="getdetails($(this),1)">
              </div>
            </div>
           
            <div class="form-group">
              <label class="col-xs-3 control-label">Patient Name</label>
              <div class="col-xs-8">
                <input type="text" class="form-control input-sm mand" tabindex="114" name="qbpatientname" id="qbpatientname" placeholder="Patient Name">
              </div>
            </div>
		
            <div class="form-group">
			<?php require_once("config.php");
			$query=mysqli_query($db,"select id,doctorname from tbl_doctor");
			?>
              <label class="col-xs-3 control-label">Doctor Name</label>
              <div class="col-xs-8">
			  <select id='qbdrname' tabindex="115" name="qbdrname" onChange="checkdoctor($(this))"> 
			  <option value="0">Select</option>
			<?php  while($q=mysqli_fetch_array($query)) { 
			echo '
			<option value='.$q['doctorname'].'>'.$q['doctorname'].'</option>
			';
                
				} ?>
				</select>
              </div>
            </div>
			 <div class="form-group">
			 <label class="col-xs-3 control-label"></label>
			 <div class="col-xs-8">
			 <div id="otherdoctor">
			<input type="text" tabindex="116" class="form-control input-sm" name="qbdrname1" id="qbdrname1" placeholder="Doctor Name">
			</div>
			</div>
			 </div>
          </form>
		 <script>
		 function checkdoctor(x) {
		 var doctor=x.val();
		 if(doctor==0)
		 $("#otherdoctor").show(); 
		
		 else {
		 $("#qbdrname1").val(""); 
		 $("#otherdoctor").hide();
		 }
		// alert(doctor);
		 }
		 </script>
        </div>
                 <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-sm" tabindex="117" onClick="createNewBill()">Create Bill</button>
          <button type="button" class="btn btn-default btn-sm" tabindex="118" data-dismiss="modal">Close</button>
        </div>
        </div>
        



        
      </div>
      </div>
    </div>
  </div>
  






  <div class="modal fade" tabindex="-1" role="dialog" id="mdlNewQuickBillIp">
    <div class="modal-dialog modal-xs">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" tabindex="119" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">New Bill</h4>
        </div>
        <div>        
        <div id="ip_bill">
        <div class="modal-body">
          <form class="form-horizontal">
		  	<div class="form-group">
              <label class="col-xs-3 control-label">Bill Date</label>
              <div class="col-xs-8">
      <input type="text"  class="form-control input-sm mand invoicedate" tabindex="120" value="<?php echo date("d-m-Y");?>" disabled placeholder="YYYY/MM/DD" name="billdates" id="billdates">
              </div>
            </div>
        <div class="form-group">
              <label class="col-xs-3 control-label">Ph no</label>
              <div class="col-xs-8">
                <input type="text" class="form-control input-sm mand" tabindex="121" name="inv_pat_id" id="inv_pat_id" placeholder="Ph no" onBlur="getdetails($(this),2)">
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-xs-3 control-label">Patient Name</label>
              <div class="col-xs-8">
                <input type="text" class="form-control input-sm mand" tabindex="122" name="ippatientname" id="ippatientname" placeholder="Patient Name">
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-xs-3 control-label">Date of Birth</label>
              <div class="col-xs-8">
              <input type="text" class="form-control input-sm" tabindex="2" name="ipdob" id="ipdob" <?php echo $readonly; ?> placeholder="DD-MM-YYYY" onblur="calculateAge(this.value)">
              </div>
            </div>

            <div class="form-group">
              <label class="col-xs-3 control-label">Age</label>
              <div class="col-xs-8">
                <input type="text" class="form-control input-sm mand" tabindex="122" name="ipage" id="ipage" placeholder="Age">
              </div>
            </div>
		
            <div class="form-group">
			<?php require_once("config.php");
			$query=mysqli_query($db,"select id,doctorname from tbl_doctor");
			?>
              <label class="col-xs-3 control-label">Doctor Name</label>
              <div class="col-xs-8">
			  <select id='ipdrname' name="ipdrname" tabindex="123" onChange="checkdoctor1($(this))"> 
			  <option value="0">Select</option>
			<?php  while($q=mysqli_fetch_array($query)) { 
			echo '
			<option value='.$q['doctorname'].'>'.$q['doctorname'].'</option>
			';
                
				} ?>
				</select>
              </div>
            </div>


			 <div class="form-group">
			 <label class="col-xs-3 control-label"></label>
			 <div class="col-xs-8">
			 <div id="otherdoctorip">
			<input type="text" class="form-control input-sm" name="ipdrname1" id="ipdrname1" placeholder="Doctor Name" >
			</div>
			</div>
			 </div>
        <div class="form-group">
              <label class="col-xs-3 control-label">Payment Mode</label>
              <div class="col-xs-8">
                <input type="text" class="form-control input-sm mand" tabindex="124" name="ippaymode" id="ippaymode" placeholder="Payment Mode">
              </div>
            </div>
          </form>
		 <script>
		 function checkdoctor1(x) {
		 var doctor=x.val();
		 if(doctor==0)
		 $("#otherdoctorip").show(); 
		
		 else {
		 $("#ipdrname1").val(""); 
		 $("#otherdoctorip").hide();
		 }
		// alert(doctor);
		 }
		 </script>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-sm"  tabindex="125" onClick="createNewIPBill('<?php echo $rs['id']+1 ?>')">Create Bill</button>
          <button type="button" class="btn btn-default btn-sm" tabindex="126" data-dismiss="modal">Close</button>
        </div>
      </div>
      </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
// function other_bill(){
// 	//$("#other").click(function(){
//     $("#other_bill").show();
// 	$("#ip_bill").hide();
// //});	
// }
// function Ip_bill(){
// 	//$("#ip_patient").click(function(){
//     $("#ip_bill").show();
// 	$("#other_bill").hide();
// //});	
// }
</script>
<link rel="stylesheet" type="text/css" href="datetimepicker/jquery.datetimepicker.css"/ >
<script src="datetimepicker/jquery.datetimepicker.js"></script>
<script>
  $(document).ready(function () { 
    $('.invoicedate').datetimepicker({
      lang:'en',
      timepicker:false,
      format:'d-m-Y',
      maxDate:0,
    }); 
  });
</script>

<style>
.btn-group.bootstrap-select.dropup {
    width: 100% !important;
}
</style>

<script>
	$(document).ready(function () { 
		$('#ipdob').datetimepicker({
			lang:'en',
			timepicker:false,
			format:'d-m-Y',
      maxDate:0,
      }); 
	});


  function calculateAge(dob) {
    // Change Date Format
    const changeDate = dob.split("-");
    const result = changeDate[2]+"-"+changeDate[1]+"-"+changeDate[0];

    // Parse the date of birth
    const birthDate = new Date(result);
    const today = new Date();

    // Calculate age
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();

    // Adjust if the current date is before the birth date this year
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    $("#ipage").val(age);
    return age;
}
</script>
