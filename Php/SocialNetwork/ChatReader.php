<?php
	session_start();
	include "../../Php/Misc/GetYourData.php";
	include "../../Templates/MYSQLConnectionString.php";
	
	$ID2 = $_GET['a'];
	
	$res = mysqli_query($conUser,"SELECT *
								  FROM messages
								  WHERE messages.UserId1 = $ID
								  AND messages.UserId2 = $ID2
								  OR messages.UserId1 = $ID2
								  AND messages.UserId2 = $ID");
	
	
	$num = mysqli_num_rows($res);

	//echo "&nbsp;"; //Float-Fix
	echo "<span>".$num."</span>";
	
	if ($num > 0){
		// Tabellenbeginn
		while ($dsatz = mysqli_fetch_assoc($res)){
		
			include "../../Php/Misc/GetTime.php";
			
			if($dsatz['UserId1'] == $ID){
				echo "<div class='chatelement right'>";
			}
			elseif($dsatz['UserId1'] == $ID2){
				echo "<div class='chatelement left'>";
			}
			echo "<div class='text'>".nl2br($dsatz['nachricht'])."</div>";
			echo "<div class='datum'>$zeit</div>";
			echo "</div>";
		}
		// Tabellenende
	}
	else{
		echo "<p>Keine Nachrichten vorhanden</p>";
	}
	mysqli_close($conUser);
?>
