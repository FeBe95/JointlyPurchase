<?php
	session_start();
	include "../Misc/GetYourData.php";
	include "../../Templates/MYSQLConnectionString.php";
	
	$friendID = $_POST['friendID'];
	// Check connection
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	mysqli_query($conUser,"INSERT FriendRelation (AreFriends,UserId1,UserId2) values ('1','$ID','$friendID')");
	header( "Location: ../../Pages/Profil.php?a=$friendID" );
	mysqli_close($conUser);
?>
