<?php
    if (!isset($_SESSION["login"])){
	    if(isset($_GET['la'])){
          header( 'Location: ../../Pages/LoginError.php' );		
		}
		else{
          header( 'Location: ../Pages/LoginError.php' );
		}
    }    
?>
