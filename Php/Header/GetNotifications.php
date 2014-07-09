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
								   user.name,
								   user.vorname,
								   user.name,
								   user.ID,
								   user.name
								   FROM shoppingnotifications
								   INNER JOIN user ON shoppingnotifications.UserId1 = user.ID
								   WHERE shoppingnotifications.UserId2 = $ID
								   
								   ORDER BY s_not_id DESC");
								   
								   // Nicht LIMIT, sonder $i, da sonst Badge Nummer falsch!
								   // user.name 2x zusätzlich, da sonst nicht übereinstimmende Spaltenanzahl!
								   
								   
	$num = mysqli_num_rows($res);
	echo "<div id='hiddennum' style='display:none'>$num</div>";
	$i = 0;

		
	if ($num > 0){
		if(isset($_COOKIE['notifications'])){
			$newnum = $num-$_COOKIE['notifications'];
			if($num > $_COOKIE['notifications']){
				echo "<div id='badge3' class='notification-badge'>$newnum</div>";
			}
		}
		else{
			$newnum = $num;
			echo "<div id='badge3' class='notification-badge'>$newnum</div>";
		}
		
		echo "<div id='HeadPopUpBox3' class='HeadPopUp'>";
		echo "<div class='PopUpArrow'></div>";
		echo "<p class='PopUpHeader'>Neuste Benachrichtigungen</p>";
	
		// Tabellenbeginn
		echo "<table cellspacing='0px' class='PopUpTable'>";
		while (($dsatz = mysqli_fetch_assoc($res)) && $i < 10){
			$name = "<a href='../Pages/Profil.php?a=".$dsatz["ID"]."'>".$dsatz["vorname"] ." ".$dsatz["name"]."</a>" ;
			
			include "../Php/Misc/GetTime.php";
			
			echo "<tr>";
			
			//Mitbringen
			if($dsatz['status']==1){
				if($i<$newnum){
					echo "<td class='headerBlock notification accepted new'>";
				}
				else{
					echo "<td class='headerBlock notification accepted'>";
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
					echo "<td class='headerBlock notification declined new'>";
				}
				else{
					echo "<td class='headerBlock notification declined'>";
				}
				echo "<p style='font-size:12px;margin-bottom:0px;'>$zeit</p>";
				echo "<p style='font-size:14px;margin-top:0px;'>";
				echo $name." kann Dir <b>".$dsatz["product"]."</b> aus Deiner Einkaufsliste <b>".$dsatz["listName"]."</b> doch nicht mitbringen.";
				echo "</p>";
				echo "</td>";
			}
			//Freundschaftsanfrage
			elseif($dsatz['status']==3){
				if($i<$newnum){
					echo "<td class='headerBlock notification friendRequestAccepted new'>";
				}
				else{
					echo "<td class='headerBlock notification friendRequestAccepted'>";
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
		echo "<div id='HeadPopUpBox3' class='HeadPopUp'>";
		echo "<div class='PopUpArrow'></div>";
		echo "<p class='PopUpHeader'>Neuste Benachrichtigungen</p>";
		echo"<p style='padding:10px;margin:0;font-style:italic; font-size:14px;'> Du hast noch keine Benachrichtigungen</p>";
	}
	echo "</div>";
	mysqli_close($conUser);
?>