<?php
    session_start();
    include "../Php/Authentification/SessionChecker.php";
    include "../Php/Misc/GetYourData.php";
	include "../Php/Misc/GetFriendData.php";
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <title><?php echo $vorname_friend.' '.$nachname_friend; ?></title>
		
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/CSS" href="../css/style.css">
		
        <link href="../css/jquery/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
        <link href="../css/jquery/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
		<link href="../css/jquery/jquery.ui.dialog.min.css" rel="stylesheet" type="text/css">
		<link href="../css/jquery/jquery.ui.resizable.min.css" rel="stylesheet" type="text/css">
        <link href="../css/jquery/jquery.ui.accordion.min.css" rel="stylesheet" type="text/css">
		
        <link href='http://fonts.googleapis.com/css?family=Special+Elite' rel='stylesheet' type='text/css'>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script src="../js/BoogyBox.js"></script>
		<script src="../js/jquery/jquery-ui-1.9.2.dialog.custom.min.js"></script>
		<script src="../js/jquery/jquery-ui-1.9.2.accordion.custom.min.js"></script>
		
		<script>
			$(function() {
				$( "#fullpiccontainer" ).dialog({
					width:700,
					autoOpen:false,
					modal:true,
					resizable:false,
					draggable: false,
					title:"Profilbild"
				});
				
				$( "#mainProfilPicCrop" ).click(function() {
					$( "#fullpiccontainer" ).dialog( 'open' );
					$( ".ui-widget-overlay" ).click(function() {
						$( "#fullpiccontainer" ).dialog('close');
					});
				});
			});
		</script>
    </head>
    <body>
        <?php 
            include "../Templates/HeadTemplate.php";
        ?>
		<div id="mainwindow">
			
		</div>
		
		<script>
			$(function() {
				$( "#Accordion1" ).accordion({
					heightStyle:"content",
					active: false,
					collapsible:true
				}); 
			});
			$(function() {
				$( "#Accordion2" ).accordion({
					heightStyle:"content",
					active: false,
					collapsible:true
				}); 
			});
			
			function send2(ak,id){
				if (ak==1){
					if (confirm("Willst du die Einkaufsliste wirklich löschen?")){
						document.hidden.ak.value = "deleteList";
						document.hidden.id.value = id;
						document.hidden.submit();
					}
				}
				if (ak==2){
					document.hidden2.ak.value = "change";
					document.hidden2.list.value = id;
					document.hidden2.submit();
					
				}
			}
        </script>
    </body>
</html>
