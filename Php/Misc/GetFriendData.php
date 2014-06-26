<?php
	$ID2 = $_REQUEST['a'];
	include "../Templates/MYSQLConnectionString.php";
    $querry="SELECT * FROM user WHERE ID = '$ID2' ";
    $res= mysqli_query($conUser,$querry);
    $dsatz=mysqli_fetch_assoc($res);
	
	$vorname_friend=$dsatz["vorname"];
	$nachname_friend=$dsatz["name"];
	$email_friend=$dsatz["email"];
	$plz=$dsatz["plz"];
	mysqli_close($conUser);
?>