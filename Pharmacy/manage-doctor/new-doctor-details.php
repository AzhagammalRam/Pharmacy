<?php
	include("../config.php");
	
	$doctor = $_REQUEST['doctor'];				$doctor = mysqli_escape_string($db,$doctor);
	$addressline1 = $_REQUEST['addressline1'];		$addressline1 = mysqli_escape_string($db,$addressline1);
	$addressline2 = $_REQUEST['addressline2'];		$addressline2 = mysqli_escape_string($db,$addressline2);
	$addressline3 = $_REQUEST['addressline3'];		$addressline3 = mysqli_escape_string($db,$addressline3);

	$city = $_REQUEST['city'];	
	$state = $_REQUEST['state'];
	$pincode = $_REQUEST['pincode'];
	$country = $_REQUEST['country'];
	$contact1 = $_REQUEST['contact1'];
	$contact2 = $_REQUEST['contact2'];
	$email = $_REQUEST['email'];
	$document_type=$_REQUEST['doctype']; 
	
 if($_FILES)
			{   	 
				 "Upload: " . $_FILES["image"]["name"] . "<br>";
    			 "Type: " . $_FILES["image"]["type"] . "<br>";
				 "Size: " . $_FILES["image"]["size"]/1024 . "kb<br>";
					move_uploaded_file($_FILES["image"]["tmp_name"],
     			 	"../doctor_documents/" . $_FILES["image"]["name"]);
					$image=$_FILES["image"]["name"];
					$size=$_FILES["image"]["size"]/1024;
					$type=$_FILES["image"]["type"];
					if($image==''||$image=='null')
					{
					insert($image,$doctor,$addressline1,$addressline2,$addressline3,$city,$state,$pincode,$country,$contact1,$contact2,$email,$document_type);	
					}
					else if($size > 1000 )
					{
						echo 'size is large';
						return; 
						
						}elseif (($type=='image/jpeg')||($type=='image/jpg')||($type=='image/png')||($type=='application/pdf')){
							
							insert($image,$doctor,$addressline1,$addressline2,$addressline3,$city,$state,$pincode,$country,$contact1,$contact2,$email,$document_type);
							
							}
				
			 
			 else {
				 echo 'Image not supported';
				 }
			}
			
			
			


function insert ($image,$doctor,$addressline1,$addressline2,$addressline3,$city,$state,$pincode,$country,$contact1,$contact2,$email,$document_type)
{
	include("../config.php");
	$query='INSERT INTO tbl_doctor (doctorname,addressline1,addressline2,addressline3,city, state, country, pincode, contactno1, contactno2, emailid,document_type,file_upload,status) values(\''.$doctor.'\',\''.$addressline1.'\',\''.$addressline2.'\',\''.$addressline3.'\',\''.$city.'\',\''.$state.'\',\''.$country.'\',\''.$pincode.'\',\''.$contact1.'\',\''.$contact2.'\',\''.$email.'\',\''.$document_type.'\',\''.$image.'\',"1")';

	if(mysqli_query($db,$query))
		echo "success";
	else
		echo mysqli_error($db);
	}			
			
?>
 
