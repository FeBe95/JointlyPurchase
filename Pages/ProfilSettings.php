<?php
    session_start();
    include "../Php/Authentification/SessionChecker.php";
    include "../Php/Misc/GetYourData.php";
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <title><?php echo $vorname.' '.$nachname; ?></title>
		
		<meta charset="utf-8" />
        <link rel="stylesheet" type="text/CSS" href="../css/style.css">
        <link rel="stylesheet" type="text/CSS" href="../css/imageuploader.css">
		
		<link href="../css/jquery/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
		<link href="../css/jquery/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
		<link href="../css/jquery/jquery.ui.dialog.min.css" rel="stylesheet" type="text/css">
		<link href="../css/jquery/jquery.ui.resizable.min.css" rel="stylesheet" type="text/css">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script src="../js/BoogyBox.js"></script>
		<script src="../js/imageupload.js"></script>
		<script src="../js/jquery/jquery-ui-1.9.2.dialog.custom.min.js"></script>
		
		<script src="https://raw.githubusercontent.com/malsup/form/master/jquery.form.js"></script>
		
		<script>
			$(function() {
				$( "#fullpiccontainer" ).dialog({
					width:700,
					autoOpen:false,
					modal:true,
					resizable:false,
					draggable: false,
					title:"Profilbild"
				});
				
				$( "#mainProfilPicCrop" ).click(function() {
					$( "#fullpiccontainer" ).dialog( 'open' );
					$( ".ui-widget-overlay" ).click(function() {
						$( "#fullpiccontainer" ).dialog('close');
					});
				});
				
				$( "#create-user" ).click(function() {
					$( "#chooseimage" ).show( 'fast' );
				});
				
				$( "a" ).click(function(event) {
					if(document.updateData.UserEmail.value !="<?php echo $email;?>"||
					document.updateData.UserVorName.value !="<?php echo $vorname;?>"||
					document.updateData.UserNachName.value !="<?php echo $nachname;?>"||
					document.updateData.UserPLZ.value !="<?php echo $plz;?>"||
					document.updateData.neuesPW.value !=""||
					document.updateData.neuesPWwiederholen.value !=""){
						if (confirm("Bearbeitung abbrechen?")){
							location.href = event.target.href;
						}
						else{
							return false;
						}
					}
				});
			});
			
			function checkPW(){
				var nPW = document.getElementsByName('neuesPW')[0].value;
				var nPWw = document.getElementsByName('neuesPWwiederholen')[0].value;
				var tick = document.getElementById('PWchecked');
				var PWsm = document.getElementById('pwsubmit');
				
				if(nPW == "" || nPWw == ""){
					tick.style.display = "none";
					PWsm.disabled = true;
				}
				if(nPW == nPWw && nPW != ""){
					tick.style.display = "block";
					PWsm.disabled = false;
					return true;
				}
				if(nPW != nPWw && nPW != ""){
					tick.style.display = "none";
					PWsm.disabled = true;
					return false;
				}
			}
		</script>
	
    </head>
    <body>
        <?php 
            include "../Templates/HeadTemplate.php";
		?>
		<!--Background DISABLED -->
		<!--<canvas id="bgCanvas" width="1000" Style="position:fixed; top:0px; left:0px;z-index:1;"></canvas>
		<?php
			echo ("<script>");
			echo "";
		?>
		color = new Array("FF9200","BF8230","FFAA00","FFAD40","FFC373");
		<?php
			include "../php/bg.php";
			echo ("</script>");
		?>
		-->
		<div id="mainwindow">
			<?php if(isset($_GET['success'])){ ?>
				<div class="settingsalert success">
					Änderungen erfolgreich gespeichert!
				</div>
			<?php } elseif(isset($_GET['successPW'])){  ?>
				<div class="settingsalert success">
					Daten und neues Passwort erfolgreich gespeichert!
				</div>
			<?php } elseif(isset($_GET['wrongPW'])){  ?>
				<div class="settingsalert error">
					Das alte Passwort war leider nicht korrekt!
				</div>
			<?php } elseif(isset($_GET['PWmismatch'])){  ?>
				<div class="settingsalert error">
					Die Passwörten stimmen nicht überein!
				</div>
			<?php } ?>	
			<table cellpadding="10" cellspacing="10px">
				<tr>
					<td class="contentBlock">
						<div id="main_left">
							<?php 
								include "../Templates/MYSQLConnectionString.php";
								$profilPic= mysqli_query($conUser,"SELECT profilPic FROM user WHERE email = '".$email."'");
								$profilPic = mysqli_fetch_assoc($profilPic);
								echo "<div id='mainProfilPicCrop'><img id='mainProfilCrop' src = '../Pictures/Thumbnails/".$profilPic["profilPic"]."'></div>";
								echo "<div id='fullpiccontainer'><img id='fullpic' src = '../Pictures/ProfilPictures/".$profilPic["profilPic"]."'></div>";
							?>
						</div>
						<br/>
						<button id="create-user" style="width:100%;">Profilbild ändern</button>
					</td>
					<td class="contentBlock" valign="top" style="padding-top:20px;width:650px;">
						<div class="contentBlock" id="main_center">
							<form name="updateData" onSubmit="return checkPW()" action="../Php/Profil/ChangeData.php" method="post">
								<table>
									<h1>Profil bearbeiten:</h1>
									<tr>
										<td class="RowWidth">
											<p class="ProfilInfo">E-Mail:</p>
										</td>
										<td class="RowWidth">
											<input tabindex="1" name="UserEmail" value="<?php echo $email;?>"></input>
										</td>
										<td></td>
										<td></td>
										<td></td>
										<td class="RowWidth">
											<p class="ProfilInfo">Altes Passwort:</p>
										</td>
										<td class="RowWidth">
										    <input tabindex="5" name="altesPW" maxlength="20" type="password"></input>
										</td>
									</tr>
									<tr>
										<td class="RowWidth">
											<p class="ProfilInfo">Vorname:</p>
										</td>
										<td class="RowWidth">
											<input tabindex="2" name= "UserVorName" value="<?php echo $vorname;?>"></input>
										</td>
										<td></td>
										<td></td>
										<td></td>
										<td class="RowWidth">
											<p class="ProfilInfo">Neues Passwort:</p>
										</td>
										<td class="RowWidth">
											<input tabindex="6" name="neuesPW" maxlength="20" type="password" onkeyup="checkPW()"></input>
										</td>
									</tr>
									<tr>
										<td class="RowWidth">
											<p class="ProfilInfo">Nachname:</p>
										</td>
										<td class="RowWidth">
											<input tabindex="3" name="UserNachName" value="<?php echo $nachname;?>"></input>
										</td>
										<td></td>
										<td></td>
										<td></td>
										<td class="RowWidth">
											<p class="ProfilInfo">Wiederholen:</p>
										</td>
										<td class="RowWidth">
											<input tabindex="7" name="neuesPWwiederholen" maxlength="20" type="password" onkeyup="checkPW()"></input>
										</td>
										<td>
											<img id="PWchecked" style="display:none;margin:0px 10px;" class="del_Image" src="../Pictures/SiteContent/tick.svg">
										</td>
									</tr>
									<tr>
										<td class="RowWidth">
											<p class="ProfilInfo">Postleitzahl:</p>
										</td>
										<td class="RowWidth">
											<input tabindex="4" name="UserPLZ" value="<?php echo $plz;?>"></input>
										</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<td class="RowWidth">
											<button type= "submit">Speichern</button>
										</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td class="RowWidth">
											<button id="pwsubmit" type= "submit" disabled>Speichern</button>
										</td>
									</tr>
								</table>
							</form>
						</div>
					</td>
				</tr>
				<tr>
				    <td id="chooseimage" class="contentBlock" style="width:100%; display: none;" colspan="2">
						<div class="grid">
							<div class="col-8-12">
								<div id="upload-wrapper">
									<div align="center">
										<h2>Profilbild auswählen:</h2>
										<span style="margin-bottom: 10px">Erlaubte Dateitypen: JPEG, JPG, PNG und GIF. <br> Maximale Größe: 1 MB</span>
										<form action="../Php/Profil/ProfilPictureUpload.php" onSubmit="return false" method="post" enctype="multipart/form-data" id="MyUploadForm">
											<input name="ImageFile" id="imageInput" type="file" />
											<input hidden="true" name="mail" value="<?php echo $email ?>" />
											<input type="submit"  id="submit-btn" value="Upload" />
											<img src="http://www.sanwebe.com/assets/ajax-image-upload-progressbar/images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
										</form>
										<div id="progressbox" style="display:none;"><div id="progressbar"></div ><div id="statustxt">0%</div></div>
										<div id="output"></div>
									</div>
								</div>
							</div>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
