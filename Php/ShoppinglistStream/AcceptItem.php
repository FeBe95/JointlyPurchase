<?php
	session_start();
	include "../Misc/GetYourData.php";
	include "../../Templates/MYSQLConnectionString.php";
	
	$ItemID=$_POST['itemId'];
	$ListID=$_POST['listId'];
	
	// Check connection
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	date_default_timezone_set('Europe/Berlin');
	$timestamp = time();
	$datum = date("d.m.Y",$timestamp);
	$uhrzeit = date("H:i",$timestamp);
	$date = "".$datum." - ".$uhrzeit."";
	
	$res = mysqli_query($conUser,"SELECT einkaufslisten.userID,user.ID,user.name,user.vorname FROM einkaufslisten JOIN user WHERE user.ID=einkaufslisten.userID && einkaufslisten.listID='".$ListID."'");
	$result = mysqli_fetch_assoc($res);
	
	mysqli_query($conUser,"UPDATE produkte SET getFromUser=".$ID." WHERE item_id =".$ItemID."");
	mysqli_query($conUser,"INSERT Notifications (NotificationType,UserId1,UserId2,Notification,Status,date) values ('2','".$ID."','".$result[ID]."','".$ItemID."','0','".$date."')");
	header( 'Location: ../../Pages/Home.php' );
	mysqli_close($conUser);
?>