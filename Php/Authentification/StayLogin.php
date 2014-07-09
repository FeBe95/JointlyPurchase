<?php

    session_start();
    $user= $_COOKIE["jpusr"];
    $pw = $_COOKIE["jppw"];
    if (isset($user))
    {
        if ($user || $pw !=''){
			include "../../Templates/MYSQLConnectionString.php";
			$stmt = mysqli_stmt_init($conUser);
			If (mysqli_stmt_prepare($stmt, 'SELECT ID, passwort, vorname FROM user WHERE email = ?')){
				mysqli_stmt_bind_param($stmt,'s', $_COOKIE["jpusr"]);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $ID, $password, $vorname);
				mysqli_stmt_fetch($stmt);

				if($_COOKIE["jppw"] !== $password){
					header( 'Location: ../../Pages/LoginError.php') ;
				}
				else{
					setcookie("jpusr", $_COOKIE["jpusr"], time()+3600*100, '/', false );
					setcookie("jppw", $_COOKIE["jppw"], time()+3600*100, '/', false );
					$_SESSION["login"] = $ID;
					header( 'Location: ../../Pages/Home.php' ) ;                   
				}
			}
			mysqli_stmt_close($stmt);
		}
	}
	include "SessionChecker.php";
	mysqli_close($conUser);
?>

