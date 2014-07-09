<?php
	include "../Php/Misc/GetYourData.php"; 
	include "../Templates/MYSQLConnectionString.php";
	
	$res = mysqli_query($conUser,"SELECT
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
								   
								   ORDER BY s_not_id DESC");
								   // Nicht "LIMIT 0 , 10", da sonst Badge Nummer falsch!
	$num = mysqli_num_rows($res);
	echo "<div id='hiddennum' style='display:none'>$num</div>";
	$i = 0;
	
	if(isset($_COOKIE['shoppingnotifications'])){
		$newnum = $num-$_COOKIE['shoppingnotifications'];
		if($num > $_COOKIE['shoppingnotifications']){
			echo "<div id='badge2' class='notification-badge'>$newnum</div>";
		}
	}
	else{
		echo "<div id='badge2' class='notification-badge'>$num</div>";
		$newnum = $num;
		
	}
		
	if ($num > 0){
		
		echo "<div id='HeadPopUpBox2' class='HeadPopUp'>";
		echo "<div class='PopUpArrow'></div>";
		echo "<p class='PopUpHeader'>Neuste Benachrichtigungen</p>";
	
		// Tabellenbeginn
		echo "<table cellspacing='0px' class='PopUpTable'>";
		while (($dsatz = mysqli_fetch_assoc($res)) && $i < 10){
			$name = "<a style='margin:0px;' href='../Pages/Profil.php?a=".$dsatz["ID"]."'>".$dsatz["vorname"] ." ".$dsatz["name"]."</a>" ;
			
			include "../Php/Misc/GetTime.php";
			
			echo "<tr>";
			//Mitbringen
			if($dsatz['status']==1){
				if($i<$newnum){
					echo "<td class='friend_req_block notification accept new'>";
				}
				else{
					echo "<td class='friend_req_block notification accept'>";
				}
				echo "<p style='font-size:12px;margin-bottom:0px;'>$zeit</p>";
				echo "<p style='font-size:14px;margin-top:0px;'>";
				echo $name." möchte Dir <b>".$dsatz["product"]."</b> aus Deiner Einkaufsliste <b>".$dsatz["listName"]."</b> mitbringen.";
				echo "</p>";
				echo "</td>";
			}
			//NichtMitbringen
			elseif($dsatz['status']==0){
				if($i<$newnum){
					echo "<td class='friend_req_block notification decline new'>";
				}
				else{
					echo "<td class='friend_req_block notification decline'>";
				}
				echo "<p style='font-size:12px;margin-bottom:0px;'>$zeit</p>";
				echo "<p style='font-size:14px;margin-top:0px;'>";
				echo $name." kann Dir <b>".$dsatz["product"]."</b> aus Deiner Einkaufsliste <b>".$dsatz["listName"]."</b> doch nicht mitbringen.";
				echo "</p>";
				echo "</td>";
			}
			//Nachricht
			elseif($dsatz['status']==2){
				if($i<$newnum){
					echo "<td class='friend_req_block notification message new'>";
				}
				else{
					echo "<td class='friend_req_block notification message'>";
				}
				echo "<p style='font-size:12px;margin-bottom:0px;'>$zeit</p>";
				echo "<p style='font-size:14px;margin-top:0px;'>";
				echo $name." hat Dir eine <a href='Chat.php?a=$ID2'>Nachricht</a> gesendet.";
				echo "</p>";
				echo "</td>";
			}
			//Freundschaftsanfrage
			elseif($dsatz['status']==3){
				if($i<$newnum){
					echo "<td class='friend_req_block notification friend_accept new'>";
				}
				else{
					echo "<td class='friend_req_block notification friend_accept'>";
				}
				echo "<p style='font-size:12px;margin-bottom:0px;'>$zeit</p>";
				echo "<p style='font-size:14px;margin-top:0px;'>";
				echo $name." hat Deine Freundschaftsanfrage angenommen.";
				echo "</p>";
				echo "</td>";
			}
			echo "</tr>";
			$i++;
		}
		// Tabellenende
		echo "</table>";
	echo "<p class='PopUpFooter'><a href='../Pages/AllNotifications.php'>Alle Benachrichtigungen anzeigen</a></p>";
	}
	else{
		echo "<div id='HeadPopUpBox2' class='HeadPopUp'>";
		echo "<p class='PopUpHeader'>Neuste Benachrichtigungen</p>";
		echo"<p style='padding:10px;margin:0;font-style:italic; font-size:14px;'> Du hast noch keine Benachrichtigungen</p>";
	}
	echo "</div>";
	mysqli_close($conUser);
?>