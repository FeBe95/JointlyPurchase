<?php
    session_start();
    include "../Php/Authentification/SessionChecker.php";
	include "../Php/Misc/GetYourData.php";
	
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <title>ShoppinglistEditor</title>
		
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/CSS" href="../css/style.css">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script src="../js/FormValidation.js"></script>
    	<script src="../js/BoogyBox.js"></script>
		
		<script>
			$(function(){
				$( "a" ).click(function(event) {
					if(document.shoppinglist.product.value!=""){
						if (confirm("Bearbeitung abbrechen?")){
							location.href = event.target.href;
						}
						else{
							return false;
						}
					}
				});
			});
			
			function send(ak,id){
				if(ak==2){
					if(document.shoppinglist.product.value!=""){
						if(confirm("Bearbeitung abbrechen und Artikel löschen?")){
							document.shoppinglist.ak.value = "deleteItem";
							document.shoppinglist.id.value = id;
							document.shoppinglist.submit();
						}
					}
					else{
						if(confirm("Artikel löschen?")){
							document.shoppinglist.ak.value = "deleteItem";
							document.shoppinglist.id.value = id;
							document.shoppinglist.submit();
						}
					}
				}
				else if(ak==1){
					if (confirm("Willst du die Einkaufsliste wirklich löschen?")){
						document.shoppinglist.ak.value = "deleteList";
						document.shoppinglist.id.value = id;
						document.shoppinglist.submit();		
					}	
				}
			}
			
			var msg_1 = 'Fehler:';
			
			var var_1 = new Array()
			var_1[0] = new Array('product','c','','');
			var_1[1] = new Array('amount','n','ist keine Zahl','');
			var_1[2] = new Array('maxPrice','p.','ist kein Preis','');
        </script>
	</head>
    <body>
        <?php 
            include "../Templates/HeadTemplate.php";
        ?>
		<div id="mainwindow">
			<div id="shoppinglist_add" class="contentBlock">
				<table class="t3">
					<tr>
						<td>
							<h1>Einkaufsliste:</h1>
						</td>
						<td>
							<?php
							//Einkaufslisten Namen übergeben//
								if (isset($_POST["list"])){
									$_SESSION["list"] = $_POST["list"];
									$table = $_SESSION["list"];
								}
								else{
									$table = $_SESSION["list"];
								}
								echo "<p class='label'>".$table."&nbsp;<a href='javascript:send(1,0);'><img style='width:10px'; class='del_Image' src='../Pictures/SiteContent/cross.svg'></a></p>";
							?>
						</td>
					</tr>
				</table>
				<table class='t1' border='0'>
					<tr id='shoppinglist_header'>
						<th>Produkt</th>
						<th>Anzahl</th>
						<th>Maximaler Preis</th>
						<th>Anmerkung</th>
					</tr>
					<?php					
						//SQL connection//
						include"../Templates/MYSQLConnectionString.php";
						
						//SQL_Querrys//
						$abf2 = mysqli_query($conUser,"SELECT listID FROM einkaufslisten WHERE listName = '".$table."' && userID = ".$ID."");
						$listID = mysqli_fetch_assoc($abf2);
						$abf1 = mysqli_query($conUser,"SELECT * FROM produkte WHERE list_id = '".$listID["listID"]."'");
						
						$row = mysqli_num_rows($abf1);
						$maxItems = 15;
					
						//Read data from database//	;
						$i=0;
						while ($dsatz = mysqli_fetch_assoc($abf1)){
							
							
							if ($i%2==0){
								echo "<tr class='shoppinglist_item_row lightgray'>";
							}
							else{
								echo "<tr class='shoppinglist_item_row'>";
							}
							echo "<td class='shoppinglist_item product'><p>" . $dsatz["product"] . "</p></td>";
							echo "<td class='shoppinglist_item amount'><p>" . $dsatz["amount"] . "</p></td>";
							echo "<td class='shoppinglist_item maxPrice'><p>" . $dsatz["maxPrice"] . "€</p></td>";
							echo "<td class='shoppinglist_item info'><p>" . nl2br($dsatz["info"]) . "</p></td>";
							echo "<td class='shoppinglist_item delcross'><a href='javascript:send(2,".$dsatz["item_id"].");'><img class='del_Image' src='../Pictures/SiteContent/cross.svg'></a></td>";
							echo "</tr>";
							$i++;
						}
						//}
						mysqli_close($conUser);							
					?>
				</table>
				<form name="shoppinglist" id="shoppinglist" action="../Php/Shoppinglist/AddNewItem.php"  method="post" style="font-family:arial, sans-serif;" onSubmit="return validate(this,var_1,msg_1)">
					<div id="shoppinglist_add_element">
						<p style="margin:0px;text-align: center;">
							Produkt:<input type="text" id="product"  name="product" type="text" maxlength="20" value="" autofocus required/>
							Anzahl:<input id="count" name="amount" type="number" min="1" max="100" size="3" step="1" maxlength="3" value="1" required style="width:50px;"/>
							Max.Preis:<input id="maxPrice" name="maxPrice" type="number" step="1" size="6" value="0" style="width:50px;"/>€ &nbsp;
							Anmerkung:<textarea id="info" name="info" style="width: 200px; height: 40px;"></textarea>
						</p>
						<input name='ak' type='hidden' />
						<input name='id' type='hidden' />
					</div>
					<table class="t2">
						<tr>
							<td>
								<?php
									if ($row <= $maxItems -1 )
									{
									echo "<button Type='submit' id='insert_button' >Eintragen</button><br/>";  
									}else
									{
									echo "<button style='cursor: not-allowed'; Type='submit' id='insert_button' disabled >Eintragen</button><br/>";  
									}
								?>
							</td>
							<td style="float:right;">
								<?php
									echo "<p class='label'>".$row." / 15 Einträgen</p>";
								?>
							</td>
						</tr>
						<tr>
							<td>
								<?php
									include "../Templates/MYSQLConnectionString.php";
									$profilPic= mysqli_query($conUser,"SELECT profilPic FROM user WHERE email = '".$email."'");
									$profilPic = mysqli_fetch_assoc($profilPic);
									echo "<br/><a href=\"../Pages/Profil.php?a=".$ID."\">Fertig bearbeitet - zur Übersicht</a>";
								?>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
    </body>
</html>
