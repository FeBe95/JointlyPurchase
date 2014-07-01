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
			<table cellpadding="10px" cellspacing="10px" style="margin:auto;">
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
								<tr>
									<td>
										<?php 
											include "../Templates/MYSQLConnectionString.php";
											$relationStatus=mysqli_query($conUser,"SELECT AreFriends, UserId1, UserId2 FROM FriendRelation where UserId1 = ".$ID2." && UserId2 = ".$ID." OR UserId1 = ".$ID." && UserId2 = ".$ID2."");
											$check = mysqli_num_rows($relationStatus);
											$case = 0;
											if ($check > 0){
												$relation = mysqli_fetch_assoc($relationStatus);
												$case = $relation["AreFriends"];
											}
											if($ID2==$ID){
												echo '<h1>Das bist du:<a href="../Pages/ProfilSettings.php"><img style="width:20px;margin-left:20px;" src="../Pictures/SiteContent/new.svg"></a></h1>';
											}
											elseif($check <= 0){
												echo "<form method='post' action='../Php/SocialNetwork/AddRelation.php'>";
												echo "<input name='friendID' type='hidden' value='".$ID2."'/>";
												echo "<button id='button' type='submit'>Als Freund hinzufügen</button>";
												echo "</form>";
												echo "<br/>";
											}
											switch($case){
												case 1:
													if($relation["UserId2"] == $ID){
														echo "<form method='post' action='../Php/SocialNetwork/FriendRequestModifier.php'>";
														echo "<input name='change' type='hidden' value='accept'/>";
														echo "<input name='id' type='hidden' value='".$relation["UserId1"]."'/>";
														echo "<button id='button' type='submit'>Freundschaftsanfrage annehmen</button>";
														echo "</form>";
														echo "<br/>";
													}
													else{
														echo "<p class='label' style='padding:4px;'>Freundschaftsanfrage versendet</p>";
														echo "<br/>";
													}
													break;
												case 2:
													echo "<form method='post' action='../Php/SocialNetwork/DeleteRelation.php'>";
													echo "<input name='friendID' type='hidden' value='".$ID2."'/>";
													echo "<button id='button' type='submit'>Freund entfernen</button>";
													echo "</form>";
													echo "<br/>";
												break;
												case 3:
													echo "<form method='post' action='../Php/SocialNetwork/AddRelation.php'>";
													echo "<input name='friendID' type='hidden' value='".$ID2."'/>";
													echo "<button id='button' type='submit'>Als Freund hinzufügen</button>";
													echo "</form>";
													echo "<br/>";
												break;
											}
										?>
									</td>
								</tr>
							</table>
							<table>
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
								<tr>
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
                    	<?php
							if($ID2==$ID){
								echo"<h1>Deine Einkaufslisten:</h1>";
								include "../Php/ShoppinglistStream/MyStream.php";
							}
							else{
								echo"<h1>Einkaufslisten von ".$vorname_friend.":</h1>";
								include "../Php/ShoppinglistStream/FriendsStream.php";
							}
						?>
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
    </body>
</html>