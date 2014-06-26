<?php
session_start();
include "../Misc/GetYourData.php";
include "../../Templates/MYSQLConnectionString.php";
$table = $_POST['list'] ;
$listID = md5($table.$ID);
$abf1 = mysqli_query($conUser,"SELECT * FROM einkaufslisten WHERE listName = '".$table."'&& userID = ".$ID."");
$abf4 = "INSERT einkaufslisten (userID,listName,listID) values ('".$ID."','".$table."','".$listID."')";
//$abf6 = "SELECT listID FROM einkaufslisten WHERE userID = ".$ID."";
if(mysqli_num_rows($abf1)=== 0 && $_POST['list'] != "")
{
	
	if (!(empty($_POST["list"]))){
		$_SESSION["list"] = $_POST["list"];
		mysqli_query($conUser,$abf4);
		}
	header( 'Location: ../../Pages/ShoppinglistEditor.php' ) ; 
}elseif($_POST['list'] != "")
{
	header( 'Location: ../../Pages/Home.php?f=error&n='.$table.'' ) ; 
	
}
mysqli_close($conUser);
?>