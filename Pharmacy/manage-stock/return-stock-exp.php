<?php
	include("../config.php");
	$sql = "Select `A`.`productname`,`B`.`mrp`, `A`.`maxqty`,`A`.`shelf`,`A`.`rack`,`B`.`batchno`, `B`.`expirydate`, `A`.`stocktype`,`B`.`batchno`,sum(B.aval),`S`.`suppliername` FROM tbl_productlist A INNER JOIN tbl_purchaseitems B ON A.id = B.productid
JOIN tbl_purchase P on P.purchaseid= B.purchaseid 
JOIN tbl_supplier S on S.id= P.supplierid
GROUP BY B.productid,A.productname, A.stocktype, B.batchno, B.expirydate, B.mrp, B.aval ORDER by A.productname";
	$res = mysqli_query($db,$sql);
	$i = 1;
	$data = array();
	while($rs = mysqli_fetch_array($res)){
		$id = $rs['id'];
		$avail=$rs['sum(B.aval)'];
		// $q = mysqli_query($db,"SELECT productid, batchno, expirydate,purchaseid, sum(aval) as avail, mrp FROM tbl_purchaseitems WHERE productid = $id AND status = 1 GROUP BY productid, batchno, expirydate");
		if(mysqli_num_rows($res) != 0){
			
			// while($rs = mysqli_fetch_array($res)){
				
				$ee = $rs['expirydate'];
				$expirydate = implode("/",array_reverse(explode("-",$rs['expirydate'])));
	$expirydate = substr($expirydate,3);
				
				$start_date = date('Y-m-d');
				$end_date = date('Y-m-d', strtotime("+120 days"));
				$pid=$rs['purchaseid'];
				// if($pid != 0){
				// $get_sup_name=mysqli_query($db,'select * from tbl_purchase where purchaseid='.$pid);
				// while($get_sup=mysqli_fetch_array($get_sup_name)){
				// $sid=$get_sup['supplierid'];
				// }
				// $sname=mysqli_query($db,'select * from tbl_supplier where id='.$sid);
				// while($gsname=mysqli_fetch_array($sname)){
				// $supplier=$gsname['suppliername'];
				// }
				// }
				// else
				// {
					// $supplier=" - ";
				// }
				// //$get_sup_name=mysqli_query($db,'select * from tbl_purchase where purchaseid='.$pid);
				// while($get_sup=mysqli_fetch_array($get_sup_name)){
				// 	$sid=$get_sup['supplierid'];
				// }
				// $sname=mysqli_query($db,'select * from tbl_supplier where id='.$sid);
				// while($gsname=mysqli_fetch_array($sname)){
				// 	$supplier=$gsname['suppliername'];
				// }
				
				if(strtotime($ee) <= strtotime($end_date) && $ee != 0000-00-00)
				{
						
				$x = array('#'=>$i++,
							'type'=>$rs['stocktype'], 
							 'product'=>$rs['productname'], 
							 'batch'=>$rs['batchno'], 
							 'expiry'=>$expirydate,
							  'Supplier'=>$rs['suppliername'],
							 'avail'=>$avail, 
							 'shelf'=>$rs['shelf'], 
							 'rack'=>$rs['rack'],
							 'mrp'=>$rs['mrp'],
							 'alrt'=>$alert);
				array_push($data, $x);
			}
			// }
			}
		
		
	}
    $results = array(
            "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
          "aaData"=>$data);
echo json_encode($results);
?>