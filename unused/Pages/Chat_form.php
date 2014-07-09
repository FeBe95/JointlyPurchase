<?php
    session_start();
    include "../Php/Authentification/SessionChecker.php";
	include "../Php/Misc/GetYourData.php";
	include "../Php/Misc/GetFriendData.php";
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <title>Deine Nachrichten</title>
		
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/CSS" href="../css/style.css">
		
        <link href="../css/jquery/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
        <link href="../css/jquery/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
		<link href="../css/jquery/jquery.ui.dialog.min.css" rel="stylesheet" type="text/css">
		<link href="../css/jquery/jquery.ui.resizable.min.css" rel="stylesheet" type="text/css">
        <link href="../css/jquery/jquery.ui.accordion.min.css" rel="stylesheet" type="text/css">
		
        <link href='http://fonts.googleapis.com/css?family=Special+Elite' rel='stylesheet' type='text/css'>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script src="../js/jquery/jquery-ui-1.9.2.dialog.custom.min.js"></script>
		<script src="../js/jquery/jquery-ui-1.9.2.accordion.custom.min.js"></script>
    </head>
    <body>
        <?php
            include "../Templates/HeadTemplate.php";
        ?>
		<div id="mainwindow">
			<table cellpadding="10px" cellspacing="10px" style="margin:auto;">
				<tr>
					<td class="contentBlock" style="width: 200px;">
						<h1>Letzte Chats:</h1>
						<div id="chatList">
							<?php include "../Php/SocialNetwork/GetChatList.php"; ?>
						</div>
                    </td>
					<td class="contentBlock" style="width: 752px;">
						<h1>Chat mit 
							<?php
								include "../Templates/MYSQLConnectionString.php";
								$profilPic = mysqli_query($conUser,"SELECT profilPic FROM user WHERE ID = '$ID2'");
								$profilPic = mysqli_fetch_assoc($profilPic);
								$profilPic = $profilPic["profilPic"];
								
								echo "<a href='../Pages/Profil.php?a=$ID2'>";
								echo "$vorname_friend $nachname_friend";
								echo "<img class='chatpic' height='30' src='../Pictures/Thumbnails/$profilPic'>";
								echo "</a>:";
							?>
						</h1>
						
						<div id="currentChat">
							<div id="chat">
							
								<div id="chatload">
									<div class="bounce_container">
										<div class="double-bounce1"></div>
										<div class="double-bounce2"></div>
									</div>
								</div>
								
								<div id="chatelements" style="display: none;">
									<!--<div class="chatelement left">
										<div class='text'>Du bist's</div>
										<div class='datum'>vor 5 Min.</div>
									</div>
									<div class="chatelement right">
										<div class='text'>Ich bin's</div>
										<div class='datum'>vor 4 Min.</div>
									</div>
									<div class="chatelement left">
										<div class='text'>Du bist's</div>
										<div class='datum'>vor 3 Min.</div>
									</div>
									<div class="chatelement left">
										<div class='text'>Du bist's</div>
										<div class='datum'>vor 2 Min.</div>
									</div>-->
								</div>
							</div>
							<div id="newalert" style="display: none;">
								&#65516;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								Neue Nachrichte(n)
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&#65516; 
							</div>
							
							<form name="sendform" method="post" onSubmit="return checkNachricht()" action="../Php/SocialNetwork/ChatSendMessage.php">
								<textarea id="chatnachricht" name='message' onkeydown="checkEnter(event)" autofocus></textarea>
								<input name='UserID1' type='hidden' value="<?php echo $ID; ?>"/>
								<input name='UserID2' type='hidden' value="<?php echo $ID2; ?>"/>
								<input name='senden' type='submit' value="Senden"/>
							</form>
						</div>
                    </td>
				</tr>
				<tr>
					<td class="contentBlock chat_fb" colspan="2">
						<?php include "../Php/SocialNetwork/FriendBrowser.php"; ?>
					</td>
                </tr>
			</table>
		</div>
		<script>
			function checkNachricht(){
				var text = document.getElementById('chatnachricht').value;
				if (/\S/.test(text) && /./.test(text)){
					return true;
				}
				else{
					return false;
				}
			}
		
			function checkEnter(event){
				if (event.keyCode == 13 &&
				   !event.altKey && 
				   !event.ctrlKey && 
				   !event.shiftKey){
					if(checkNachricht()){
						document.sendform.submit();
						return false;
					}
				}
			}
			
			var chat_datei = new XMLHttpRequest();
			
			m_number = 0;
			
			function getChat_function(){
				if(chat_datei.readyState == 4 && chat_datei.status == 200){
					document.getElementById('chatload').style.opacity = "0";
					m_number = chat_datei.responseText.substr(12,2);
					window.setTimeout(function(){
						document.getElementById('chatelements').innerHTML = chat_datei.responseText;
						$( "#chatelements" ).show("fade", "slow");
						document.getElementById("chat").scrollTop = document.getElementById("chat").scrollHeight;
					},300);
				}
			}
			function updateChat_function(){
				if(chat_datei.readyState == 4 && chat_datei.status == 200){
					m_number_new = chat_datei.responseText.substr(12,2);
					if(m_number_new > m_number){
						m_number = chat_datei.responseText.substr(12,2);
						document.getElementById('chatelements').innerHTML = chat_datei.responseText;
						// ganz nach untengescroll ist das Ergebnis '212'
						if(document.getElementById("chat").scrollHeight-document.getElementById("chat").scrollTop < 300){
							$("#chat").animate({ scrollTop: $("#chatelements").innerHeight() }, "slow");
						}
						else{
							$( "#newalert" ).show("fade", "slow");
						}
						initial_text = chat_datei.responseText;
					}
				}
			}
			
			function getChat(){
				chat_datei.open("POST", "../Php/SocialNetwork/ChatReader.php?a=<?php echo $_GET['a']; ?>");
				chat_datei.onreadystatechange = getChat_function;
				chat_datei.send(null);
			}
			function updateChat(){
				chat_datei.open("POST", "../Php/SocialNetwork/ChatReader.php?a=<?php echo $_GET['a']; ?>");
				chat_datei.onreadystatechange = updateChat_function;
				chat_datei.send(null);
			}
		
			window.addEventListener('load', function() {
				getChat();
				setInterval(function(){
					updateChat();
				}, 5000);
			});
			
			$("#chat").scroll(function() {
				// ganz nach untengescroll ist das Ergebnis '212'
				if(document.getElementById("chat").scrollHeight-document.getElementById("chat").scrollTop < 300){
					$( "#newalert" ).hide("fade", "slow");
				}
			});
			
			$( "#newalert" ).click(function() {
				alert($("#chatelements").innerHeight());
				$("#chat").animate({ scrollTop: $("#chatelements").innerHeight() }, "slow");
			});
		</script>
		<?php 
			 include "../Templates/FooterTemplate.php";
		?>
    </body>
</html>