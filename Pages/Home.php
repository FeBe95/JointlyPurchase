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
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script src="../js/FormValidation.js"></script>
		<script src="../js/BoogyBox.js"></script>
		
		<script>
			var msg_1 = 'Fehler:';
		
			var var_1 = new Array()
			var_1[0] = new Array('list','c','','');
			
			function slnCheck(Input){
				alert(Input);
			}
			
			function send(ak,id,id2){
				if (ak==1)
				{
					if (confirm("Möchtest du diesen Auftrag abbrechen?"))
						{
						document.shoppinglistDecline.itemId.value = id;			
						document.shoppinglistDecline.listId.value = id2;			
						document.shoppinglistDecline.submit();	
						}
						else{
						return;
						}
				}
				if (ak==2)
				{
					
					document.shoppinglistAccept.itemId.value = id;
					document.shoppinglistAccept.listId.value = id2;
					document.shoppinglistAccept.submit();
					
				}
			}
		</script>
    </head>
    <body>
        <?php 
            include "../Templates/HeadTemplate.php"
        ?>
		
		
		<!--
		<canvas id="bgCanvas" width="1000" Style="opacity:0.3;position:fixed; top:0px; left:0px;z-index:1;"></canvas>
		<script>
			var color = new Array("48DD00","52A529","2F8F00","75EE3B","95EE6B");
		</script>
		<script src="../js/bg.js"></script>
		-->
		
		
		<div id="mainwindow" style="top:-56px;">
			<table>
				<tr>
					<td>
						<div id="middle_top">
							<form action="../Php/Shoppinglist/AddShoppinglist.php" method="post">
								<?php
									if(isset($_REQUEST["f"])&&isset($_REQUEST["n"])){
									$f=$_REQUEST["f"];
									$n=$_REQUEST["n"];
										if ($f == "error"){
											echo "<p style='padding:4px;background-color:#f55;'>Die Einkaufsliste '".$n."' besteht bereits. Bitte wähle einen anderen Namen.";
										}
									}
									else{
										echo "<p style='padding:4px;'> Möchtest Du eine neue Einkaufsliste hinzufügen? &nbsp; Name:";
									}
								?>
							
									<input name="list" type="text" maxlenght="10" required/>
									<button type="submit">Los geht's</button>
								</p>
							</form>
						</div>
					</td>
					<td>
						Leute aus Deiner Nähe:
					</td>
				</tr>
				<tr>
					<td rowspan="2">
						<div style="margin-left: 20px;">
							<?php
								include "../Templates/MYSQLConnectionString.php";
								$profilPic= mysqli_query($conUser,"SELECT profilPic FROM user WHERE email = '".$email."'");
								$profilPic = mysqli_fetch_assoc($profilPic);
								echo "<br/><p>Deine Einkaufslisten:</p><a href=\"../Pages/Profil.php?a=".$ID."\">Zur Übersicht</a>";
							?>
						</div>
						<br/>
                        <div id="socialArea">
							<?php include "../Php/ShoppinglistStream/Stream.php"; ?>
                        </div>
					</td>
					<td style="vertical-align:top;">
						<?php
						include "../Php/SocialNetwork/FriendBrowser.php";
						?>
					</td>
				</tr>
                <tr style="height:300px;">
					<td style="border-left: 2px solid gray;vertical-align:bottom; margin-top:0px;">
						<div style="background:#faa;display:table-cell;outline:1px solid black;vertical-align:middle;text-align:center;height:300px;">Hier könnte Ihre Werbung stehen</div>
					</td>
                </tr>
			</table>
		</div>
    </body>
</html>