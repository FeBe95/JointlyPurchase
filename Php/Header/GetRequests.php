<?php
	include "../Php/Misc/GetYourData.php"; 
	include "../Templates/MYSQLConnectionString.php";
	
	$res = mysqli_query($conUser,"SELECT
								  user.vorname,
								  user.name,
								  user.ID
								  FROM FriendRelation
								  NATURAL JOIN user
								  WHERE FriendRelation.UserId1 = ID
								  AND FriendRelation.UserId2 = $ID
								  AND FriendRelation.AreFriends = 1");
								  
	$num = mysqli_num_rows($res);

	if ($num > 0){
		echo "<div id='badge1' class='notification-badge'>$num</div>";
		echo "<div id='HeadPopUpBox1' class='HeadPopUp'>";
		echo "<div class='PopUpArrow'></div>";
		echo "<p class='PopUpHeader'>Freundschaftsanfragen</p>";
	
		// Tabellenbeginn
		echo "<table cellspacing='0px' class='PopUpTable' >";
		while ($dsatz = mysqli_fetch_assoc($res)){
			$name = "<a href='../Pages/Profil.php?a=".$dsatz["ID"]."'>".$dsatz["vorname"]." ".$dsatz["name"]."</a>" ;
			echo "<tr>
					<td class='headerBlock notification request'>
						<span class='friendrequestName'>$name</span>
						<div title='Ablehnen' onClick='friendrequest(2,".$dsatz["ID"].");' class='icon cross floatRight'></div>
						<div title='Annehmen' onClick='friendrequest(1,".$dsatz["ID"].");' class='icon checkmark floatRight'></div>
					</td>
				  </tr>";
		}
		// Tabellenende
		echo "</table>";
	}
	else{
		echo "<div id='HeadPopUpBox1' class='HeadPopUp'>";
		echo "<div class='PopUpArrow'></div>";
		echo "<p class='PopUpHeader'>Freundschaftsanfragen</p>";
		echo"<p style='padding:10px;margin:0;font-style:italic; font-size:12px;'>Du hast zurzeit keine Freundschaftsanfragen</p>";
	}
	echo "</div>";
	mysqli_close($conUser);
?>

<form name="friend_req" method="post" action="../Php/SocialNetwork/FriendRequestModifier.php">
    <input name="id" type="hidden" />
    <input name="change" type="hidden" />
</form>

<script>
	function friendrequest(ak,id){
		if (ak==1){
			document.friend_req.id.value = id;
			document.friend_req.change.value = "accept";
			document.friend_req.submit();
		}
		if (ak==2){
			document.friend_req.id.value = id;
			document.friend_req.change.value = "decline";
			document.friend_req.submit();		
		}
	}
</script>