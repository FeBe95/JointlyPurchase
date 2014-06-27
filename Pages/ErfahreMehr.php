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
    </head>
    <body>
        <?php 
            include "../Templates/LoginHeadTemplate.php"
        ?>
		<div id="container">
			<div id="section1">
				<div id="content1">
					<div class="learnMoreTitelBox" id="first">
						<h2>Das ist unser Ziel</h2>
						<p>BlaBlaBla BlaBlaBla BlaBlaBla</p>
						<p>Noch mehr BlaBlaBla BlaBlaBla BlaBlaBla</p>
						<p>Nicht zu vergessen ist BlaBlaBla BlaBlaBla BlaBlaBla</p>
					</div>
					<img style="width:400px;display:inline;" src="../Pictures/SiteContent/Spokesman_Character_Big.png">
				</div>
			</div>
			<div id="section2" style="background-color:#B3C833;">
				<div id="content2">
						<img style="width:400px;display:inline;" src="../Pictures/SiteContent/Caveman_Character.png">
					<div class="learnMoreTitelBox" id="second">
						<h2>Das ist unser Ziel</h2>
						<p>BlaBlaBla BlaBlaBla BlaBlaBla</p>
						<p>Noch mehr BlaBlaBla BlaBlaBla BlaBlaBla</p>
						<p>Nicht zu vergessen ist BlaBlaBla BlaBlaBla BlaBlaBla</p>
					</div>
				</div>
			</div>
		</div>
		<footer id="site-footer">
			<div id="wrap">  
				<p id="site-credits">Made with <span>&hearts;</span> in Burgholzhausen, DE. Copyright 2014</p>
			</div>
		</footer>
		
		<div id="image"></div>
    </body>
</html>
