<div id="head">
	<div id="headcontent">
		<div id="logo">
			<a href="../index.php" class="logobutton"><img src="../Pictures/SiteContent/logo_klein_beta.png" width="250px"/></a>
		</div>
		<div id="headbuttons">
			<form action="../Php/Authentification/Login.php" method="post">
				<table>
					<tr>
						<td>
							<p class="headText">Email:<input name="Email" type="email" maxlength="50"/></p>
						</td>
						<td>
							<p class="headText">Passwort:<input name="Pw" type="password" maxlength="20"/></p>
						</td>
						<td>
							<button name="send" type="submit" value="send">Login</button>
						</td>
					</tr>
					<tr>
						<td>
							<p class="headText newbg" style="font-size:12px;float:right;">
								<input id="check" type="checkbox" name="stayLogIn" checked/>
								<label for="check" class="loginLabel stayLoggedIn">Angemeldet bleiben</label>
							</p>
						</td>
						<td>
							<p class="headText newbg" style="font-size:12px;float:right;">
								<a href="forgot.php" class="loginLabel PWforgot">
									Passwort vergessen
								</a>

							</p> 
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>