<?php
include "../Php/Misc/GetYourData.php"; 
include "../../Templates/MYSQLConnectionString.php";
$res = mysqli_query($conUser,"SELECT * FROM user where ID != $ID");
$num = mysqli_num_rows($res);
echo"<div id='right'>";
echo"<p>Benachrichtigungen</p>";
// Tabellenbeginn
echo "<table cellspacing='10px' style='float:right;' >";
while ($dsatz = mysqli_fetch_assoc($res))
{
$name= $dsatz["vorname"] ."</br>".$dsatz["name"] ;
echo "<tr>";
echo "<td class='friend_block'><a class='friend_link' href='../Pages/Profil.php?a=".$dsatz['ID']."'>".$name."</a></td>";
echo "</tr>";
}
// Tabellenende
echo "</table>";
echo "</div>";
mysqli_close($conUser);
?>