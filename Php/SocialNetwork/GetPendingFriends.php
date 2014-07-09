<?php
	include "../Php/Misc/GetFriendData.php";
	include "../Templates/MYSQLConnectionString.php";
	$res1 = mysqli_query($conUser,"SELECT
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
								   WHERE FriendRelation.AreFriends = 1
								   AND FriendRelation.UserId1 = $ID2
								   
								   UNION
								   
								   SELECT
								   FriendRelation.AreFriends,
								   FriendRelation.UserId1,
								   FriendRelation.UserId2,
								   user.ID,
								   user.name,
								   user.vorname,
								   user.profilPic
								   FROM FriendRelation
								   INNER JOIN user
								   ON FriendRelation.UserId1 = user.ID
								   WHERE FriendRelation.AreFriends = 1
								   AND FriendRelation.UserId2 = $ID2");
								   
	$num1 = mysqli_num_rows($res1);
	
	if ($ID2 == $ID && $num1>0){
		echo"<div id='right'>";
		echo"<h1>Austehende Anfragen:</h1>";
		
		while ($dsatz1 = mysqli_fetch_assoc($res1)){
			$name= $dsatz1["vorname"]."<br/>".$dsatz1["name"] ;
			echo "<div class='friend_block'>";
			echo "<a class='friend_link' href='../Pages/Profil.php?a=".$dsatz1['ID']."'>
					<div id='profilPicCrop'>
						<img id='profilcrop' src='../Pictures/Thumbnails/".$dsatz1["profilPic"]."'>
					</div>
					$name
				  </a>";
			echo "</div>";
		}
		echo "</div>";
	}
	mysqli_close($conUser);
?>
