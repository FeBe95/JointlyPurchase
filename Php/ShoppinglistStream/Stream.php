<?php
		  //SQL connection//
	  include"../Templates/MYSQLConnectionString.php";
	   //Variables//
	   //SQL_Querrys//
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
									FROM einkaufslisten INNER JOIN FriendRelation INNER JOIN user WHERE AreFriends = 2 && userID != ".$ID." && UserID1 = ".$ID." && userID = 			user.ID && UserId2 = user.ID");
	  $abf2_reverse = mysqli_query($conUser,"SELECT 
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
									FROM einkaufslisten INNER JOIN FriendRelation INNER JOIN user WHERE AreFriends = 2 && userID != ".$ID." && UserID2 = ".$ID." && userID = 			user.ID && UserId1 = user.ID");
	 $decider = mysqli_num_rows($abf2);
	 //Read data from database//
	 if($decider > 0 )
	 {
		 $decition = $abf2;
		 echo "<p style='margin-left: 20px;'>Die Einkaufslisten Deiner Freunde:</p>";
	 }else
	 {
		 $decition = $abf2_reverse;
		 echo "<p style='margin-left: 20px;'>Die Einkaufslisten Deiner Freunde:</p>";
	 }
	 while ($listen = mysqli_fetch_assoc($decition))
	  {
		  echo "<div id='socialAreaLists'>";
		  echo "<div class='label'><p style='margin:0px;'>Einkaufsliste <b>".$listen["listName"]."</b> von: <a id='friend_link' href='../Pages/Profil.php?a=".$listen["ID"]."'> " .$listen["vorname"]." ".$listen["name"]."</a><span style='float:right;font-size:12px; font-style: italic;'>zuletzt geändert am: ".$listen["date"]."</span></p></div>";

		  $abf1 = mysqli_query($conUser,"SELECT * FROM produkte WHERE list_id = '".$listen["listID"]."'");
		  $i=0;
		  echo "<table id='t1'>";
		  echo "<tr id='shoppinglist_header'><th>Produkt</th><th>Anzahl</th><th>Maximaler Preis</th><th>Anmerkung</th><th>Wird mitgebracht von:</th></tr>";
		  while ($dsatz = mysqli_fetch_assoc($abf1))
		  {	  
		  	  $listId = $dsatz["list_id"];
			  $itemId = $dsatz["item_id"];
			  $abf3 = mysqli_query($conUser,"SELECT produkte.getFromUser, user.ID, user.name, user.vorname FROM produkte JOIN user WHERE item_id = ".$dsatz["item_id"]."&& produkte.getFromUser = user.ID");
			  $getFromStatus = mysqli_fetch_assoc($abf3);
			  $getFromUser = $getFromStatus["getFromUser"];
			  if ($i==1)
			  {
				  echo "<tr class='lightgray' id='shoppinglist_item_row'>";
				  echo "<td class='product' id='shoppinglist_item'><p>" . $dsatz["product"] . "</p></td>";
				  echo "<td class='amount' id='shoppinglist_item'><p>" . $dsatz["amount"] . "</p></td>";
				  echo "<td class='maxPrice' id='shoppinglist_item'><p>" . $dsatz["maxPrice"] . "€</p></td>";
				  echo nl2br("<td class='info' id='shoppinglist_item'><p>" . $dsatz["info"] . "</p></td>");
				  if ( $getFromUser == 0){
				  echo "<td id='shoppinglist_item'><a href='javascript:send(2,$itemId,\"$listId\");'><img src='../Pictures/SiteContent/mitnehmen.png'></a></td>";
				  }elseif ($ID === $getFromUser)
				  {
					echo "<td id='shoppinglist_item'><a href='javascript:send(1,$itemId,\"$listId\");'><img src='../Pictures/SiteContent/nichtMitnehmen.png'></a></td>";
				  }else
				  {
					echo "<td id='shoppinglist_item'><a id='friend_link' href='../Pages/Profil.php?a=".$getFromUser."'> " .$getFromStatus["vorname"]." ".$getFromStatus["name"]."</a></td>";
				  }
				  echo "</tr>";
				  $i--;
			  }else
			  {
				  echo "<tr id='shoppinglist_item_row'>";
				  echo "<td class='product' id='shoppinglist_item'><p>" . $dsatz["product"] . "</p></td>";
				  echo "<td class='amount' id='shoppinglist_item'><p>" . $dsatz["amount"] . "</p></td>";
				  echo "<td class='maxPrice' id='shoppinglist_item'><p>" . $dsatz["maxPrice"] . "€</p></td>";
				  echo nl2br("<td class='info' id='shoppinglist_item'><p>" . $dsatz["info"] . "</p></td>");
				  if ( $getFromUser == 0){
				  echo "<td id='shoppinglist_item'><a href='javascript:send(2,$itemId,\"$listId\");'><img src='../Pictures/SiteContent/mitnehmen.png'></a></td>";
				  }elseif ($ID === $getFromUser)
				  {
					echo "<td id='shoppinglist_item'><a href='javascript:send(1,$itemId,\"$listId\");'><img src='../Pictures/SiteContent/nichtMitnehmen.png'></a></td>";
				  }else
				  {
					echo "<td id='shoppinglist_item'> <a id='friend_link' href='../Pages/Profil.php?a=".$getFromUser."'> " .$getFromStatus["vorname"]." ".$getFromStatus["name"]."</a></td>";
				  }
				  echo "</tr>";
				  $i++;
			  }
		  }
		  echo "</table></div>";
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