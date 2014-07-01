<?php
	session_start();
	include "../Misc/GetYourData.php";
	include "../../Templates/MYSQLConnectionString.php";
	
	$table = $_POST['list'] ;
	$listID = md5($table.$ID);
	
	date_default_timezone_set('Europe/Berlin');
	$timestamp = time();
	$datum = date("d.m.Y",$timestamp);
	$uhrzeit = date("H:i",$timestamp);
	$date = "".$datum." - ".$uhrzeit."";

	$abf1 = mysqli_query($conUser,"SELECT * FROM einkaufslisten WHERE listName = '".$table."'&& userID = ".$ID."");
	$abf4 = "INSERT einkaufslisten (userID,listName,listID) values ('".$ID."','".$table."','".$listID."')";
	//$abf6 = "SELECT listID FROM einkaufslisten WHERE userID = ".$ID."";
	$abf8 = "UPDATE einkaufslisten SET date='".$date."' WHERE listID ='".$listID."'";
	
	if(mysqli_num_rows($abf1)== 0 && $_POST['list'] != ""){
		if (!(empty($_POST["list"]))){
			$_SESSION["list"] = $_POST["list"];
			mysqli_query($conUser,$abf4);
			mysqli_query($conUser,$abf8);
		}
		header( 'Location: ../../Pages/ShoppinglistEditor.php' ) ; 
	}
	elseif($_POST['list'] != ""){
		header( 'Location: ../../Pages/Home.php?f=error&n='.$table);
	}
	mysqli_close($conUser);
?>