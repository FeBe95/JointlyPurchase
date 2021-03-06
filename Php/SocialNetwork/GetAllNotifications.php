<?php
	include "../Php/Misc/GetYourData.php"; 
	include "../Templates/MYSQLConnectionString.php";
	
	$res1 = mysqli_query($conUser,"SELECT
								   s_not_id,
								   shoppingnotifications.date,
								   shoppingnotifications.status,
								   produkte.product,
								   user.vorname,
								   user.name,
								   user.ID,
								   einkaufslisten.listName
								   FROM shoppingnotifications
								   INNER JOIN produkte ON shoppingnotifications.product_id = produkte.item_id
								   INNER JOIN user ON shoppingnotifications.UserId1 = user.ID
								   INNER JOIN einkaufslisten ON produkte.list_id = einkaufslisten.listID
								   WHERE shoppingnotifications.UserId2 = $ID
								   
								   UNION
								   
								   SELECT
								   s_not_id,
								   shoppingnotifications.date,
								   shoppingnotifications.status,
								   user.vorname,
								   user.vorname,
								   user.name,
								   user.name,
								   user.ID
								   FROM shoppingnotifications
								   INNER JOIN user ON shoppingnotifications.UserId1 = user.ID
								   WHERE shoppingnotifications.UserId2 = $ID
								   AND shoppingnotifications.status = 3
								   
								   ORDER BY s_not_id DESC");	
								   
	$num = mysqli_num_rows($res1);
	
	if ($num > 0){
		echo "<h1>Alle Deine Benachrichtigungen:</h1>";
	
		// Tabellenbeginn
		echo "<table cellspacing='0px' class='PopUpTable all_notifications'>";
		while ($dsatz = mysqli_fetch_assoc($res1)){
			$name = "<a style='margin:0px;' href='../Pages/Profil.php?a=".$dsatz["ID"]."'>".$dsatz["vorname"] ." ".$dsatz["name"]."</a>" ;
			
			include "../Php/Misc/GetTime.php";
			
			echo "<tr>";
			//Mitbringen
			if($dsatz['status']==1){
				echo "<td class='friend_req_block notification accept'>";
				echo "<p style='font-size:12px;margin-bottom:0px;'>$zeit</p>";
				echo "<p style='font-size:14px;margin-top:0px;'>";
				echo $name." möchte Dir <b>".$dsatz["product"]."</b> aus Deiner Einkaufsliste <b>".$dsatz["listName"]."</b> mitbringen.";
				echo "</p>";
				echo "</td>";
			}
			//NichtMitbringen
			elseif($dsatz['status']==0){
				echo "<td class='friend_req_block notification decline'>";
				echo "<p style='font-size:12px;margin-bottom:0px;'>$zeit</p>";
				echo "<p style='font-size:14px;margin-top:0px;'>";
				echo $name." kann Dir <b>".$dsatz["product"]."</b> aus Deiner Einkaufsliste <b>".$dsatz["listName"]."</b> doch nicht mitbringen.";
				echo "</p>";
				echo "</td>";
			}
			//Nachricht
			elseif($dsatz['status']==2){
				if($i<$newnum){
					echo "<td class='friend_req_block notification new'>";
				}
				else{
					echo "<td class='friend_req_block notification'>";
				}
				echo "<p style='font-size:12px;margin-bottom:0px;'>$zeit</p>";
				echo "<p style='font-size:14px;margin-top:0px;'>";
				echo $name." hat Dir eine <a href='Chat.php?a=$ID2'>Nachricht</a> gesendet.";
				echo "</p>";
				echo "</td>";
			}
			//Freundschaftsanfrage
			elseif($dsatz['status']==3){
				echo "<td class='friend_req_block notification friend_accept'>";
				echo "<p style='font-size:12px;margin-bottom:0px;'>$zeit</p>";
				echo "<p style='font-size:14px;margin-top:0px;'>";
				echo $name." hat deine Freundschaftsanfrage angenommen.";
				echo "</p>";
				echo "</td>";
			}
			echo "</tr>";
		}
		// Tabellenende
		echo "</table>";
	}
	else{
		echo "<p class='PopUpHeader'>Benachrichtigungen</p>";
		echo"<p style='padding:10px;margin:0;font-style:italic; font-size:12px;'> Du hast zurzeit keine Benachrichtigungen </p>";
	}
	mysqli_close($conUser);
?>