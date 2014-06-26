<?php
session_start();
include "../Misc/GetYourData.php";
include "../../Templates/MYSQLConnectionString.php";

$friendID=$_POST['id'];
$change=$_POST['change'];
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
if ($change === "accept")
{
mysqli_query($conUser,"UPDATE FriendRelation SET AreFriends='2' WHERE UserId1=".$friendID." && UserId2=".$ID."");
mysqli_query($conUser,"UPDATE Notifications SET Status='3' WHERE UserId1=".$friendID." && UserId2=".$ID."");
}else
{
mysqli_query($conUser,"UPDATE FriendRelation SET AreFriends='3' WHERE UserId1=".$friendID." && UserId2=".$ID."");
mysqli_query($conUser,"UPDATE Notifications SET Status='3' WHERE UserId1=".$friendID." && UserId2=".$ID."");
}
header( 'Location:'.$_SERVER["HTTP_REFERER"].'' );
mysqli_close($conUser);
?>
