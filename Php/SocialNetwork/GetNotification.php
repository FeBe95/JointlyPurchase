<?php
	include "../Php/Misc/GetYourData.php"; 
	include "../Templates/MYSQLConnectionString.php";
	
	$res = mysqli_query($conUser,"SELECT
								  Notifications.date,
								  produkte.product,
								  user.vorname,
								  user.name,
								  user.ID,
								  einkaufslisten.listName
								  FROM Notifications
								  INNER JOIN produkte ON Notifications.UserId1 = produkte.getFromUser
								  INNER JOIN user ON produkte.getFromUser = user.ID
								  INNER JOIN einkaufslisten ON produkte.list_id = einkaufslisten.listID
								  WHERE Notifications.NotificationType = 2 && Notifications.UserId2 =".$ID."
								  ORDER BY Notifications.date DESC
								  LIMIT 0 , 30");
	$num = mysqli_num_rows($res);

	if ($num > 0){
		if(isset($_COOKIE['notifications'])){
			if($num > $_COOKIE['notifications']){
				//echo "<div id='badge2' class='notification-badge'>$num</div>";
				echo "<div id='badge2' class='notification-badge'></div>";
			}
		}
		else{
			//echo "<div id='badge2' class='notification-badge'>$num</div>";
			echo "<div id='badge2' class='notification-badge'></div>";
		}
		echo "<div id='HeadPopUpBox2' class='HeadPopUp'>";
		echo "<p style='font-size:12px; font-weight:bold; margin-top:0px; border-bottom:1px solid grey;'>Benachrichtigungen</p>";
	
		// Tabellenbeginn
		echo "<table cellspacing='10px' style='width:100%;' >";
		while ($dsatz = mysqli_fetch_assoc($res)){
			$name= "<a style='margin:0px;' href='../Pages/Profil.php?a=".$dsatz["ID"]."'>".$dsatz["vorname"] ." ".$dsatz["name"]."</a>" ;
			echo "<tr>";
			echo "<td class='friend_req_block not_count'><p style='font-size:12px;margin-bottom:0px;'>".$dsatz["date"]."</p><p style='font-size:14px;margin-top:0px;'>".$name." möchte Dir <b>".$dsatz["product"]."</b> aus Deiner Einkaufsliste <b>".$dsatz["listName"]."</b> mitbringen.</p></td>";
			echo "</tr>";
		}
		// Tabellenende
		echo "</table>";
	}
	else{
		echo "<div id='HeadPopUpBox2' class='HeadPopUp'>";
		echo "<p style='font-size:12px; font-weight:bold; margin-top:0px; border-bottom:1px solid grey;'>Benachrichtigungen</p>";
		echo"<p style='font-style:italic; font-size:12px;'> Du hast zurzeit keine Benachrichtigungen </p>";
	}
	echo "</div>";
	mysqli_close($conUser);
?>
<!--<form name="friend_req" id="friend_req" method="post" action="FriendRequestModifier.php">
    <input name='id' type='hidden' />
    <input name='change' type='hidden' />
</form>-->
