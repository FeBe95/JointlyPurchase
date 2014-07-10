<?php
    session_start();
    session_destroy();
    $_SESSION = array();
	if (isset($_COOKIE["jpusr"])){
	  header('Location:Php/Authentification/StayLogin.php');
	}
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <title>JointlyPurchase</title>
		
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/CSS" href="css/style_login.css">
		
		<link href='http://fonts.googleapis.com/css?family=Lobster|Poiret+One' rel='stylesheet' type='text/css'>
    </head>
    <body>
		<!-- nicht das Login-Template benutzen, da falsche Pfade -->
		<div id="head">
			<div id="headcontent">
				<div id="logo">
					<img src="Pictures/SiteContent/logo_klein_beta.png" width="250px"/>
				</div>
				<div id="headbuttons">
					<form action="Php/Authentification/Login.php" method="post">
						<table>
							<tr>
								<td>
									<p class="headfont">Email:<input name="Email" type="email" maxlength="50" autofocus required/></p>
								</td>
								<td>
									<p class="headfont">Passwort:<input name="Pw" type="password" maxlength="20" required/></p>
								</td>
								<td>
									<button name="send" type="submit" value="send">Login</button>
								</td>
							</tr>
							<tr>
								<td>
								</td>
								<td>
									<p class="headfont newbg" style="font-size:12px;float:right;">Angemeldet bleiben<input type="checkbox" name="stayLogIn" value="true"/></p> 
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>

        <div id="main">
            <h1>Join Now</h1>
            <div id="mainbuttonscontainer">
                <a class="mainbuttons" href="Pages/ErfahreMehr.php">Erfahre mehr</a>
                <a class="mainbuttons" href="Pages/NewAccount.php">Registrieren</a>
            </div>
        </div>
     
		<div id="footer-border"></div>
		
		<footer id="site-footer" class="login">
			<div id="wrap">
				<p id="site-credits">Made with <span>&hearts;</span> in Burgholzhausen, DE. Copyright 2014</p>
			</div>
		</footer>
	
		<div id="login_image"></div>
    </body>
</html>
