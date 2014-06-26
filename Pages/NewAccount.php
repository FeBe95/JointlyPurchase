<?php
    session_start();
    session_destroy();
    $_SESSION = array();
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <title>Registrieren</title>
		
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/CSS" href="../css/style_login.css">
		
		<link href='http://fonts.googleapis.com/css?family=Lobster|Poiret+One' rel='stylesheet' type='text/css'>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		
		<script>
			$(document).ready(function() {
				//$("#Pw2").keyup(validate);
				$("#send").click(pwcheck);
			});
			
			
			function validate() {
				var password1 = $("#Pw").val();
				var password2 = $("#Pw2").val();
			
				if(password1 == password2) {
					document.getElementById("status").src="../Pictures/SiteContent/tick.svg";        
				}
				else {
					document.getElementById("status").src="../Pictures/SiteContent/cross.svg";  
				}
			}
			
			function pwcheck() {
				var password3 = $("#Pw").val();
				var password4 = $("#Pw2").val();
				if(password3 == password4) {
					$("#hidden").click();        
				}
				else {
					$(".formError").text("Deine Passwörter stimmen nicht überein"); 
					$(".formError").show(); 
				}
			}
			
			function isNumberKey(evt){	
				var charCode = (evt.which) ? evt.which : event.keyCode
				if (charCode > 31 && (charCode < 48 || charCode > 57)){
					return false;
				}
				else{
					return true;
				}
			}
		</script>
    </head>
    <body>
        <?php 
            include "../Templates/LoginHeadTemplate.php"
        ?>
        <div id="mainReg">
            <div id="greybox">
				<?php
					if(isset($_REQUEST["n"]) && $_REQUEST["v"] && isset($_REQUEST["em"]) && isset($_REQUEST["e"])){
					$n=$_REQUEST["n"];
					$v=$_REQUEST["v"];
					$em=$_REQUEST["em"];
					$e=$_REQUEST["e"];
						if ($e === "1")
						{
							echo "<p class='formError'>Es existiert bereits ein Konto mit dieser E-mail Adresse. Bitte melde dich an oder versuche es mit einer anderen E-mail Adresse.</p>";
						}
					}else{
						$n = null;
						$v = null;
						$em = null;
						$e = null;
					}
				?>
				
            	<p style="display:none;" class='formError'></p>	
                <p>Bitte registriere dich mit deinen korrekten Angaben.</p></br>
                <div id="regbox">
                    <form id="reg" action="../Php/Authentification/Registration.php"  method="post">
						<p>Vorname<input name="Vname" type="text" maxlength="20"autofocus required value="<?php echo $v ?>"/></p>
						<p>Nachname<input name="Name" type="text" maxlength="20" required value="<?php echo $n ?>"/></p>
						<p>Plz.<input type="text" name="Plz" onkeypress="return isNumberKey(event)" maxlength="5" value="<?php //echo $plz ?>"/></p>
						<p>Email<input name="Email" type="email" maxlength="50" required value="<?php echo $em ?>"/></p>
						<p>Passwort<input  name ="Pw" id="Pw" type="password" maxlength="20" required/></p>
						<p>Passwort wiederholen<input id="Pw2" type="password" maxlength="20" required/><img style="height:12px;float:right;"id="status"></p></br>
                        
						<button id="send" href="#">Registrieren</button>
                        <button id="hidden" hidden="true"></button>
                        
                        <button type="button" onclick="window.location.href='../index.php'">Abbrechen</button>                  
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
