<?php
	$path = $_SERVER['DOCUMENT_ROOT'];
	$path.= "/JointlyPurchase/Templates/MYSQLConnectionString.php";
	include $path;
	//$userID = $_SESSION['login'];
	$stmt = mysqli_stmt_init($conUser);
		If (mysqli_stmt_prepare($stmt, 'SELECT vorname, name, email, plz, ID FROM user WHERE ID = (?)')){
			
			mysqli_stmt_bind_param($stmt,'s', $_SESSION['login']);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $vorname, $nachname, $email, $plz, $ID);
			mysqli_stmt_fetch($stmt);
		}
	mysqli_stmt_close($stmt);
	mysqli_close($conUser);
?>