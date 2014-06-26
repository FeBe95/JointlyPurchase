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
  
$query="SELECT passwort FROM user WHERE email = '$Uemail' ";
$res= mysqli_query($conUser,$query);
$dsatz=mysqli_fetch_assoc($res);
$pw=$dsatz["passwort"];

	if($aPW != "" && $nPW != "" && $nPWw != ""){
		if($nPW == $nPWw){
			if(md5($aPW) == $pw){
			    mysqli_query($conUser,"UPDATE user SET name='".$Uname."', vorname='".$Uvname."', email='".$Uemail."', plz='".$Uplz."', passwort='".md5($_POST['neuesPW'])."' WHERE ID=".$ID);
				header( 'Location: ../../Pages/ProfilSettings.php?successPW' );
			}
			else{
				mysqli_query($conUser,"UPDATE user SET name='".$Uname."', vorname='".$Uvname."', email='".$Uemail."', plz='".$Uplz."' WHERE ID=".$ID);
				header( 'Location: ../../Pages/ProfilSettings.php?wrongPW' );
			}
		}
		else{
			mysqli_query($conUser,"UPDATE user SET name='".$Uname."', vorname='".$Uvname."', email='".$Uemail."', plz='".$Uplz."' WHERE ID=".$ID);
			header( 'Location: ../../Pages/ProfilSettings.php?PWmismatch' );
		}
	}
	else{
		mysqli_query($conUser,"UPDATE user SET name='".$Uname."', vorname='".$Uvname."', email='".$Uemail."', plz='".$Uplz."' WHERE ID=".$ID);
		header( 'Location: ../../Pages/ProfilSettings.php?success' );
	}
  
  
mysqli_close($conUser);
?>