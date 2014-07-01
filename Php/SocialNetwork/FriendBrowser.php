<?php
include "../Php/Misc/GetYourData.php"; 
include "../Templates/MYSQLConnectionString.php";
$res = mysqli_query($conUser,"SELECT * FROM user where plz = ".$dsatz['plz']." and ID != ".$dsatz['ID']);
$num = mysqli_num_rows($res);
echo"<div id='right'>";
// Tabellenbeginn
echo "<table cellspacing='10px' style='float:right;' >";
$i= 1;
while (($dsatz = mysqli_fetch_assoc($res)) && ($i <= 5))
{
$name= $dsatz["vorname"]." ".$dsatz["name"];
echo "<tr>";
echo "<td class='friend_block'><a class='friend_link' href='../Pages/Profil.php?a=".$dsatz['ID']."'><div id='profilPicCrop'><img id='profilcrop' src='../Pictures/Thumbnails/".$dsatz["profilPic"]."'>".$name."</div></a></td>";
echo "</tr>";
$i ++;
}
// Tabellenende
echo "</table>";
echo "</div>";
mysqli_close($conUser);
?>
