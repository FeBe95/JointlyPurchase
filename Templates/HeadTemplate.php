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
							$profilPic = mysqli_fetch_assoc($profilPic)["profilPic"];
							
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
                        <div id="HeadPopUp" >
							<div id="link" style="cursor:pointer;">
								<img class="head-icon" src='../Pictures/SiteContent/group.svg'>
							</div>
							<div tabindex="-1" id="HeadPopUpBox">
							  <p style="font-size:12px; font-weight:bold; margin-top:0px; border-bottom:1px solid grey;">Freundschaftsanfragen</p>
							  <?php
								  include "../Php/SocialNetwork/GetRequest.php";
							  ?>
							</div>
						</div>
                    </td>
					<td>
                        <div id="HeadPopUp2">
							<div id="link2" style="cursor:pointer;">
								<img class="head-icon" src='../Pictures/SiteContent/notification.svg'>
							</div>
							<div tabindex="-1" id="HeadPopUpBox2">
								<p style="font-size:12px; font-weight:bold; margin-top:0px; border-bottom:1px solid grey;">Benachrichtigungen</p>
								<?php
									include "../Php/SocialNetwork/GetNotification.php";
								?>
							</div>
						</div>
                    </td>
                    <td>
						<form action="../Php/Authentification/Logout.php" method="post">
							<input name="send" style="margin-left:10px;" type="submit" value="Logout"></input>
						</form>
					</td>
                </tr>
           </table>
        </div>
    </div>
</div>
<div id="greybar">
<!--     <ul id="headMenue">
            	<li class="headMenueItem" id="headMenueItem1" style="background-color:#1AA1E1;"> 
                  <a href= ../Pages/ProfilSettings.php><img class="rotate" style="height:16px;" id='einstellungen' src='../Pictures/SiteContent/settings.svg'></a>
              	</li>
              	<li class="headMenueItem" id="headMenueItem2" style="background-color:#B3C833;">
                  <div id="HeadPopUp" >
                      <a id="link" href="#"><img style="height:16px;" src='../Pictures/SiteContent/group.svg'></a>
                      <div tabindex="-1" id="HeadPopUpBox">
                          <p style="font-size:12px; font-weight:bold; margin-top:0px; border-bottom:1px solid grey;">Freundschaftsanfragen</p>
                          <?php
                              //include "../Php/SocialNetwork/GetRequest.php";
                          ?>
                      </div>
                  </div>
              	</li>
               	<li class="headMenueItem" id="headMenueItem3" style="background-color:#CE5043;">
                  <div id="HeadPopUp2">
                      <a id="link2" href="#"><img style="height:16px;" src='../Pictures/SiteContent/notification.svg'></a>
                      <div tabindex="-1" id="HeadPopUpBox2">
                          <p style="font-size:12px; font-weight:bold; margin-top:0px; border-bottom:1px solid grey;">Benachrichtigungen</p>
                          <?php
                              //include "../Php/SocialNetwork/GetNotification.php";
                          ?>
                      </div>
                  </div>
              	</li>
    </ul> -->
</div>