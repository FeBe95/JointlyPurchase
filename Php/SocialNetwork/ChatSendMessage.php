<?php
	session_start();
	include "../../Templates/MYSQLConnectionString.php";
	
	$ID = $_POST['UserID1'];
	$ID2 = $_POST['UserID2'];
	
	if(isset($_POST['message'])){
		$message = htmlspecialchars($_POST['message']);
	
		$timestamp = time();
		$datum = date("d.m.Y",$timestamp);
		$uhrzeit = date("H:i",$timestamp);
		$date = "".$datum." - ".$uhrzeit."";
		if ($message != ""){
			mysqli_query($conUser,"INSERT INTO messages (UserId1,UserId2,nachricht,date) values ('$ID','$ID2',\"$message\",'$date')");	
			//mysqli_query($conUser,"INSERT INTO shoppingnotifications (UserId1,UserId2,product_id,status,date) values ('$ID','$ID2','','2','$date')");	
		}
	}
	mysqli_close($conUser);
	
	//header( "Location: ../../Pages/Chat.php?a=$ID2"); //Nötig, wenn über Form gesendet
?>
