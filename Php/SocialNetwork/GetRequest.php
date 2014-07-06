<?php
	include "../Php/Misc/GetYourData.php"; 
	include "../Templates/MYSQLConnectionString.php";
	
	$res = mysqli_query($conUser,"SELECT
								  user.vorname,
								  user.name,
								  user.ID
								  FROM FriendRelation
								  NATURAL JOIN user
								  WHERE FriendRelation.UserId1 = ID && FriendRelation.UserId2 = $ID && FriendRelation.AreFriends = 1");
	$num = mysqli_num_rows($res);

	if ($num > 0){
		echo "<div id='badge1' class='notification-badge'>$num</div>";
		echo "<div id='HeadPopUpBox' class='HeadPopUp'>";
		echo "<p class='PopUpHeader'>Freundschaftsanfragen</p>";
	
		// Tabellenbeginn
		echo "<table cellspacing='10px' class='PopUpTable' >";
		while ($dsatz = mysqli_fetch_assoc($res)){
			$name= "<a style='margin:0px;' href='../Pages/Profil.php?a=".$dsatz["ID"]."'>".$dsatz["vorname"]." ".$dsatz["name"]."</a>" ;
			echo "<tr>";
			echo "<td class='friend_req_block requests'>".$name;
			echo "<a title='Ablehnen' href='javascript:friendrequest(2,".$dsatz["ID"].");'>";
			echo "<img style='margin:0px 10px;' class='del_Image' src='../Pictures/SiteContent/cross.svg'>";
			echo "</a>";
			echo "<a title='Annehmen' href='javascript:friendrequest(1,".$dsatz["ID"].");'>";
			echo "<img style='margin:0px 10px;' class='del_Image' src='../Pictures/SiteContent/tick.svg'>";
			echo "</a>";
			echo "</td>";
			echo "</tr>";
		}
		// Tabellenende
		echo "</table>";
	}
	else{
		echo "<div id='HeadPopUpBox' class='HeadPopUp'>";
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