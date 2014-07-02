<?php
	//SQL connection//
	include"../Templates/MYSQLConnectionString.php";
	
	//Delete shoppinglist before loading Lists//
	if(isset($_POST["ak"]) && $_POST["ak"]=="deleteList"){
		$abf5 = "DELETE FROM produkte WHERE list_id = '".$_POST["id"]."'";
		$abf7 = "DELETE FROM einkaufslisten WHERE listID = '".$_POST["id"]."'";
		mysqli_query($conUser,$abf5);
		mysqli_query($conUser,$abf7);
	}
	
	//Read data from database//
	if(isset($_GET['a'])){
		$user = $_GET['a'];
	}
	else{
		$user = $ID;
	}
	
	$abf2 = mysqli_query($conUser,"SELECT * FROM einkaufslisten WHERE userID = $user");
	$num2 = mysqli_num_rows($abf2);
	
	if($num2!=0){
		echo "<div id='Accordion1'>";
		while ($listen = mysqli_fetch_assoc($abf2)){
			
			echo "<h3>".$listen["listName"];
			echo "<span class='stream-date'>zuletzt geändert am: ".$listen["date"]."</span>";
			echo "</h3>";
			echo "<div><table class='t1'>";
			
			$lId=$listen["listID"];
			echo "<a title='Einkaufsliste löschen' href='javascript:send2(1,\"$lId\");'><img class='del_Image' src='../Pictures/SiteContent/cross.svg'></a>";
			echo "<a title='Einkaufsliste bearbeiten' href='javascript:send2(2,\"".$listen["listName"]."\");'><img class='del_Image' src='../Pictures/SiteContent/new.svg'></a>";
			
			$abf1 = mysqli_query($conUser,"SELECT * FROM produkte WHERE list_id = '".$listen["listID"]."'");
			$num1 = mysqli_num_rows($abf1);
			if($num1!=0){
				echo "<tr id='shoppinglist_header'>
					  <th>Produkt</th>
					  <th>Anzahl</th>
					  <th>Max. Preis</th>
					  <th>Anmerkung</th>
					  <th>Wird mitgebracht von</th>
					  </tr>";
					  
				while ($dsatz = mysqli_fetch_assoc($abf1)){
					$listId = $dsatz["list_id"];
					$itemId = $dsatz["item_id"];
					
					$abf3 = mysqli_query($conUser,"SELECT produkte.getFromUser, user.ID, user.name, user.vorname FROM produkte JOIN user WHERE item_id = ".$dsatz["item_id"]."&& produkte.getFromUser = user.ID");
					$getFromStatus = mysqli_fetch_assoc($abf3);
					$getFromUser = $getFromStatus["getFromUser"];
					
					echo "<tr class='shoppinglist_item_row'>";
					echo "<td class='shoppinglist_item product'><p>" . $dsatz["product"] . "</p></td>";
					echo "<td class='shoppinglist_item amount'><p>" . $dsatz["amount"] . "</p></td>";
					echo "<td class='shoppinglist_item maxPrice'><p>" . $dsatz["maxPrice"] . "€</p></td>";
					echo "<td class='shoppinglist_item info'><p>" . nl2br($dsatz["info"]) . "</p></td>";
					
					if ($getFromUser == 0 || $ID == $getFromUser){
						echo "<td class='shoppinglist_item'>-</td>";
					}
					else{
						echo "<td class='shoppinglist_item'><a class='friend_link' href='../Pages/Profil.php?a=".$getFromUser."'>".$getFromStatus["vorname"]." ".$getFromStatus["name"]."</a></td>";
					}
					echo "</tr>";
					$i++;
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
		Du hast noch keine Einkaufslisten.<br/>Erstelle jetzt Deine erste!<br/></div>
		<form style="width:672px;" action="../Php/Shoppinglist/AddShoppinglist.php" method="post">								
			<p>Name:
				<input name="list" type="text" maxlenght="10" required/>
				<button type="submit">Liste hinzufügen</button>
			</p>
		</form>
		<?php
	}
	
	mysqli_close($conUser);
?>