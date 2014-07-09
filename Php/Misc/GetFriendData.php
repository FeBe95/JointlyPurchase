<?php
	$ID2 = $_REQUEST['a'];
	include "../Templates/MYSQLConnectionString.php";
	$stmt = mysqli_stmt_init($conUser);
		If (mysqli_stmt_prepare($stmt, 'SELECT vorname, name, email, plz FROM user WHERE ID = (?)')){
			
			mysqli_stmt_bind_param($stmt,'s', $_REQUEST['a']);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $vorname_friend, $nachname_friend, $email_friend, $plz_friend);
			mysqli_stmt_fetch($stmt);
		}
	mysqli_stmt_close($stmt);
	mysqli_close($conUser);
?>