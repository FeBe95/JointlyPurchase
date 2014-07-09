<?php
	//SQL connection//
	include"../Templates/MYSQLConnectionString.php";
	
	//Read data from database//
	$abf2 = mysqli_query($conUser,"SELECT 
								   FriendRelation.UserId1,
								   FriendRelation.UserId2,
								   FriendRelation.AreFriends, 
								   einkaufslisten.userID,
								   einkaufslisten.listName,
								   einkaufslisten.listID,
								   einkaufslisten.date,
								   user.name,
								   user.vorname,
								   user.ID 
								   FROM einkaufslisten INNER JOIN FriendRelation INNER JOIN user WHERE AreFriends = 2 && userID != ".$ID." && UserID1 = ".$ID." && userID = user.ID && UserId2 = user.ID
								   UNION
								   SELECT 
								   FriendRelation.UserId1,
								   FriendRelation.UserId2,
								   FriendRelation.AreFriends, 
								   einkaufslisten.userID,
								   einkaufslisten.listName,
								   einkaufslisten.listID,
								   einkaufslisten.date,
								   user.name,
								   user.vorname,
								   user.ID 
								   FROM einkaufslisten INNER JOIN FriendRelation INNER JOIN user WHERE AreFriends = 2 && userID != ".$ID." && UserID2 = ".$ID." && userID = user.ID && UserId1 = user.ID");
	$num2 = mysqli_num_rows($abf2);
	
	if($num2!=0){
		echo "<div id='Accordion2'>";
		while ($dsatz = mysqli_fetch_assoc($abf2)){		
	
			include "../Php/Misc/GetTime.php";
			
			echo "<h3>";
			echo "Einkaufsliste <b>".$dsatz["listName"]."</b> von ".$dsatz["vorname"]." ".$dsatz["name"];
			echo "<span class='stream-date'>zuletzt geändert $zeit</span>";
			echo "</h3>";
	
			$abf1 = mysqli_query($conUser,"SELECT * FROM produkte WHERE list_id = '".$dsatz["listID"]."'");
			
			echo "<div><table class='t1'>";
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
				
				if ($getFromUser == 0){
					echo "<td class='shoppinglist_item'><a href='javascript:send(2,$itemId,\"$listId\");' class='mitbringen'>Mitbringen</a></td>";
				}
				elseif ($ID == $getFromUser){
					echo "<td class='shoppinglist_item'><a href='javascript:send(1,$itemId,\"$listId\");' class='mitbringen mbnicht'>Nicht mehr mitbringen</a></td>";
				}
				else{
					echo "<td class='shoppinglist_item'> <a class='friend_link' href='../Pages/Profil.php?a=".$getFromUser."'> " .$getFromStatus["vorname"]." ".$getFromStatus["name"]."</a></td>";
				}
				echo "</tr>";
			}
			echo "</table></div>";
		}
		echo "</div>"; // Accordion2 Ende
	}
	else{
		$friends = mysqli_query($conUser,"SELECT * FROM FriendRelation WHERE AreFriends = 2 AND (UserId1 = $ID OR UserID2 = $ID)");
		$numfriends = mysqli_num_rows($friends);
		
		if($numfriends==0){
			echo "Du hast noch keine Freunde hinzugefügt.";
			echo "<br>";
			echo "Füge Personen als Freunde hinzu, um deren Einkaufslisten zu sehen.<br/><br/></div>";
		}
		else{
			echo "Keiner Deiner Freunde hat bisher eine Einkaufsliste erstellt.<br/><br/></div>";
		}
	}
	mysqli_close($conUser);
	  
?>

<form name="shoppinglistAccept" method="post" action="../Php/ShoppinglistStream/AcceptItem.php">
	<input name='itemId' type='hidden' />
	<input name='listId' type='hidden' />
</form>
<form name="shoppinglistDecline" method="post" action="../Php/ShoppinglistStream/DeclineItem.php">
	<input name='itemId' type='hidden' />
	<input name='listId' type='hidden' />
</form>