<?php
	include "../Php/Misc/GetFriendData.php";
	include "../Templates/MYSQLConnectionString.php";
	$res1 = mysqli_query($conUser,"SELECT FriendRelation.AreFriends, FriendRelation.UserId1, FriendRelation.UserId2, user.ID, user.name, user.vorname, user.profilPic
		FROM FriendRelation
		INNER JOIN user ON FriendRelation.UserId2 = user.ID
		WHERE FriendRelation.AreFriends = 1
		AND FriendRelation.UserId1 = ".$ID2." 
		LIMIT 0 , 10");  // nur die ersten 5 Freunde anzeigen
	
	$res2 = mysqli_query($conUser,"SELECT FriendRelation.AreFriends, FriendRelation.UserId1, FriendRelation.UserId2, user.ID, user.name, user.vorname, user.profilPic
		FROM FriendRelation
		INNER JOIN user ON FriendRelation.UserId1 = user.ID
		WHERE FriendRelation.AreFriends = 1
		AND FriendRelation.UserId2 = ".$ID2." 
		LIMIT 0 , 10");  // nur die ersten 5 Freunde anzeigen
	
	$num1 = mysqli_num_rows($res1);
	$num2 = mysqli_num_rows($res2);
	
	if ($ID2 == $ID && $num1+$num2>0){
		echo"<div id='right'>";
		echo"<h1>Austehende Anfragen:</h1>";
		// Tabellenbeginn
		echo "<table cellspacing='10px' style='margin:0 auto;' >";
		while ($dsatz1 = mysqli_fetch_assoc($res1)){
			$name= $dsatz1["vorname"]." ".$dsatz1["name"] ;
			echo "<tr>";
			echo "<td class='friend_block'><a class='friend_link' href='../Pages/Profil.php?a=".$dsatz1['ID']."'><div id='profilPicCrop'><img id='profilcrop' src='../Pictures/Thumbnails/".$dsatz1["profilPic"]."'></div>".$name."</a></td>";
			echo "</tr>";
			$i ++;
		}
		while ($dsatz2 = mysqli_fetch_assoc($res2)){
			$name= $dsatz2["vorname"]." ".$dsatz2["name"] ;
			echo "<tr>";
			echo "<td class='friend_block'><a class='friend_link' href='../Pages/Profil.php?a=".$dsatz2['ID']."'><div id='profilPicCrop'><img id='profilcrop' src='../Pictures/Thumbnails/".$dsatz2["profilPic"]."'></div>".$name."</a></td>";
			echo "</tr>";
			$i ++;
		}
		// Tabellenende
		
		echo "</table>";
		echo "</div>";
	}
	mysqli_close($conUser);
?>
