<?php
session_start();
include "../Misc/GetYourData.php";
include "../../Templates/MYSQLConnectionString.php";

$friendID=$_POST['friendID'];
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
echo $friendID ;
mysqli_query($conUser,"DELETE FROM FriendRelation WHERE UserId1=".$ID." && UserId2=".$friendID."");
mysqli_query($conUser,"DELETE FROM FriendRelation WHERE UserId1=".$friendID." && UserId2=".$ID."");
header( 'Location: ../../Pages/Profil.php?a='.$friendID.'' );
mysqli_close($conUser);
?>
