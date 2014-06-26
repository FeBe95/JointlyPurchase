<?php
include "../Php/Misc/GetYourData.php"; 
include "../Templates/MYSQLConnectionString.php";
$res = mysqli_query($conUser,"SELECT DISTINCT Notifications.NotificationType, Notifications.UserId1, Notifications.UserId2, Notifications.Status, Notifications.date, produkte.item_id, produkte.list_id, produkte.getFromUser, user.name, user.vorname, user.ID, einkaufslisten.userID, einkaufslisten.listName, einkaufslisten.listID
FROM Notifications
INNER JOIN produkte ON Notifications.userId1 = produkte.getFromUser
INNER JOIN user ON produkte.getFromUser = user.ID
INNER JOIN einkaufslisten ON produkte.list_id = einkaufslisten.listID
WHERE Notifications.NotificationType =2 && Notifications.UserId2 =".$ID."
ORDER BY Notifications.date DESC
LIMIT 0 , 30");
$num = mysqli_num_rows($res);
$i = 0;
if ($num >0)
{
// Tabellenbeginn
echo "<table cellspacing='10px' style='width:100%;' >";
while ($dsatz = mysqli_fetch_assoc($res))
	{
	$name= "<a style='margin:0px;' href='../Pages/Profil.php?a=".$dsatz["ID"]."'>".$dsatz["vorname"] ." ".$dsatz["name"]."</a>" ;
	echo "<tr>";
	echo "<td id='friend_req_block'><p style='font-size:12px;margin-bottom:0px;'>".$dsatz["date"]."</p><p style='font-size:14px;margin-top:0px;'>".$name." möchte dir ein Produkt aus deiner Einkaufsliste : ".$dsatz["listName"]." mitbringen.</p></td>";
	echo "</tr>";
	}
// Tabellenende
echo "</table>";
}else
{
	echo"<p style='font-style:italic; font-size:12px;'> Du hast zurzeit keine Benachrichtigungen </p>";
}
mysqli_close($conUser);
?>
<!--<form name="friend_req" id="friend_req" method="post" action="FriendRequestModifier.php">
    <input name='id' type='hidden' />
    <input name='change' type='hidden' />
</form>-->
