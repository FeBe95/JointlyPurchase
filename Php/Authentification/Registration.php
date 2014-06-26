<?php
				session_start();
                include "../../Templates/MYSQLConnectionString.php";
                //$pw=md5($_POST['Pw']);
				$mailcheck = mysqli_query($conUser,"SELECT email FROM user WHERE email ='".$_POST['Email']."'");
				$mailres = mysqli_num_rows($mailcheck);
				if ($mailres !== 0)
				{
					header('Location:../../Pages/NewAccount.php?e=1&n='.$_POST['Name'].'&v='.$_POST['Vname'].'&em='.$_POST['Email'].'&p='.$_POST['Plz'].'');
				}elseif ($_POST['Name'] != '' || $_POST['Vname'] != '' || $_POST['Email'] != '' ||  md5($_POST['Pw']) != '')
                {
				$abf1 = "INSERT user(name,vorname,email,plz,passwort) values ('".@$_POST['Name']."','".@$_POST['Vname']."','".@$_POST['Email']."','".@$_POST['Plz']."','".md5($_POST['Pw'])."')";
                mysqli_query($conUser,$abf1);
				$abf2="SELECT ID FROM user WHERE email = '".$_POST['Email']."'";
				$res= mysqli_query($conUser,$abf2);
				$dsatz=mysqli_fetch_assoc($res);
				$ID=$dsatz["ID"];

                $num = mysqli_affected_rows();
                    if($num >= 0)
                    {
						$_SESSION["login"] = $ID;
                		header( 'Location: ../../Pages/Home.php' ) ; 
					}
                    else
                    {
                        echo "Es ist ein Fehler aufgetreten! Bitte korrigieren Sie ihre Angaben.";
                    }
                }
                else
                {
                    header( 'Location: ../../index.php' ) ;
                }
				mysqli_close($conUser);
?>
