<?php
				session_start();
                include "../../Templates/MYSQLConnectionString.php";
				$stmt = mysqli_stmt_init($conUser);
				$i=0;
				If (mysqli_stmt_prepare($stmt, 'SELECT email FROM user WHERE email = ?')){
					mysqli_stmt_bind_param($stmt,'s', $_POST['Email']);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_bind_result($stmt, $email);
					while (mysqli_stmt_fetch($stmt)){
						$i++;
					}
				}
				else{
					header( "Location: ../../Pages/LoginError.php?$redirect" );
				}
				mysqli_stmt_close($stmt);
				if ($i != 0)
				{
					header('Location:../../Pages/NewAccount.php?e=1&n='.$_POST['Name'].'&v='.$_POST['Vname'].'&em='.$_POST['Email'].'&p='.$_POST['Plz'].'');
				}elseif ($_POST['Name'] != '' || $_POST['Vname'] != '' || $_POST['Email'] != '' ||  md5($_POST['Pw']) != ''){
					$stmt = mysqli_stmt_init($conUser);
					If (mysqli_stmt_prepare($stmt, 'INSERT user(name,vorname,email,plz,passwort) VALUES (?, ?, ?, ?, ?)')){
						mysqli_stmt_bind_param($stmt,'sssis', $_POST['Name'], $_POST['Vname'], $_POST['Email'], $_POST['Plz'], md5($_POST['Pw']));
						mysqli_stmt_execute($stmt);
					}
					else{
						header( "Location: ../../Pages/LoginError.php?$redirect" );
					}
					mysqli_stmt_close($stmt);
					$stmt = mysqli_stmt_init($conUser);
					If (mysqli_stmt_prepare($stmt, 'SELECT ID FROM user WHERE email = (?) ')){
						mysqli_stmt_bind_param($stmt,'s',$_POST['Email']);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_bind_result($stmt, $ID);
						mysqli_stmt_fetch($stmt);
						print_r($ID);
					}
					else{
						header( "Location: ../../Pages/LoginError.php?$redirect" );
					}
					mysqli_stmt_close($stmt);
                    if(isset($ID))
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
