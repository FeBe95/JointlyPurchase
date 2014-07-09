<?php
session_start();
include "../Misc/GetYourData.php";
include "../../Templates/MYSQLConnectionString.php";

$Uvname=$_POST['UserVorName'];
$Uname=$_POST['UserNachName'];
$Uemail=$_POST['UserEmail'];
$Uplz=$_POST['UserPLZ'];
$aPW=$_POST['altesPW'];
$nPW=$_POST['neuesPW'];
$nPWw=$_POST['neuesPWwiederholen'];

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  
$stmt = mysqli_stmt_init($conUser);
		If (mysqli_stmt_prepare($stmt, 'SELECT passwort FROM user WHERE email = (?)')){
			mysqli_stmt_bind_param($stmt,'s', $_POST['UserEmail']);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $passwort);
			mysqli_stmt_fetch($stmt);
		}
	mysqli_stmt_close($stmt);

	if($_POST['altesPW'] != "" && $_POST['neuesPW'] != "" && $_POST['neuesPWwiederholen'] != ""){
		if($_POST['neuesPW'] == $nPWw){
			if(md5($aPW) == $passwort){
			$stmt = mysqli_stmt_init($conUser);
			If (mysqli_stmt_prepare($stmt, 'UPDATE user SET name= (?), vorname= (?), email= (?), plz= (?), passwort= (?) WHERE ID= (?)')){
				mysqli_stmt_bind_param($stmt,'ssssisi', $_POST['UserNachName'],  $_POST['UserVorName'], $_POST['UserEmail'], $_POST['UserPLZ'], md5($_POST['neuesPW'], $ID));
				mysqli_stmt_execute($stmt);
			}
			mysqli_stmt_close($stmt);
			header( 'Location: ../../Pages/ProfilSettings.php?successPW' );
			}
			else{
				$stmt = mysqli_stmt_init($conUser);
				If (mysqli_stmt_prepare($stmt, 'UPDATE user SET name= (?), vorname= (?), email= (?), plz= (?) WHERE ID= (?)')){
					mysqli_stmt_bind_param($stmt,'sssii', $_POST['UserNachName'],  $_POST['UserVorName'], $_POST['UserEmail'], $_POST['UserPLZ'], $ID);
					mysqli_stmt_execute($stmt);
				}
				header( 'Location: ../../Pages/ProfilSettings.php?wrongPW' );
			}
		}
		else{
			$stmt = mysqli_stmt_init($conUser);
				If (mysqli_stmt_prepare($stmt, 'UPDATE user SET name= (?), vorname= (?), email= (?), plz= (?) WHERE ID= (?)')){
					mysqli_stmt_bind_param($stmt,'sssii', $_POST['UserNachName'],  $_POST['UserVorName'], $_POST['UserEmail'], $_POST['UserPLZ'], $ID);
					mysqli_stmt_execute($stmt);
				}
				mysqli_stmt_close($stmt);
			header( 'Location: ../../Pages/ProfilSettings.php?PWmismatch' );
		}
	}
	else{
		$stmt = mysqli_stmt_init($conUser);
				If (mysqli_stmt_prepare($stmt, 'UPDATE user SET name= (?), vorname= (?), email= (?), plz= (?) WHERE ID= (?)')){
					mysqli_stmt_bind_param($stmt,'sssii', $_POST['UserNachName'],  $_POST['UserVorName'], $_POST['UserEmail'], $_POST['UserPLZ'], $ID);
					mysqli_stmt_execute($stmt);
				}
		mysqli_stmt_close($stmt);
		header( 'Location: ../../Pages/ProfilSettings.php?success' );
	}
  
  
mysqli_close($conUser);
?>