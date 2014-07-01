<?php
<<<<<<< HEAD
	include "../Php/Misc/GetYourData.php"; 
	include "../Templates/MYSQLConnectionString.php";
	
	$res = mysqli_query($conUser,"SELECT * FROM user where plz = ".$dsatz['plz']." and ID != ".$dsatz['ID']);
	$num = mysqli_num_rows($res);
	
	echo"<div id='right'>";
	
	// Tabellenbeginn
	echo "<table cellspacing='10px' style='margin:auto;' >";
	$i= 1;
	while (($dsatz = mysqli_fetch_assoc($res)) && ($i <= 5)){
		$name= $dsatz["vorname"]."<br/>".$dsatz["name"];
		echo "<tr>";
		echo "<td class='friend_block'><a class='friend_link' href='../Pages/Profil.php?a=".$dsatz['ID']."'><div id='profilPicCrop'><img id='profilcrop' src='../Pictures/Thumbnails/".$dsatz["profilPic"]."'></div>".$name."</a></td>";

		echo "</tr>";
		$i++;
	}
	// Tabellenende
	
	echo "</table>";
	echo "</div>";
	mysqli_close($conUser);
=======
include "../Php/Misc/GetYourData.php"; 
include "../Templates/MYSQLConnectionString.php";
$res = mysqli_query($conUser,"SELECT * FROM user where plz = ".$dsatz['plz']." and ID != ".$dsatz['ID']);
$num = mysqli_num_rows($res);
echo"<div id='right'>";
// Tabellenbeginn
echo "<table cellspacing='10px'>";
$i= 1;
while (($dsatz = mysqli_fetch_assoc($res)) && ($i <= 5))
{
$name=  $dsatz["vorname"]." ".$dsatz["name"];
echo "<tr>";
echo "<td class='friend_block'><a class='friend_link' href='../Pages/Profil.php?a=".$dsatz['ID']."'><div id='profilPicCrop'><img id='profilcrop' src='../Pictures/Thumbnails/".$dsatz["profilPic"]."'><span style='vertical-align:top;margin-left:10px;'>".$name."</span></div></a></td>";
echo "</tr>";
$i ++;
}
// Tabellenende
echo "</table>";
echo "</div>";
mysqli_close($conUser);
>>>>>>> origin/master
?>
