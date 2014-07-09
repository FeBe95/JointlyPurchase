<?php
	session_start();
	include "../../Php/Misc/GetYourData.php";
	include "../../Templates/MYSQLConnectionString.php";
								  
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
	
	$num1 = mysqli_num_rows($res);
	
	echo"<div id='right'>";

	if ($num1 > 0){
		while ($dsatz1 = mysqli_fetch_assoc($res)){
			if($dsatz1["ID"] != $ID){
				$name= $dsatz1["vorname"]."<br/>".$dsatz1["name"];
				echo "<div class='friend_block'>";
				echo "<a class='friend_link' href='../Pages/Chat.php?a=".$dsatz1['ID']."'>
						<div id='profilPicCrop'>
							<img id='profilcrop' src='../Pictures/Thumbnails/".$dsatz1["profilPic"]."'>
						</div>
						$name
					  </a>";
				echo $dsatz1["nachricht"];
				echo "</div>";
			}
		}
	}
	else{
		echo "<p>Du hast noch keine Chats.</p>";
	}
	echo "</div>";
	mysqli_close($conUser);
?>