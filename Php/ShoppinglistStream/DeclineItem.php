<?php
session_start();
include "../Misc/GetYourData.php";
include "../../Templates/MYSQLConnectionString.php";

$ItemID=$_POST['itemId'];
$ListID=$_POST['listId'];
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$res = mysqli_query($conUser,"SELECT einkaufslisten.userID,user.ID,user.name,user.vorname FROM einkaufslisten JOIN user WHERE user.ID=einkaufslisten.userID && einkaufslisten.listID='".$ListID."'");
$result = mysqli_fetch_assoc($res);
mysqli_query($conUser,"UPDATE Listen SET getFromUser= 0 WHERE item_id =".$ItemID."");
mysqli_query($conUser,"DELETE FROM Notifications WHERE Notification =".$ItemID."");
header( 'Location: ../../Pages/Home.php' );
mysqli_close($conUser);
?>