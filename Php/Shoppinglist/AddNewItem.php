<?php
							session_start();
							include "../Misc/GetYourData.php";
							include "../../Templates/MYSQLConnectionString.php";
							
							
							//Variables//
							$info_br = wordwrap(@$_POST['info'], 40, "\n", true );
							$row = mysqli_num_rows($abf1);
							$table = $_SESSION["list"];
							$listID = md5($table.$ID);
							
							date_default_timezone_set('Europe/Berlin');
							$timestamp = time();
							$datum = date("d.m.Y",$timestamp);
							$uhrzeit = date("H:i",$timestamp);
							$date = "".$datum." - ".$uhrzeit."";

							
							//SQL_Querrys//
							$abf1 = mysqli_query($conUser,"select * from produkte WHERE user_id = ".$ID."");
							$abf2 = "INSERT produkte (product,amount,maxPrice,info,list_id) values ('".@$_POST['product']."','".@$_POST['amount']."','".@$_POST['maxPrice']."','".@$info_br."','".$listID."')";
							$abf3 = "DELETE FROM produkte where item_id = '".@$_POST['id']."'";
							
							$abf5 = "DELETE FROM produkte WHERE list_id = '".$listID."'";
							
							$abf7 = "DELETE FROM einkaufslisten WHERE listID = '".$listID."'";
							$abf8 = "UPDATE einkaufslisten SET date='".$date."' WHERE listID ='".$listID."'";
							
							
							
							
							////Check if database exist//
//							$result = mysqli_query($conUser,$abf6);
//							if(mysqli_num_rows($result) > 0){
//							   //header( 'Location: home.php' ) ;
//							   
//							}
//							else{
//							   mysqli_query($conUser,$abf4);
//							   
//							}

							//Delete data in database//
							if($_POST["ak"]=="deleteItem"){
								mysqli_query($conUser,$abf3);
								mysqli_query($conUser,$abf8);
								header( 'Location: ../../Pages/ShoppinglistEditor.php' );
							}
							
							//Delete shoppinglist//
							elseif(@$_POST["ak"]=="deleteList"){
								mysqli_query($conUser,$abf5);
								mysqli_query($conUser,$abf7);
								header( 'Location: ../../Pages/Home.php' );
							}
													
							//Write data in database//
							elseif (@$_POST['product'] && $_POST['amount'] && $_POST['maxPrice'] != ''){
								mysqli_query($conUser,$abf2);
								mysqli_query($conUser,$abf8);
								header( 'Location: ../../Pages/ShoppinglistEditor.php' );
							}
								
						
							mysqli_close($conUser); 
							
							?>