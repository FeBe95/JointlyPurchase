<?php
    session_start();
	$user = $_POST["Email"];
	$pw = md5($_POST["Pw"]);
	$redirect = $_POST["redirect"];
	if($redirect == ""){$redirect = "../../Pages/Home.php";}
	
    if ($user !='' && $pw !=''){
		include "../../Templates/MYSQLConnectionString.php";
		$stmt = mysqli_stmt_init($conUser);
		If (mysqli_stmt_prepare($stmt, 'SELECT ID, passwort, vorname FROM user WHERE email = ?')){
			
			mysqli_stmt_bind_param($stmt,'s', $_POST['Email']);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $ID, $password, $vorname);
			mysqli_stmt_fetch($stmt);
			If ( md5($_POST["Pw"]) != $password){
				header( "Location: ../../Pages/LoginError.php?$redirect" ) ;
			}
			elseif(isset($_POST["stayLogIn"])){
				setcookie("jpusr", $_POST['Email'], time()+3600*100, '/', false );
				setcookie("jppw", $password, time()+3600*100, '/', false );
				$_SESSION["login"] = $ID;
				header( "Location: $redirect" );
			}
			else{
				$_SESSION["login"] = $ID;
				header( "Location: $redirect" );	
			}
			mysqli_stmt_close($stmt);
		}
		mysqli_close($conUser);
	}
	else{
		header( "Location: ../../Pages/LoginError.php?$redirect" );
	}
?>

