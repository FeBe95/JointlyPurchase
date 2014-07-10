<?php
	$path = $_SERVER['DOCUMENT_ROOT'];
	$path.= "/JointlyPurchase/Templates/MYSQLConnectionString.php";
	include $path;
	//$userID = $_SESSION['login'];
	$stmt = mysqli_stmt_init($conUser);
		if(mysqli_stmt_prepare($stmt, 'SELECT ID, vorname, name, email, profilPic, plz FROM user WHERE ID = (?)')){
			mysqli_stmt_bind_param($stmt,'s', $_SESSION['login']);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $ID, $vorname, $nachname, $email, $profilPic, $plz );
			mysqli_stmt_fetch($stmt);
		}
	mysqli_stmt_close($stmt);
	mysqli_close($conUser);
?>