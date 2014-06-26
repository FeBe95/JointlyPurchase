<?php

    session_start();
    $user= $_POST["Email"];
    $pw = md5($_POST["Pw"]);
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
            elseif(isset($_POST["stayLogIn"]))
            {
				setcookie("jpusr", $user, time()+3600*100, '/', false );
				setcookie("jppw", $pw, time()+3600*100, '/', false );
				$_SESSION["login"] = $ID;
                header( 'Location: ../../Pages/Home.php' ) ;                   
            }else{
				$_SESSION["login"] = $ID;
                header( 'Location: ../../Pages/Home.php' ) ;  
			}
        }
    }
        else
        {
           // header( 'Location: ../view/relogin.php' ) ;
        }
        include "SessionChecker.php?la";
		mysqli_close($conUser);
?>

