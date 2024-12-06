<?php
	session_start();
	require_once("config.php");
	$username = $_POST['username'];
	$password = $_POST['password'];
	$username  = mysqli_escape_string($db,$username);
	

	$res = mysqli_query($db,"SELECT * FROM test WHERE status = 1");
	$r = mysqli_fetch_array($res);

	$today = date('d-m-Y');
	$checkin = strtotime($today);
		
	if($r['checkin'] != '')
		$oldday = date('d-m-Y',$r['checkin']);
	else
		$oldday = date('d-m-Y');
		
	if(strtotime($oldday) > strtotime($today)){
		$_SESSION['loginerror'] = "Check System Date & Time ! <br /> Last Login $oldday";
		header('location:login.php');
		exit();
	}else{
		mysqli_query($db,"UPDATE test SET checkin = '$checkin'");
	}

	$sql = mysqli_query($db,"SELECT * FROM tbl_users WHERE status = 1 AND userid = '$username'");
	$rs = mysqli_fetch_array($sql);
	if($password == $rs['password']){
		$_SESSION['phar-username'] = $rs['username'];
		$_SESSION['phar-role'] = $rs['role'];
		$_SESSION['phar-loginid'] = $rs['id'];
		$_SESSION['storeid'] = $rs['storeid'];
		
	$expiry =$r["register_date"];
	$time=date('d-m-Y');
	$upto= strtotime($time);
	$days =$expiry-$upto;
	// $days 
	$daysRemaining=round($days/86400);
	// $daysRemaining;
	$_SESSION['days']=$daysRemaining;
		/*header('location:index.php');	
		exit();*/
				
		$_SESSION['mp'] = $rs['mp'];		$_SESSION['mm'] = $rs['mm'];	         $_SESSION['ms'] = $rs['ms']; 		
		$_SESSION['mu'] = $rs['mu'];        $_SESSION['mst'] = $rs['mst'];           $_SESSION['md'] = $rs['md'];
		$_SESSION['sc'] = $rs['sc'];        $_SESSION['cc'] = $rs['cc'];             $_SESSION['bill'] = $rs['bill'];
		$_SESSION['sr'] = $rs['sr']; 		$_SESSION['pfrep'] = $rs['pfrep'];       $_SESSION['purretrep'] = $rs['purretrep'];
		$_SESSION['pe'] = $rs['pe'];		$_SESSION['pr'] = $rs['pr'];             $_SESSION['vat'] = $rs['vat'];            
		$_SESSION['sa'] = $rs['sa'];		$_SESSION['ise'] = $rs['ise'];		     $_SESSION['stka'] = $rs['stka'];		
		$_SESSION['srep'] = $rs['srep'];	$_SESSION['prep'] = $rs['prep'];         $_SESSION['doc'] = $rs['doc'];    
		$_SESSION['sch'] = $rs['sch'];      $_SESSION['sttra'] = $rs['sttra'];       $_SESSION['exrep'] = $rs['exrep'];
		$_SESSION['iprep'] = $rs['iprep'];  $_SESSION['storep'] = $rs['storep'];     $_SESSION['dreturn'] = $rs['dreturn'];
		$_SESSION['dgrep'] = $rs['dgrep'];  $_SESSION['ustock'] = $rs['ustock'];     $_SESSION['clearstock'] = $rs['clearstock'];
		$_SESSION['dispose_report'] = $rs['dispose_report'];   $_SESSION['cmrep'] = $rs['cmrep'];
		$_SESSION['mp-username'] = $rs['username'];
		if($r["register_date"] != '')
			$expiry = date('d-m-Y',$r["register_date"]);
		else
			$expiry = '';
		
		if($expiry != ''){
			if(strtotime($expiry) < strtotime($today)){
				$_SESSION['phar-license'] = 0;
				header('location:license-expired.php');	
				exit();
			}else{
				$_SESSION['phar-license'] = 1;
				header('location:index.php');	
				exit();
			}
		}else{
			$_SESSION['phar-license'] = 0;
			header('location:license-expired.php');	
			exit();
		}	
	}
	else{
		$_SESSION['loginerror'] = "Invalid Username / Password !";
		header('location:login.php');
		exit();
	}
?>