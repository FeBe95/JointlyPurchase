<?php
    session_start();
    session_destroy();
    $_SESSION = array();
	if (isset($_COOKIE["jpusr"])){
	  header('Location:../Php/Authentification/StayLogin.php');
	}
?>

	<!DOCTYPE html>

<html lang="en">
    <head>
        <title>JointlyPurchase</title>
		
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/CSS" href="../css/style_login.css">
		
		<link href='http://fonts.googleapis.com/css?family=Lobster|Poiret+One' rel='stylesheet' type='text/css'>
    </head>
    <body>
		<?php include "../Templates/LoginHeadTemplate.php"; ?>
        <div id="main">
            <h1>Join Now</h1>
            <div id="mainbuttonscontainer">
                <a class="mainbuttons" href="ErfahreMehr.php">Erfahre mehr</a>
                <a class="mainbuttons" href="NewAccount.php">Registrieren</a>
            </div>
        </div>
     
		<div id="footer-border"></div>
		
		<footer id="site-footer" class="login">
			<div id="wrap">
				<p id="site-credits">Made with <span>&hearts;</span> in Burgholzhausen, DE. Copyright 2014</p>
			</div>
		</footer>
	
		<div id="image"></div>
    </body>
</html>