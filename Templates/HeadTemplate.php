<div id="head">
	<?php
			setlocale(LC_ALL, 'german');
			setlocale(LC_ALL, 'de_DE');
			date_default_timezone_set('Europe/Berlin');
			include "../Php/Misc/GetYourData.php";
	?>
	
    <div id="headContent">
        <div id="logo">
            <a href="../Pages/Home.php" ><img src="../Pictures/SiteContent/logo_klein_beta.png" width="250px"/></a>
        </div>
		<div id="headSearch">
			<form action="../Pages/SearchResults.php" method="get">
					<input placeholder="Suche nach Namen, PLZ oder Listen" name="q" type="text" value="<?php echo @$_GET['q'] ?>"/>
					<span id="searchButton" onclick="this.parentNode.submit()">&#128269;</span>
			</form>
		</div>
        <div id="headButtons">
            <table>
                <tr>
                    <td>
						<a href="../Pages/Profil.php?a=<?php echo $ID; ?>" class="headLink">
							<img id="headPicCrop" src="../Pictures/Thumbnails/<?php echo $profilPic; ?>">
							<span id="headName"><?php echo $vorname." ".$nachname; ?></span>
						</a>
                    </td>
                    <td>
						<a href="../Pages/ProfilSettings.php">
							<div id="settings" class="icon rotate"></div>
						</a>
                    </td>
					<td>
                        <div id="HeadPopUp1">
							<?php include "../Php/Header/GetRequests.php"; ?>
								<div id="friendrequests" class="icon"></div>
							</div>
						</div>
                    </td>
					<td>
                        <div id="HeadPopUp2">
							<?php include "../Php/Header/GetMessages.php"; ?>
								<div id="messages" class="icon"></div>
							</div>
						</div>
                    </td>
					<td>
                        <div id="HeadPopUp3">
							<?php include "../Php/Header/GetNotifications.php"; ?>
								<div id="notifications" class="icon"></div>
							</div>
						</div>
                    </td>
                    <td>
						<form action="../Php/Authentification/Logout.php" method="post">
							<input name="send" style="margin-left:10px;" type="submit" value="Logout"/>
						</form>
					</td>
                </tr>
           </table>
        </div>
    </div>
</div>
<div id="greybar">
</div>
<script src="../js/BoogyBox.js"></script>