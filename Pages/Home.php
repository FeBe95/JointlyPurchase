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
		<script src="../js/BoogyBox.js"></script>
		<script src="../js/jquery/jquery-ui-1.9.2.dialog.custom.min.js"></script>
		<script src="../js/jquery/jquery-ui-1.9.2.accordion.custom.min.js"></script>
		
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
						<div style="margin-left: 15px;">
							<?php
							/*
								include "../Templates/MYSQLConnectionString.php";
								$profilPic= mysqli_query($conUser,"SELECT profilPic FROM user WHERE email = '".$email."'");
								$profilPic = mysqli_fetch_assoc($profilPic);
								echo "<br/><p>Deine Einkaufslisten:</p><a href=\"../Pages/Profil.php?a=".$ID."\">Zur Übersicht</a>";
							*/
							?>
							
							<br/><p style="background-color: #c4c4c4; padding: 10px;width: 732px;">Deine Einkaufslisten:</p>
							
							<?php
							//Delete shoppinglist before loading List//
							include "../Templates/MYSQLConnectionString.php";
							
							if(isset($_POST["ak"]) && $_POST["ak"]=="deleteList"){
								$abf5 = "DELETE FROM produkte WHERE list_id = '".$_POST["id"]."'";
								$abf7 = "DELETE FROM einkaufslisten WHERE listID = '".$_POST["id"]."'";
								mysqli_query($conUser,$abf5);
								mysqli_query($conUser,$abf7);
							}
								
							$abf2 = mysqli_query($conUser,"SELECT * FROM einkaufslisten WHERE userID = ".$ID."");
							$num2 = mysqli_num_rows($abf2);
							
							if($num2!=0){
								?>
								
								<div id="Accordion1">
								
								<?php
								while ($listen = mysqli_fetch_assoc($abf2)){	
									$lId=$listen["listID"];
									echo "<h3><a href='#'>".$listen["listName"]."</a></a></h3>";
									echo "<div><table id='t1'>";
									echo "<a title='Einkaufsliste löschen' href='javascript:send2(1,\"$lId\");'><img  style='margin:5px;padding: 5px 5px;border:0px;' class='del_Image' src='../Pictures/SiteContent/cross.svg'></a>";
									echo "<a title='Einkaufsliste bearbeiten' href='javascript:send2(2,&quot;".$listen["listName"]."&quot;);'><img style='margin:5px;padding: 5px 5px;border:0px;' class='del_Image' src='../Pictures/SiteContent/new.svg'></a>";
									
									$abf1 = mysqli_query($conUser,"SELECT * FROM produkte WHERE list_id = '".$listen["listID"]."'");
									$num1 = mysqli_num_rows($abf1);
									$i=0;
									if($num1!=0){
										echo "<tr id='shoppinglist_header'><th>Produkt</th><th>Anzahl</th><th>Maximaler Preis</th><th>Anmerkung</th></tr>";
										while ($dsatz = mysqli_fetch_assoc($abf1)){
											if ($i==1){
												echo "<tr class='lightgray' id='shoppinglist_item_row'>";
												echo "<td class='product' id='shoppinglist_item'><p>" . $dsatz["product"] . "</p></td>";
												echo "<td class='amount' id='shoppinglist_item'><p>" . $dsatz["amount"] . "</p></td>";
												echo "<td class='maxPrice' id='shoppinglist_item'><p>" . $dsatz["maxPrice"] . "€</p></td>";
												echo nl2br("<td class='info' id='shoppinglist_item'><p>" . $dsatz["info"] . "</p></td>");
												echo "</tr>";
												$i--;
											}
											else{
												echo "<tr id='shoppinglist_item_row'>";
												echo "<td class='product' id='shoppinglist_item'><p>" . $dsatz["product"] . "</p></td>";
												echo "<td class='amount' id='shoppinglist_item'><p>" . $dsatz["amount"] . "</p></td>";
												echo "<td class='maxPrice' id='shoppinglist_item'><p>" . $dsatz["maxPrice"] . "€</p></td>";
												echo nl2br("<td class='info' id='shoppinglist_item'><p>" . $dsatz["info"] . "</p></td>");
												echo "</tr>";
												$i++;
											}
										}
									}
									else{
										echo "<tr><td><div style='margin-left:5px'>Noch keine Produkte eingetragen</div></td></tr>";
									}
									echo "</table></div>";
								}
							}
							else{
								echo "Du hast noch keine Einkaufslisten.<br/><br/>";
							}
							
							mysqli_close($conUser);
							?>
							</div>
							
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
			
			<form id="hidden" name="hidden" method="post" action="Home.php">
				<input name='ak' type='hidden' />
				<input name='id' type='hidden' />
			</form>
			<form id="hidden2" name="hidden2" method="post" action="ShoppinglistEditor.php">
				<input name='ak' type='hidden' />
				<input name='list' type='hidden' />
			</form>
		</div>
		
		<script>
			$(function() {
				$( "#Accordion1" ).accordion({
					heightStyle:"content",
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