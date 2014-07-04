<?php
	include "../Php/Misc/GetYourData.php"; 
	include "../Templates/MYSQLConnectionString.php";
	
	
	//Abfrage für noch nicht angenommene Freundschaftsanfragen (von dir)
	$res1 = mysqli_query($conUser,"SELECT DISTINCT
								   FriendRelation.AreFriends,
								   FriendRelation.UserId1,
								   FriendRelation.UserId2,
								   user.ID,
								   user.name,
								   user.vorname,
								   user.profilPic
								   FROM FriendRelation
								   RIGHT JOIN user
								   ON FriendRelation.UserId1 = user.ID
								   WHERE FriendRelation.AreFriends != 2
								   AND user.ID != $ID
								   AND user.plz = $plz
								   LIMIT 0 , 100");
			
	//Abfrage für noch nicht angenommene Freundschaftsanfragen (vom Freund)				  
	$res2 = mysqli_query($conUser,"SELECT DISTINCT
								   FriendRelation.AreFriends,
								   FriendRelation.UserId1,
								   FriendRelation.UserId2,
								   user.ID,
								   user.name,
								   user.vorname,
								   user.profilPic
								   FROM FriendRelation
								   INNER JOIN user
								   ON FriendRelation.UserId2 = user.ID
								   WHERE FriendRelation.AreFriends != 2
								   AND user.ID != $ID
								   AND user.plz = $plz
								   LIMIT 0 , 100");
	
	//Abfrage für noch nicht bestehende Freundschaftsanfragen
	$res3 = mysqli_query($conUser,"SELECT DISTINCT
								   FriendRelation.AreFriends,
								   FriendRelation.UserId1,
								   FriendRelation.UserId2,
								   user.ID,
								   user.name,
								   user.vorname,
								   user.profilPic
								   FROM FriendRelation
								   RIGHT OUTER JOIN user
								   ON FriendRelation.UserId1 = user.ID 
                                   OR FriendRelation.UserId2 = user.ID 
                                   WHERE FriendRelation.AreFriends IS NULL
								   AND FriendRelation.AreFriends = 2
								   LIMIT 0 , 100");

	echo mysqli_error($conUser)."<br/>";						   
	
	$num1 = mysqli_num_rows($res1);
	$num2 = mysqli_num_rows($res2);
	$num3 = mysqli_num_rows($res3);
	
	echo"<div id='right'>";
	
	// Tabellenbeginn
	echo "<table cellspacing='10px' style='margin:auto;' >";
	$i= 1;
	while ($dsatz = mysqli_fetch_assoc($res1)){
		$name= $dsatz["vorname"]."<br/>".$dsatz["name"];
		echo "<tr>";
		echo "<td class='friend_block'><a class='friend_link' href='../Pages/Profil.php?a=".$dsatz['ID']."'><div id='profilPicCrop'><img id='profilcrop' src='../Pictures/Thumbnails/".$dsatz["profilPic"]."'></div>$name</a></td>";

		echo "</tr>";
	}
	while ($dsatz = mysqli_fetch_assoc($res2)){
		$name= $dsatz["vorname"]."<br/>".$dsatz["name"];
		echo "<tr>";
		echo "<td class='friend_block'><a class='friend_link' href='../Pages/Profil.php?a=".$dsatz['ID']."'><div id='profilPicCrop'><img id='profilcrop' src='../Pictures/Thumbnails/".$dsatz["profilPic"]."'></div>$name</a></td>";

		echo "</tr>";
	}
	while ($dsatz = mysqli_fetch_assoc($res3)){
		$name= $dsatz["vorname"]."<br/>".$dsatz["name"];
		echo "<tr>";
		echo "<td class='friend_block'><a class='friend_link' href='../Pages/Profil.php?a=".$dsatz['ID']."'><div id='profilPicCrop'><img id='profilcrop' src='../Pictures/Thumbnails/".$dsatz["profilPic"]."'></div>$name</a></td>";

		echo "</tr>";
	}
	// Tabellenende
	
	echo "</table>";
	echo "</div>";
	mysqli_close($conUser);
?>