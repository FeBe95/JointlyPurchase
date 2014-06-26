<?php

    session_start();
    $user= $_COOKIE["jpusr"];
    $pw = $_COOKIE["jppw"];
    if (isset($user))
    {
        if ($user || $pw !=='')
        {
		include "../../Templates/MYSQLConnectionString.php";
        $query="SELECT ID, passwort, vorname FROM user WHERE email = '$user' ";
        $res= mysqli_query($conUser,$query);
        $dsatz=mysqli_fetch_assoc($res);
        $name=$dsatz["vorname"];
		$ID=$dsatz["ID"];

	     if($pw !== $dsatz["passwort"])
            {
              header( 'Location: ../../Pages/LoginError.php') ;
            }
            else
            {
				setcookie("jpusr", $user, time()+3600*100, '/', false );
				setcookie("jppw", $pw, time()+3600*100, '/', false );
				$_SESSION["login"] = $ID;
                header( 'Location: ../../Pages/Home.php' ) ;                   
            }
        }
    }
        else
        {
           // header( 'Location: ../view/relogin.php' ) ;
        }
        include "SessionChecker.php";
		mysqli_close($conUser);
?>

