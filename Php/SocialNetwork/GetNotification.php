<?php
	include "../Php/Misc/GetYourData.php"; 
	include "../Templates/MYSQLConnectionString.php";
	
	/*HIER*/
	$res = mysqli_query($conUser,"SELECT
								  shoppingnotifications.date,
								  shoppingnotifications.status,
								  produkte.product,
								  user.vorname,
								  user.name,
								  user.ID,
								  einkaufslisten.listName
								  FROM shoppingnotifications
								  INNER JOIN produkte ON shoppingnotifications.product_id = produkte.item_id
								  INNER JOIN user ON produkte.getFromUser = user.ID
								  INNER JOIN einkaufslisten ON produkte.list_id = einkaufslisten.listID
								  WHERE shoppingnotifications.UserId2 = $ID
								  ORDER BY shoppingnotifications.date DESC
								  LIMIT 0 , 30");
	$num = mysqli_num_rows($res);
	
	if ($num > 0){
		if(isset($_COOKIE['shoppingnotifications'])){
			if($num > $_COOKIE['shoppingnotifications']){
				echo "<div id='badge2' class='notification-badge'>".($num-$_COOKIE['shoppingnotifications'])."</div>";
			}
		}
		else{
			echo "<div id='badge2' class='notification-badge'>$num</div>";
		}
		
		echo "<div id='HeadPopUpBox2' class='HeadPopUp'>";
		echo "<p class='PopUpHeader'>Benachrichtigungen</p>";
	
		// Tabellenbeginn
		echo "<table cellspacing='10px' class='PopUpTable' >";
		while ($dsatz = mysqli_fetch_assoc($res)){
			$name= "<a style='margin:0px;' href='../Pages/Profil.php?a=".$dsatz["ID"]."'>".$dsatz["vorname"] ." ".$dsatz["name"]."</a>" ;
			echo "<tr>";
			if($dsatz['status']==1){
				echo "<td class='friend_req_block not_count' style='padding:0 20px;background-color:#dfd'>";
				echo "<p style='font-size:12px;margin-bottom:0px;'>".$dsatz["date"]."</p>";
				echo "<p style='font-size:14px;margin-top:0px;'>";
				echo $name." möchte Dir <b>".$dsatz["product"]."</b> aus Deiner Einkaufsliste <b>".$dsatz["listName"]."</b> mitbringen.";
				echo "</p>";
				echo "</td>";
			}
			else{
				echo "<td class='friend_req_block not_count' style='padding:0 20px;background-color:#fdd'>";
				echo "<p style='font-size:12px;margin-bottom:0px;'>".$dsatz["date"]."</p>";
				echo "<p style='font-size:14px;margin-top:0px;'>";
				echo $name." kann Dir <b>".$dsatz["product"]."</b> aus Deiner Einkaufsliste <b>".$dsatz["listName"]."</b> doch nicht mitbringen.";
				echo "</p>";
				echo "</td>";
			}
			echo "</tr>";
		}
		// Tabellenende
		echo "</table>";
	}
	else{
		echo "<div id='HeadPopUpBox2' class='HeadPopUp'>";
		echo "<p class='PopUpHeader'>Benachrichtigungen</p>";
		echo"<p style='padding:10px;margin:0;font-style:italic; font-size:12px;'> Du hast zurzeit keine Benachrichtigungen </p>";
	}
	echo "</div>";
	mysqli_close($conUser);
?>
<!--<form name="friend_req" id="friend_req" method="post" action="FriendRequestModifier.php">
    <input name='id' type='hidden' />
    <input name='change' type='hidden' />
</form>-->
