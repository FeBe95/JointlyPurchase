<?php
    session_start();
    include "../Php/Authentification/SessionChecker.php";
	include "../Php/Misc/GetYourData.php";
?>

<!DOCTYPE html>

<html lang="en">
    <head>
		<title>Home</title>
		
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
		
		<script>
			$(function() {
				$( "#Accordion1" ).accordion({
					heightStyle:"content",
					active: 0,
					collapsible:true
				}); 
				$( "#Accordion2" ).accordion({
					heightStyle:"content",
					active: 0,
					collapsible:true
				});
			});
			
			function send(ak,id,id2){
				if (ak==1){
					if (confirm("Möchtest du diesen Auftrag abbrechen?")){
						document.shoppinglistDecline.itemId.value = id;
						document.shoppinglistDecline.listId.value = id2;		
						document.shoppinglistDecline.submit();
					}
					else{
						return;
					}
				}
				if (ak==2){
					document.shoppinglistAccept.itemId.value = id;
					document.shoppinglistAccept.listId.value = id2;
					document.shoppinglistAccept.submit();
				}
			}
			
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
    </head>
    <body>
        <?php include "../Templates/HeadTemplate.php"; ?>
		
		<!--
		<canvas id="bgCanvas" width="1000" Style="opacity:0.1;position:fixed; top:0px; left:0px;z-index:1;"></canvas>
		<script>
			var color = new Array("48DD00","52A529","2F8F00","75EE3B","95EE6B");
		</script>
		<script src="../js/bg.js"></script>
		-->
		
		<div id="mainwindow" style="top:-56px;">
			<table id="streamsTable">
				<tr>
					<td>
						<div id="middle_top">
							<form action="../Php/Shoppinglist/AddShoppinglist.php" method="post">
								<p style='padding:4px;'>
									Möchtest Du eine neue Einkaufsliste hinzufügen? &nbsp; Name:
									<input name="list" type="text" maxlenght="10" required/>
									<button type="submit">Los geht's</button>
								</p>
								<?php
									if(isset($_GET["f"]) && isset($_GET["n"]) && $_GET["f"] == "error"){
										echo "<p class='listen-error'>Die Einkaufsliste '".$_GET["n"]."' besteht bereits. Bitte wähle einen anderen Namen.";
									}
								?>
							</form>
						</div>
					</td>
					<td style="text-align: center;">
						<!--Leute aus Deiner Nähe:-->
					</td>
				</tr>
				<tr>
					<td style="vertical-align:top;" rowspan="2">
						<div id="myStream" style="margin-top: 35px;">
							<p class="stream-header">Deine Einkaufslisten:</p>
							<?php include "../Php/ShoppinglistStream/MyStream.php"; ?>
						</div>
						<br/>
						<div id="friendsStream">
							<p class="stream-header">Die Einkaufslisten Deiner Freunde:</p>
							<?php include "../Php/ShoppinglistStream/Stream.php"; ?>
						</div>
					</td>
					<td id="friendsBrowser">
						<?php include "../Php/SocialNetwork/FriendBrowser.php"; ?>
					</td>
				</tr>
                <tr style="height:300px;">
					<td style="display:block; margin-top:20px;">
						<div style="background:#c4c4c4;border-radius:5px;text-align:center;line-height:240px;width:200px;">Werbung</div>
					</td>
                </tr>
			</table>
			
			<form id="hidden" name="hidden" method="post" action="Home.php">
				<input name='ak' type='hidden' />
				<input name='id' type='hidden' />
			</form>
			<form id="hidden2" name="hidden2" method="post" action="ShoppinglistEditor.php">
				<input name='ak' type='hidden' />
				<input name='list' type='hidden' />
			</form>
		</div>
		<?php include "../Templates/FooterTemplate.php"; ?>
    </body>
</html>