<div id="head">
    <div id="headcontent">
        <div id="logo">
            <a href="../Pages/Home.php" class="logobutton"><img src="../logo_klein.png" width="250px"/></a>
        </div>
        <div id="headbuttons">
            <table>
                <tr>
                    <td>
						<?php
							include "../Templates/MYSQLConnectionString.php";
							$profilPic = mysqli_query($conUser,"SELECT profilPic FROM user WHERE email = '$email'");
							$profilPic = mysqli_fetch_assoc($profilPic);
							$profilPic = $profilPic["profilPic"];
							
							echo "<a href='../Pages/Profil.php?a=$ID' class='headlink'><div id='headcrop'>";
							echo "<img id='smallcrop' src='../Pictures/Thumbnails/$profilPic'>";
							echo "</div><span class='head-icon'>$vorname $nachname</span></a>";
						?>
                    </td>
                    <td>
						<a href="../Pages/ProfilSettings.php">
							<img class="head-icon rotate"  id='einstellungen' src='../Pictures/SiteContent/settings.svg'>
						</a>
                    </td>
					<td>
                        <div id="HeadPopUp">
							<?php
								include "../Php/SocialNetwork/GetRequest.php";
							?>
							<div id="link" style="cursor:pointer;">
								<img id="icon1" class="head-icon" src='../Pictures/SiteContent/group.svg'>
							</div>
						</div>
                    </td>
					<td>
                        <div id="HeadPopUp2">
							<?php
								include "../Php/SocialNetwork/GetNotification.php";
							?>
							<div id="link2" style="cursor:pointer;">
								<img id="icon2" class="head-icon" src='../Pictures/SiteContent/notification.svg'>
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