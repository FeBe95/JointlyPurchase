<?php
	include "../Php/Misc/GetYourData.php"; 
	include "../Templates/MYSQLConnectionString.php";
	
	$res = mysqli_query($conUser,"SELECT
								  user.ID,
								  user.name,
								  user.vorname,
								  user.profilPic
								  FROM user
								  WHERE user.plz = $plz
								  AND user.ID != $ID");
	
	$num1 = mysqli_num_rows($res);				   
	
	echo "<div id='results' style='display:block'>";
	echo "Leute aus Deiner Nähe:";
	// Tabellenbeginn
	
	if ($num1 > 0){
		// Tabellenbeginn
		echo "<table cellspacing='10px' style='margin:0 auto;' >";
		while ($dsatz1 = mysqli_fetch_assoc($res)){
			$ID2 = $dsatz1["ID"];
			$name= $dsatz1["vorname"]."<br/>".$dsatz1["name"] ;
			
			$relationStatus = mysqli_query($conUser,"SELECT
													 AreFriends,
													 UserId1,
													 UserId2
													 FROM FriendRelation
													 WHERE UserId1 = $ID2
													 AND UserId2 = $ID
													 OR UserId1 = $ID
													 AND UserId2 = $ID2");
			
			$num2 = mysqli_num_rows($relationStatus);
			
			$relation = mysqli_fetch_assoc($relationStatus);
			$case = $relation["AreFriends"];
			
			if($case != 2){
				echo "<tr>";
				echo "<td class='friend_block'>";
				echo "<a class='friend_link' href='../Pages/Profil.php?a=".$dsatz1['ID']."'>
						<div id='profilPicCrop'>
							<img id='profilcrop' src='../Pictures/Thumbnails/".$dsatz1["profilPic"]."'>
						</div>
						$name
					  </a>";
				echo "</td>";
				echo "</tr>";
			}
		}
		echo "</table>";
		// Tabellenende
	}

	if ($num1 == 0) {
		echo "<div class='friend_block_empty'>
				<p>Es konnten keine weiteren Nutzer in deiner Umgebung gefunden werden.</p>
				<p>Um dies zu ändern schicke deinen Freunden doch einfach eine Einladung<p>
		      </div>";
	}
		
	// Tabellenende

	echo "</div>";
	mysqli_close($conUser);
?>