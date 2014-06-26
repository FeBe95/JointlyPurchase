<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/CSS" href="../css/style_login.css">
        <title>Login</title>
		<link href='http://fonts.googleapis.com/css?family=Lobster|Poiret+One' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <?php 
            include "../Templates/LoginHeadTemplate.php"
        ?>
        <div id="main">
            <div id="greybox">
                <p class="alert">Ups... Da ist wohl etwas schief gelaufen. Bitte versuch es nochmal.</p>
                <div id="regbox">
                    <form action="../Php/Authentification/Login.php"  method="post">
                       <p>E-Mail<input name="Email" type="email" maxlength="50"/></p>
                       <p>Passwort<input name="Pw" type="password" maxlength="20"/></p></br>
                        <button name="send" type="submit" value="send">
                        Login
                        </button>
                        <button type="button" onclick="window.location.href='../index.php'" value="">
                        Abbrechen
                        </button>
                        <button type="button" onclick="window.location.href='NewAccount.php'" value="">
                        Registrieren
                        </button>
                    </form>
                </div>
            </div>
        </div>
		
        <div id="footer-border"> 
		</div>
		
		<footer id="site-footer">
			<div id="wrap">  
				<p id="site-credits">Made with <span>&hearts;</span> in Burgholzhausen, DE. Copyright 2014</p>
			</div>
		</footer>
		
		<div id="image"></div>
    </body>
</html>
