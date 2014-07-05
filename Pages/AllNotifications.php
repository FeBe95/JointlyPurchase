<?php
    session_start();
    include "../Php/Authentification/SessionChecker.php";
	include "../Php/Misc/GetYourData.php";
?>

<!DOCTYPE html> 

<html lang="en">
    <head>
		<title>Alle Benachrichtigungen</title>
		
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/CSS" href="../css/style.css">
		
        <link href="../css/jquery/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
        <link href="../css/jquery/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
		<link href="../css/jquery/jquery.ui.dialog.min.css" rel="stylesheet" type="text/css">
		<link href="../css/jquery/jquery.ui.resizable.min.css" rel="stylesheet" type="text/css">
        <link href="../css/jquery/jquery.ui.accordion.min.css" rel="stylesheet" type="text/css">
		
        <link href='http://fonts.googleapis.com/css?family=Special+Elite' rel='stylesheet' type='text/css'>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script src="../js/FormValidation.js"></script>
		<script src="../js/jquery/jquery-ui-1.9.2.dialog.custom.min.js"></script>
		<script src="../js/jquery/jquery-ui-1.9.2.accordion.custom.min.js"></script>
		
    </head>
    <body>
        <?php 
            include "../Templates/HeadTemplate.php";
        ?>
		<div id="mainwindow">
			<table cellpadding="10px" cellspacing="10px" style="margin:auto;width:80%;">
				<tr>
					<td class="contentBlock">
						<?php 
							include "../Php/SocialNetwork/GetAllNotifications.php";
						?>
					</td>
				</tr>
			</table>
		</div>
		<?php 
			 include "../Templates/FooterTemplate.php";
		?>
    </body>
</html>