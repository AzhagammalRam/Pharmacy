<?php
	include("../config.php");
	$sql = "Select `A`.`productname`,`B`.`mrp`, `A`.`maxqty`,`A`.`shelf`,`A`.`rack`,`B`.`batchno`, `B`.`expirydate`, `A`.`stocktype`,`B`.`batchno`,sum(B.aval),`S`.`suppliername` FROM tbl_productlist A INNER JOIN tbl_purchaseitems B ON A.id = B.productid
JOIN tbl_purchase P on P.purchaseid= B.purchaseid 
JOIN tbl_supplier S on S.id= P.supplierid
WHERE B.aval<=3 
GROUP BY B.productid,A.productname, A.stocktype, B.batchno, B.expirydate, B.mrp ORDER by A.productname";
	$res = mysqli_query($db,$sql);
	$i = 1;
	$data = array();
	while($rs = mysqli_fetch_array($res)){
		$id = $rs['id'];
															// $q = mysqli_query($db,"SELECT productid, batchno, expirydate,purchaseid, sum(aval) as avail, mrp FROM tbl_purchaseitems WHERE productid = $id AND status = 1 GROUP BY productid, batchno, expirydate");
		$avail=$rs['sum(B.aval)'];
		// if(mysqli_num_rows($q) != 0){
			
			// while($rs= mysqli_fetch_array($q)){
				// if($rs['avail']	<= 3) {	
				$ee = $rs['expirydate'];
				$expirydate = implode("/",array_reverse(explode("-",$rs['expirydate'])));
	$expirydate = substr($expirydate,3);				
				$start_date = date('Y-m-d');
				$end_date = date('Y-m-d', strtotime("+60 days"));
				$pid=$rs['purchaseid'];
				// if($pid != 0){

				// }
				// else
				// {
				// 	$supplier=" - ";
				// }
				
				
				if(strtotime($ee) <= strtotime($end_date))
					$alert = 1;
				else
					$alert = 0;
						
				$x = array('#'=>$i++,
							'type'=>$rs['stocktype'], 
							 'product'=>$rs['productname'], 
							 'batch'=>$rs['batchno'], 
							 'expiry'=>$expirydate,
							 'Supplier'=>$rs['suppliername'],
							 'avail'=>$avail,
							  'maxqty'=>$rs['maxqty'],
							 'shelf'=>$rs['shelf'], 
							 'rack'=>$rs['rack'],
							 'mrp'=>$rs['mrp'],
							 'alrt'=>$alert);
				array_push($data, $x);
			// }
			// }
		// }
		// else{
			
		// 		$x = array('#'=>$i++,
		// 		'type'=>$rs['stocktype'], 
		// 					 'product'=>$rs['productname'], 
		// 					 'batch'=>'-', 
		// 					 'expiry'=>'-', 
		// 					 'Supplier'=> '-',
		// 					 'avail'=>'0',
		// 					  'maxqty'=>$rs['maxqty'], 
		// 					 'shelf'=>$rs['shelf'], 
		// 					 'rack'=>$rs['rack'],
		// 					 'mrp'=>$rs['mrp'],
		// 					 'alrt'=>'1');
		// 		array_push($data, $x);
		// }
	}
    $results = array(
            "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
          "aaData"=>$data);
echo json_encode($results);
?>