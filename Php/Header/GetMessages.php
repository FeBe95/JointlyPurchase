<?php
	include "../Php/Misc/GetYourData.php";
	include "../Templates/MYSQLConnectionString.php";
								  
	$res = mysqli_query($conUser,"SELECT 
								  user.ID,
								  user.name,
								  user.vorname,
								  user.profilPic,
								  messages.message_id,
								  messages.nachricht,
								  messages.date,
								  messages.UserId1,
								  messages.UserId2
								  FROM (
									SELECT m1.*
									FROM messages m1
									LEFT JOIN messages m2
									ON (m1.UserId2 = m2.UserId2 AND m1.message_id < m2.message_id)
									WHERE m2.message_id IS NULL
								  ) AS messages
								  JOIN user
								  ON messages.UserId1 = user.ID
								  OR messages.UserId2 = user.ID
								  WHERE messages.UserId1 = $ID
								  OR messages.UserId1 = $ID
								  ORDER BY messages.message_id DESC");
	
	$num = mysqli_num_rows($res)/2; //Jedes 2te (Eigene ID)
	echo "<div id='hiddennum2' style='display:none'>$num</div>";
	$i = 0;

		
	if ($num > 0){
		if(isset($_COOKIE['messages'])){
			$newnum = $num-$_COOKIE['messages'];
			if($num > $_COOKIE['messages']){
				echo "<div id='badge2' class='notification-badge'>$newnum</div>";
			}
		}
		else{
			$newnum = $num;
			echo "<div id='badge2' class='notification-badge'>$newnum</div>";
		}

		echo "<div id='HeadPopUpBox2' class='HeadPopUp'>";
		echo "<div class='PopUpArrow'></div>";
		echo "<p class='PopUpHeader'>Letzte Nachrichten</p>";
	
		// Tabellenbeginn
		echo "<table cellspacing='0px' class='PopUpTable' >";
		while (($dsatz = mysqli_fetch_assoc($res)) && $i < 10){
			if($dsatz["ID"] != $ID){
				$name = $dsatz["vorname"]." ".$dsatz["name"];
				
				include "../Php/Misc/GetTime.php";
				
				echo "<tr>";
				
				if($i<$newnum){
					echo "<td class='headerBlock message new'>";
				}
				else{
					echo "<td class='headerBlock message'>";
				}
				echo "<div class='messageElement' onClick='location.href=\"../Pages/Chat.php?a=".$dsatz["ID"]."\"'>";
				echo "<p style='font-size:12px;margin-bottom:0px;'>$zeit</p>";
				echo "<p style='font-size:14px;margin-top:0px;'>";
				echo $name.": ".$dsatz["nachricht"];
				echo "</p>";
				echo "</div>";
				echo "</td>";
				echo "</tr>";
				$i++;
			}
		}
		// Tabellenende
		echo "</table>";
		echo "<p class='PopUpFooter'><a href='../Pages/Chat.php'>Alle Nachrichten anzeigen</a></p>";
	}
	else{
		echo "<div id='HeadPopUpBox2' class='HeadPopUp'>";
		echo "<div class='PopUpArrow'></div>";
		echo "<p class='PopUpHeader'>Freundschaftsanfragen</p>";
		echo"<p style='padding:10px;margin:0;font-style:italic; font-size:12px;'>Du hast noch keine Chats.</p>";
	}
	echo "</div>";
	mysqli_close($conUser);

?>