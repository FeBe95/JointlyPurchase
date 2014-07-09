<?php
	include "../Templates/MYSQLConnectionString.php";
	
	$relationStatus = mysqli_query($conUser,"SELECT
											 AreFriends,
											 UserId1,
											 UserId2
											 FROM FriendRelation
											 WHERE UserId1 = $ID2
											 AND UserId2 = $ID
											 OR UserId1 = $ID
											 AND UserId2 = $ID2");
	 
	$num = mysqli_num_rows($relationStatus);
	
	$case = 0;
	
	if ($num > 0){
		$relation = mysqli_fetch_assoc($relationStatus);
		$case = $relation["AreFriends"];
	}
	if($ID2 == $ID){
		echo '<h1>Das bist du:<a href="../Pages/ProfilSettings.php"><img style="width:20px;margin-left:20px;" src="../Pictures/SiteContent/new.svg"></a></h1>';
	}
	elseif($num == 0){
		echo "<form method='post' action='../Php/SocialNetwork/AddRelation.php'>";
		echo "<input name='friendID' type='hidden' value='".$ID2."'/>";
		echo "<button class='relationbutton' type='submit'>Als Freund hinzufügen</button>";
		echo "</form>";
		echo "<br/>";
	}
	switch($case){
		case 1:
			if($relation["UserId2"] == $ID){
				echo "<form method='post' action='../Php/SocialNetwork/FriendRequestModifier.php'>";
				echo "<input name='change' type='hidden' value='accept'/>";
				echo "<input name='id' type='hidden' value='".$relation["UserId1"]."'/>";
				echo "<button class='relationbutton' type='submit'>Freundschaftsanfrage annehmen</button>";
				echo "</form>";
				echo "<br/>";
			}
			else{
				echo "<span class='relationlabel relationbutton'>Freundschaftsanfrage versendet</span>";
				echo "<br/>";
			}
			break;
		case 2:
			echo "<form method='post' action='../Php/SocialNetwork/DeleteRelation.php'>";
			echo "<input name='friendID' type='hidden' value='$ID2'/>";
			echo "<button class='relationbutton' type='submit'>Freund entfernen</button>";
			echo "</form>";
			echo "<br/>";
		break;
		case 3:
			echo "<form method='post' action='../Php/SocialNetwork/AddRelation.php'>";
			echo "<input name='friendID' type='hidden' value='$ID2'/>";
			echo "<button class='relationbutton' type='submit'>Als Freund hinzufügen</button>";
			echo "</form>";
			echo "<br/>";
		break;
	}
?>