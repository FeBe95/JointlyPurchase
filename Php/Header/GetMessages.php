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
	
	$num = mysqli_num_rows($res);

	if ($num > 0){
		echo "<div id='badge2' class='notification-badge'>$num</div>";
		echo "<div id='HeadPopUpBox2' class='HeadPopUp'>";
		echo "<div class='PopUpArrow'></div>";
		echo "<p class='PopUpHeader'>Letzte Nachrichten</p>";
	
		// Tabellenbeginn
		echo "<table cellspacing='0px' class='PopUpTable' >";
		while ($dsatz1 = mysqli_fetch_assoc($res)){
			if($dsatz1["ID"] != $ID){
				//$name = "<a style='margin:0px;' href='../Pages/Profil.php?a=".$dsatz["ID"]."'>".$dsatz["vorname"]." ".$dsatz["name"]."</a>" ;
				$name = $dsatz1["vorname"]." ".$dsatz1["name"];
				echo "<tr>
						<td class='headerBlock message'>
							<div class='messageElement' onClick='location.href=\"../Pages/Chat.php?a=".$dsatz1["ID"]."\"'>
							$name:<br/>
							".$dsatz1["nachricht"]."
							</div>
						</td>
					</tr>";
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