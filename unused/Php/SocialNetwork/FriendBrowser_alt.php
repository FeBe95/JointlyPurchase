<?php
    session_start();
	
	include "../../Php/Misc/GetYourData.php"; 
	include "../../Templates/MYSQLConnectionString.php";
	
	$fbquery = "CREATE TEMPORARY TABLE tmp (
					ID INT(11),
					name VARCHAR(20),
					vorname VARCHAR(20),
					profilPic VARCHAR(50)    
				);

				INSERT INTO tmp (
					ID,
					name,
					vorname,
					profilPic
				)
				SELECT
					user.ID,
					user.name,
					user.vorname,
					user.profilPic
				FROM user
				JOIN FriendRelation
				ON user.ID = FriendRelation.UserId1
				AND FriendRelation.UserId2 = $ID
				WHERE user.plz = $plz
				AND FriendRelation.AreFriends != 2;
				
				INSERT INTO tmp (
					ID,
					name,
					vorname,
					profilPic
				)
				SELECT
					user.ID,
					user.name,
					user.vorname,
					user.profilPic
				FROM user
				JOIN FriendRelation
				ON user.ID = FriendRelation.UserId2
				AND FriendRelation.UserId1 = $ID
				WHERE user.plz = $plz
				AND FriendRelation.AreFriends != 2;
				
				INSERT INTO tmp (
					ID,
					name,
					vorname,
					profilPic
				)
				SELECT
					user.ID,
					user.name,
					user.vorname,
					user.profilPic
				FROM user
				WHERE user.plz = $plz
				AND user.ID != $ID;
				
				
				ALTER IGNORE TABLE tmp ADD UNIQUE INDEX(ID);
					
				CREATE TEMPORARY TABLE friends (
					SELECT *
					FROM (
						(
							SELECT
								user.ID,
								user.name,
								user.vorname,
								user.profilPic 
							FROM FriendRelation
							JOIN user
							ON FriendRelation.UserId1 = user.ID
							WHERE FriendRelation.AreFriends = 2
							AND FriendRelation.UserId2 =$ID
						)
							
						UNION
							
						(
							SELECT
								user.ID,
								user.name,
								user.vorname,
								user.profilPic 
							FROM FriendRelation
							JOIN user
							ON FriendRelation.UserId2 = user.ID
							WHERE FriendRelation.AreFriends = 2
							AND FriendRelation.UserId1 = $ID
						)
					)
					AS tmp_friends
				);
					
				SELECT *
				FROM tmp
				WHERE ROW
				(
					tmp.ID,
					tmp.name,
					tmp.vorname,
					tmp.profilPic
				)
				NOT IN
				(
					SELECT  * FROM friends
				)";

	// echo mysqli_error($conUser)."<br/>";						   
	
	echo "<div id='results'>";
	echo "Leute aus Deiner Nähe:";
	// Tabellenbeginn
	echo "<table cellspacing='10px' style='margin:auto;' >";
	$i = 0;
	
	if(mysqli_multi_query($conUser,$fbquery)){
		do {
			if ($res1 = mysqli_store_result($conUser)){
				while ($dsatz = mysqli_fetch_row($res1)){
					$name= $dsatz["2"]."<br/>".$dsatz["1"];
					echo "<tr>";
					echo "<td class='friend_block'>
							<a class='friend_link' href='../Pages/Profil.php?a=".$dsatz['0']."'>
								<div id='profilPicCrop'>
									<img id='profilcrop' src='../Pictures/Thumbnails/".$dsatz["3"]."'>
								</div>
								$name
							</a>
						  </td>";
					echo "</tr>";
					$i++;
				}
			}
		} while (mysqli_next_result($conUser));
	}	

	if ($i==0) {
		echo "<div class='friend_block_empty'>";
		echo "<p>Es konnten keine weiteren Nutzer in deiner Umgebung gefunden werden.</p>";
		echo "<p>Um dies zu ändern schicke deinen Freunden doch einfach eine Einladung<p>";
		echo "</div>";
	}
		
	// Tabellenende
		echo "</table>";

	echo "</div>";
	mysqli_close($conUser);
?>