<?php
	include "../Php/Misc/GetYourData.php";
	include "../Templates/MYSQLConnectionString.php";
	
	if(isset($_GET['q']) && $_GET['q'] != ""){
		$q = $_GET['q'];
	}
	else{
		echo "<p style='text-align:center;font-size:20px'>Bitte gib einen Suchbegriff ein!</p>";
		echo "<p style='text-align:center'><a href='Home.php'>Zurück zur Startseite</a></p>";
		exit;
	}
	
	$res1 = mysqli_query($conUser,"SELECT
								  user.ID,
								  user.name,
								  user.vorname,
								  user.profilPic
								  FROM user
								  WHERE (user.vorname LIKE '%$q%'
								  OR user.name LIKE '%$q%'
								  OR user.plz LIKE '%$q%')
								  AND user.ID != $ID");
								  
	$res2 = mysqli_query($conUser,"SELECT
								  user.ID,
								  einkaufslisten.listName
								  FROM user
								  JOIN einkaufslisten
								  ON user.ID = einkaufslisten.userID
								  WHERE einkaufslisten.listName LIKE '%$q%'
								  AND user.ID = $ID");
	
	$num1 = mysqli_num_rows($res1);
	$num2 = mysqli_num_rows($res2);
	
	echo"<div id='right'>";
	echo"<h1>Suchergebnisse zu \"$q\":</h1>";

	if ($num1+$num > 0){
		// Tabellenbeginn
		echo "<table cellspacing='10px' style='margin:0 auto;' >";
		while ($dsatz1 = mysqli_fetch_assoc($res1)){
			$name= $dsatz1["vorname"]."<br/>".$dsatz1["name"] ;
			echo "<tr>";
			echo "<td class='friend_block'>
					<a class='friend_link' href='../Pages/Profil.php?a=".$dsatz1['ID']."'>
						<div id='profilPicCrop'>
							<img id='profilcrop' src='../Pictures/Thumbnails/".$dsatz1["profilPic"]."'>
						</div>
						$name
					</a>
				  </td>";
				  
			$ID2 = $dsatz1['ID'];
			echo "<td style='text-align:left;padding-left: 50px;'>";
			include "../Php/SocialNetwork/RelationButton.php";
			echo "</td>";
			echo "</tr>";
		}
		while ($dsatz2 = mysqli_fetch_assoc($res2)){
			echo "<tr>";
			echo "<td class='friend_block'>";
			echo "<a class='friend_link' href='ShoppinglistEditor.php?list=".$dsatz2['listName']."'>Einkaufsliste<br/>".$dsatz2['listName']."</a>";
			echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
		// Tabellenende
	}
	else{
		echo "<p>Deine Suche hat leider zu keinem Ergebnis geführt.</p>";
	}
	echo "</div>";
	mysqli_close($conUser);
?>
