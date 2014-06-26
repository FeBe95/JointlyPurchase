<?php
	$path = $_SERVER['DOCUMENT_ROOT'] ;
	$path.= "/jp/Templates/MYSQLConnectionString.php";
	include $path;
	//$userID = $_SESSION['login'];
    $query="SELECT * FROM user WHERE ID = ".$_SESSION['login']."";
    $res= mysqli_query($conUser,$query);
    $dsatz=mysqli_fetch_assoc($res);
	
	$vorname=$dsatz["vorname"];
	$nachname=$dsatz["name"];
	$email=$dsatz["email"];
	$plz=$dsatz["plz"];
	$ID=$dsatz["ID"];
	mysqli_close($conUser);

?>