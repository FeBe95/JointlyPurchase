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
	$stmt = mysqli_stmt_init($conUser);
	$i = 0;
	If (mysqli_stmt_prepare($stmt, 'SELECT * FROM einkaufslisten WHERE listName = (?) && userID = (?)')){
		mysqli_stmt_bind_param($stmt,'si', $_POST['list'], $ID);
		mysqli_stmt_execute($stmt);
		while (mysqli_stmt_fetch($stmt)){
		$i++;
		}
	}
	mysqli_stmt_close($stmt);

	//$abf1 = mysqli_query($conUser,"SELECT * FROM einkaufslisten WHERE listName = '".$table."'&& userID = ".$ID."");
	//$abf4 = "INSERT einkaufslisten (userID,listName,listID) values ('".$ID."','".$table."','".$listID."')";
	//$abf6 = "SELECT listID FROM einkaufslisten WHERE userID = ".$ID."";
	$abf8 = "UPDATE einkaufslisten SET date='".$date."' WHERE listID ='".$listID."'";
	
	if($i == 0 && $_POST['list'] != ""){
		if (!(empty($_POST["list"]))){
			$_SESSION["list"] = $_POST["list"];
			$stmt = mysqli_stmt_init($conUser);
			If (mysqli_stmt_prepare($stmt, 'INSERT einkaufslisten (userID,listName,listID) values ((?),(?),(?))')){
				mysqli_stmt_bind_param($stmt,'iss', $ID, $_POST['list'], md5($table.$ID) );
				mysqli_stmt_execute($stmt);
			}
			mysqli_stmt_close($stmt);
			$stmt = mysqli_stmt_init($conUser);
			If (mysqli_stmt_prepare($stmt, 'UPDATE einkaufslisten SET date=(?) WHERE listID =(?)')){
				mysqli_stmt_bind_param($stmt,'ii', $date, md5($table.$ID));
				mysqli_stmt_execute($stmt);
			}
			mysqli_stmt_close($stmt);
			//mysqli_query($conUser,$abf8);
		}
		header( 'Location: ../../Pages/ShoppinglistEditor.php' ) ; 
	}
	elseif($_POST['list'] != ""){
		header( 'Location: ../../Pages/Home.php?f=error&n='.$table);
	}
	mysqli_close($conUser);
?>