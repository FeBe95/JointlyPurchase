<?php
	session_start();
	include "../Misc/GetYourData.php";
	include "../../Templates/MYSQLConnectionString.php";
	
	//Variables//
	$info_br = wordwrap(@$_POST['info'], 40, "\n", true );
	//$row = mysqli_num_rows($abf1);
	$table = $_SESSION["list"];
	$listID = md5($table.$ID);
	
	date_default_timezone_set('Europe/Berlin');
	$timestamp = time();
	$datum = date("d.m.Y",$timestamp);
	$uhrzeit = date("H:i",$timestamp);
	$date = $datum." - ".$uhrzeit;

	//SQL_Querrys//
	$abf1 = "select * from produkte WHERE user_id = $ID";
	$abf2 = "INSERT produkte (product,amount,maxPrice,info,list_id) values ( (?), (?), (?), (?), (?)) ";	
	$abf3 = "DELETE FROM produkte where item_id = (?)";
	
	$abf5 = "DELETE FROM produkte WHERE list_id = (?)";
	
	$abf7 = "DELETE FROM einkaufslisten WHERE listID = (?)";
	$abf8 = "UPDATE einkaufslisten SET date= (?) WHERE listID =(?)";
	
	//Delete data in database//
	if(@$_POST["ak"]=="deleteItem"){
	$stmt = mysqli_stmt_init($conUser);
			If (mysqli_stmt_prepare($stmt,$abf3)){
				mysqli_stmt_bind_param($stmt,'i',@$_POST['id']);
				mysqli_stmt_execute($stmt);
			}
			mysqli_stmt_close($stmt);
			$stmt = mysqli_stmt_init($conUser);
			If (mysqli_stmt_prepare($stmt,$abf8)){
				mysqli_stmt_bind_param($stmt,'ss', $date, md5($table.$ID) );
				mysqli_stmt_execute($stmt);
			}
			mysqli_stmt_close($stmt);
		header( 'Location: ../../Pages/ShoppinglistEditor.php' );
	}
	
	//Delete shoppinglist//
	elseif(@$_POST["ak"]=="deleteList"){
	$stmt = mysqli_stmt_init($conUser);
			If (mysqli_stmt_prepare($stmt,$abf5)){
				mysqli_stmt_bind_param($stmt,'s', md5($table.$ID));
				mysqli_stmt_execute($stmt);
			}
			mysqli_stmt_close($stmt);
			$stmt = mysqli_stmt_init($conUser);
			If (mysqli_stmt_prepare($stmt,$abf7)){
				mysqli_stmt_bind_param($stmt,'s', md5($table.$ID) );
				mysqli_stmt_execute($stmt);
			}
			mysqli_stmt_close($stmt);
		header( 'Location: ../../Pages/Home.php' );
	}
							
	//Write data in database//
	elseif (@$_POST['product'] && $_POST['amount'] && $_POST['maxPrice'] != ''){
	$stmt = mysqli_stmt_init($conUser);
			If (mysqli_stmt_prepare($stmt,$abf2)){
				mysqli_stmt_bind_param($stmt,'sidss', $_POST['product'], $_POST['amount'], $_POST['maxPrice'], $info_br, md5($table.$ID));
				mysqli_stmt_execute($stmt);
			}
			mysqli_stmt_close($stmt);
			$stmt = mysqli_stmt_init($conUser);
			If (mysqli_stmt_prepare($stmt,$abf8)){
				mysqli_stmt_bind_param($stmt,'ss', $date, md5($table.$ID));
				mysqli_stmt_execute($stmt);
			}
			mysqli_stmt_close($stmt);
			header( 'Location: ../../Pages/ShoppinglistEditor.php' );
	}
		
	
	mysqli_close($conUser); 
	
?>