<?php
	include "../Php/Misc/GetFriendData.php";
	include "../Templates/MYSQLConnectionString.php";
	$res1 = mysqli_query($conUser,"SELECT FriendRelation.AreFriends, FriendRelation.UserId1, FriendRelation.UserId2, user.ID, user.name, user.vorname, user.profilPic
		FROM FriendRelation
		INNER JOIN user ON FriendRelation.UserId2 = user.ID
		WHERE FriendRelation.AreFriends = 2
		AND FriendRelation.UserId1 = ".$ID2." 
		LIMIT 0 , 100");  // nur die ersten 10 Freunde anzeigen
	
	$res2 = mysqli_query($conUser,"SELECT FriendRelation.AreFriends, FriendRelation.UserId1, FriendRelation.UserId2, user.ID, user.name, user.vorname, user.profilPic
		FROM FriendRelation
		INNER JOIN user ON FriendRelation.UserId1 = user.ID
		WHERE FriendRelation.AreFriends = 2
		AND FriendRelation.UserId2 = ".$ID2." 
		LIMIT 0 , 100");  // nur die ersten 10 Freunde anzeigen
	
	$num1 = mysqli_num_rows($res1);
	$num2 = mysqli_num_rows($res2);
	
	echo"<div id='right'>";
	if ($ID2 == $ID){
		echo"<h1>Deine Freunde:</h1>";
	}
	else{
		echo"<h1>Freunde von ".$vorname_friend.":</h1>";
	}

	// Tabellenbeginn
	echo "<table cellspacing='10px' style='margin:0 auto;' >";
	while ($dsatz1 = mysqli_fetch_assoc($res1)){
		$name= $dsatz1["vorname"]."<br/>".$dsatz1["name"] ;
		echo "<tr>";
		echo "<td class='friend_block'><a class='friend_link' href='../Pages/Profil.php?a=".$dsatz1['ID']."'><div id='profilPicCrop'><img id='profilcrop' src='../Pictures/Thumbnails/".$dsatz1["profilPic"]."'></div>".$name."</a></td>";
		echo "</tr>";
	}
	while ($dsatz2 = mysqli_fetch_assoc($res2)){
		$name= $dsatz2["vorname"]."<br/>".$dsatz2["name"] ;
		echo "<tr>";
		echo "<td class='friend_block'><a class='friend_link' href='../Pages/Profil.php?a=".$dsatz2['ID']."'><div id='profilPicCrop'><img id='profilcrop' src='../Pictures/Thumbnails/".$dsatz2["profilPic"]."'></div>".$name."</a></td>";
		echo "</tr>";
	}
	// Tabellenende
	
	echo "</table>";
	echo "</div>";
	mysqli_close($conUser);
?>
