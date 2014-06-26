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
			<table cellpadding="10px" cellspacing="10px">
				<tr>
					<td class="contentBlock">
						<div id="main_left">
							<?php 
								include "../Templates/MYSQLConnectionString.php";
								$profilPic= mysqli_query($conUser,"SELECT profilPic FROM user WHERE email = '".$email_friend."'");
								$profilPic = mysqli_fetch_assoc($profilPic);
								echo "<div id='mainProfilPicCrop'><img id='mainProfilCrop' src = '../Pictures/Thumbnails/".$profilPic["profilPic"]."'></div>";
								echo "<div id='fullpiccontainer'><img id='fullpic' src = '../Pictures/ProfilPictures/".$profilPic["profilPic"]."'></div>";
							?> 
						</div>
					</td>
					<td class="contentBlock">
						<div id="main_center">
							<table>
								<?php 
									include "../Templates/MYSQLConnectionString.php";
									$relationStatus=mysqli_query($conUser,"SELECT AreFriends, UserId1, UserId2 FROM FriendRelation where UserId1 = ".$ID2." && UserId2 = ".$ID." OR UserId1 = ".$ID." && UserId2 = ".$ID2."");
									$check = mysqli_num_rows($relationStatus);
									$case = 0;
									If ($check > 0 )
									{
										$relation = mysqli_fetch_assoc($relationStatus);
										$case = $relation["AreFriends"];
									}
									If($ID2==$ID)
									{
										echo('<h1>Das bist du:<a href="../Pages/ProfilSettings.php"><img style="width:20px;margin-left:20px;" src="../Pictures/SiteContent/new.svg"></a></h1>');
									}elseif($check <= 0){
										echo("<form method='post' action='../Php/SocialNetwork/AddRelation.php'>");
										echo("<input name='friendID' type='hidden' value='".$ID2."'/>");
										echo("<button id='button' type='submit'>Als Freund hinzufügen</button>");
									}
									switch ($case) {
										case 1:
											if ($relation["UserId2"] == $ID)
											{
											echo("<form method='post' action='../Php/SocialNetwork/FriendRequestModifier.php'>");
											echo("<input name='change' type='hidden' value='accept'/>");
											echo("<input name='id' type='hidden' value='".$relation["UserId1"]."'/>");
											echo("<button id='button' type='submit'>Freundschaftsanfrage annehmen</button>");
											echo ("</form>");
											}else
											{
											echo "<p class='label'>Freundschaftsanfrage versendet</p>";
											}
											break;
										case 2:
											echo("<form method='post' action='../Php/SocialNetwork/DeleteRelation.php'>");
											echo("<input name='friendID' type='hidden' value='".$ID2."'/>");
											echo("<button id='button' type='submit'>Freund entfernen</button>");
											echo ("</form>");
										break;
										case 3:
											echo("<form method='post' action='../Php/SocialNetwork/AddRelation.php'>");
											echo("<input name='friendID' type='hidden' value='".$ID2."'/>");
											echo("<button id='button' type='submit'>Als Freund hinzufügen</button>");
											echo ("</form>");
										break;
									}
								?>
								<br/>
								<tr>
									<td>Name:</td>
									<td><?php echo $vorname_friend." ".$nachname_friend;?></td>
								</tr>
								<tr>
									<td><br/></td>
								</tr>
								<tr>
									<td>E-Mail:</td>
									<td><?php echo $email_friend;?></td>
								</tr>
									<td><br/></td>
								</tr>
								<tr>
									<td>Postleitzahl:</td>
									<td><?php echo $plz;?></td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
                <tr>
                	<td class="contentBlock">
                    	<?php 
						include"../Php/SocialNetwork/FriendList.php";
						include"../Php/SocialNetwork/PendingFriends.php";
                        include "../Templates/MYSQLConnectionString.php";
						?>
                    </td>
                    <td class="contentBlock">
                    	<?php if($ID2==$ID){echo"<h1>Deine Einkaufslisten:</h1>";}else{echo"<h1>Einkaufslisten von ".$vorname_friend.":</h1>";} 
                    	
						//Delete shoppinglist before loading List//
                        if(isset($_POST["ak"]) && $_POST["ak"]=="deleteList"){
                            $abf5 = "DELETE FROM produkte WHERE list_id = '".$_POST["id"]."'";
                            $abf7 = "DELETE FROM einkaufslisten WHERE listID = '".$_POST["id"]."'";
							mysqli_query($conUser,$abf5);
							mysqli_query($conUser,$abf7);
                        }
							
                        $abf2 = mysqli_query($conUser,"SELECT * FROM einkaufslisten WHERE userID = ".$ID2."");
						$num2 = mysqli_num_rows($abf2);
						
						if($num2!=0){
							?>
							
							<form style="width:672px;" action="../Php/Shoppinglist/AddShoppinglist.php" method="post">								
								<p>Name:
									<input name="list" type="text" maxlenght="10" required/>
									<button type="submit">Liste hinzufügen</button>
								</p>
							</form>
							
							<div id="Accordion1">
							
							<?php
							while ($listen = mysqli_fetch_assoc($abf2)){	
								$lId=$listen["listID"];
								echo "<h3><a href='#'>".$listen["listName"]."</a></a></h3>";
								echo "<div><table id='t1'>";
								if ($ID2 === $ID){
									echo "<a title='Einkaufsliste löschen' href='javascript:send(1,\"$lId\");'><img  style='margin:5px;padding: 5px 5px;border:0px;' class='del_Image' src='../Pictures/SiteContent/cross.svg'></a>";
									echo "<a title='Einkaufsliste bearbeiten' href='javascript:send(2,&quot;".$listen["listName"]."&quot;);'><img style='margin:5px;padding: 5px 5px;border:0px;' class='del_Image' src='../Pictures/SiteContent/new.svg'></a>";
								}
								
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
							?>
							Du hast noch keine Einkaufslisten.<br/><br/>
							Füge jetzt eine hinzu:
							<form style="width:672px;" action="../Php/Shoppinglist/AddShoppinglist.php" method="post">								
								Name:
								<input name="list" type="text" maxlenght="10" required/>
								<button type="submit">Erstellen</button>
							</form>
							<?php
						}
						
                        mysqli_close($conUser);
                        ?>
                        </div>
                    </td>
                </tr>
			</table>
      
			<form id="hidden" name="hidden" method="post" action="Profil.php?a=<?php echo $ID ?>">
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
			
			function send(ak,id){
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
