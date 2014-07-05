<?php
	include "../Php/Misc/GetYourData.php"; 
	include "../Templates/MYSQLConnectionString.php";
	
	
	//Abfrage für noch nicht angenommene Freundschaftsanfragen (von dir)
	$query = "CREATE TEMPORARY TABLE tmp (
					ID INT(11),
					name VARCHAR(20),
					vorname VARCHAR(20),
					profilPic VARCHAR(50)    
					);

					INSERT INTO tmp 
					(ID, name, vorname, profilPic)
					SELECT user.ID, user.name,user.vorname, user.profilPic FROM user JOIN friendrelation ON user.ID = friendrelation.UserId2 && friendrelation.UserId1 = ".$ID." WHERE user.plz = ".$plz." && friendrelation.AreFriends <> 2;
					INSERT INTO tmp 
					(ID, name, vorname, profilPic)
					SELECT user.ID, user.name, user.vorname, user.profilPic FROM user JOIN friendrelation ON user.ID = friendrelation.UserId1 && friendrelation.UserId2 = ".$ID." WHERE user.plz = ".$plz." && friendrelation.AreFriends <> 2;
					INSERT INTO tmp 
					(ID, name, vorname, profilPic)
					SELECT  user.ID, user.name, user.vorname, user.profilPic FROM user WHERE user.plz = ".$plz." && user.ID <> ".$ID.";
					
					ALTER IGNORE TABLE tmp ADD UNIQUE INDEX(ID);
					
					CREATE TEMPORARY TABLE friends (
						SELECT * FROM (
							
						(SELECT  user.ID, user.name, user.vorname, user.profilPic 
						FROM FriendRelation INNER JOIN user ON FriendRelation.UserId2 = user.ID WHERE FriendRelation.AreFriends = 2 && FriendRelation.UserId1 = ".$ID.")
							
						UNION
							
						(SELECT user.ID, user.name, user.vorname, user.profilPic 
						FROM FriendRelation INNER JOIN user ON FriendRelation.UserId1 = user.ID WHERE FriendRelation.AreFriends = 2 && FriendRelation.UserId2 = ".$ID.")
					)AS tmp_friends );
					
					

						SELECT * FROM tmp WHERE ROW(tmp.ID, tmp.name, tmp.vorname, tmp.profilPic) NOT IN
						(
						SELECT  * FROM friends
						)";

	echo mysqli_error($conUser)."<br/>";						   
	
	
	echo"<div id='right'>";
	// Tabellenbeginn
	echo "<table cellspacing='10px' style='margin:auto;' >";
	
	if(mysqli_multi_query($conUser,$query)){
		do {
			if ($res1 = mysqli_store_result($conUser)){
				while ($dsatz=mysqli_fetch_row($res1)){
					$name= $dsatz["1"]."<br/>".$dsatz["2"];
					echo "<tr>";
					echo "<td class='friend_block'><a class='friend_link' href='../Pages/Profil.php?a=".$dsatz['0']."'><div id='profilPicCrop'><img id='profilcrop' src='../Pictures/Thumbnails/".$dsatz["3"]."'></div>$name</a></td>";
					echo "</tr>";
				}
			}
			if (!mysqli_more_results($conUser)) {
				echo "<div class='friend_block_empty'>";
				echo "<p>Es konnten keine weiteren Nutzer in deiner Umgebung gefunden werden.</p>";
				echo "<p>Um dies zu ändern schicke deinen Freunden doch einfach eine Einladung<p>";
				echo "</div>";
			}
		} while (mysqli_next_result($conUser));
	}	
		
	// Tabellenende
		echo "</table>";

	echo "</div>";
	mysqli_close($conUser);
?>