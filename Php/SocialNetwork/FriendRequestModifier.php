<?php
	session_start();
	include "../Misc/GetYourData.php";
	include "../../Templates/MYSQLConnectionString.php";
	
	$friendID=$_POST['id'];
	$change=$_POST['change'];
	
	// Check connection
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	date_default_timezone_set('Europe/Berlin');
	$timestamp = time();
	$datum = date("d.m.Y",$timestamp);
	$uhrzeit = date("H:i",$timestamp);
	$date = "".$datum." - ".$uhrzeit."";
	
	if ($change == "accept"){
		mysqli_query($conUser,"UPDATE FriendRelation SET AreFriends='2' WHERE UserId1=".$friendID." && UserId2=".$ID."");
		mysqli_query($conUser,"INSERT INTO shoppingnotifications (UserId1,UserId2,product_id,status,date) values ('$ID','$friendID','','3','$date')");	
	}
	else{
		mysqli_query($conUser,"DELETE FROM FriendRelation WHERE UserId1=".$friendID." && UserId2=".$ID."");
	}
	header( 'Location:'.$_SERVER["HTTP_REFERER"].'' );
	mysqli_close($conUser);
?>
