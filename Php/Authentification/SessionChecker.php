<?php
    if (!isset($_SESSION["login"])){
	    if(isset($_GET['la'])){
          header( "Location: ../../Pages/LoginError.php?redirect=http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");		
		}
		else{
          header( "Location: ../Pages/LoginError.php?redirect=http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");	
		}
    }    
?>
