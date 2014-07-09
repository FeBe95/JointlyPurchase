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
							<?php //include "../Php/SocialNetwork/GetChatList.php"; ?>
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
							<div id="chatload">
								<div class="bounce_container">
									<div class="double-bounce1"></div>
									<div class="double-bounce2"></div>
								</div>
							</div>
								
							<div id="chat">
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
							
							<textarea id="chatnachricht" name='message' onkeyup="pressedEnter(event)" autofocus></textarea>
							<input onClick="sendMessage()" name='senden' type='submit' value="Senden"/>
							
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
			function pressedEnter(event){
				if (event.keyCode == 13 &&
				   !event.altKey && 
				   !event.ctrlKey && 
				   !event.shiftKey){
					// Enter-Taste ohne Alt/Strg/Shift gedrückt
					sendMessage();
					return false;
				}
			}
			
			function checkNachricht(){
				var text = document.getElementById('chatnachricht').value;
				if (/\S/.test(text) && /./.test(text)){
					//Nachricht besteht nicht nur aus " " und/oder Absätzen
					return true;
				}
				else{
					//Nachricht besteht nur aus " " und/oder Absätzen
					return false;
				}
			}
			
			function sendMessage(){
				if(checkNachricht()){
					document.getElementById('chatload').style.opacity = "1";
					
					var sendChat_datei = new XMLHttpRequest();
					var message = "message="+document.getElementById('chatnachricht').value;
					var ID1 = "&UserID1=<?php echo $ID; ?>";
					var ID2 = "&UserID2=<?php echo $_GET['a']; ?>";
					var params = message+ID1+ID2;
					
					sendChat_datei.open("POST", "../Php/SocialNetwork/ChatSendMessage.php");
					
					sendChat_datei.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					sendChat_datei.setRequestHeader("Content-length", params.length);
					sendChat_datei.setRequestHeader("Connection", "close");
					
					//sendChat_datei.onreadystatechange = updateChat_function; // nicht tötig, da eh jede Sekunde
					sendChat_datei.send(params);
					
					document.getElementById('chatnachricht').value = "";
					$("#chat").animate({ scrollTop: document.getElementById("chat").scrollHeight }, "fast");
				}
				else{
					//alert("Bitte gib eine Nachricht ein!");
				}
			}
			
			var chat_datei = new XMLHttpRequest();
			var chat_list_datei = new XMLHttpRequest();
			number_of_messages = 0;
			
			function initial_getChat_function(){
				if(chat_datei.readyState == 4 && chat_datei.status == 200){
					number_of_messages = chat_datei.responseText.match(/<span[^>]*>([^<]+)<\/span>/)[1];
					document.getElementById('chatelements').innerHTML = chat_datei.responseText;
					$( "#chatelements" ).show("fade", "slow");
					document.getElementById("chat").scrollTop = document.getElementById("chat").scrollHeight;
					document.getElementById('chatload').style.opacity = "0";
				}
			}
			
			function updateChat_function(){
				if(chat_datei.readyState == 4 && chat_datei.status == 200){
					number_of_messages_new = chat_datei.responseText.match(/<span[^>]*>([^<]+)<\/span>/)[1];
					if(number_of_messages_new > number_of_messages){
						number_of_messages = chat_datei.responseText.match(/<span[^>]*>([^<]+)<\/span>/)[1];
						
						document.getElementById('chatelements').innerHTML = chat_datei.responseText;
						if(document.getElementById("chat").scrollHeight-document.getElementById("chat").scrollTop-512 < 300){
							// Wenn Benutzer innerhalb der letzten 300 Pixel, dann runterscrollen
							$("#chat").animate({ scrollTop: document.getElementById("chat").scrollHeight }, "slow");
						}
						else{
							// Wenn Benutzer außerhalb der letzten 300 Pixel, dann Hinweis einblenden
							$( "#newalert" ).show("fade", "slow");
						}
						initial_text = chat_datei.responseText;
					}
					document.getElementById('chatload').style.opacity = "0";
				}
			}
			
			function updateChatList_function(){
				if(chat_list_datei.readyState == 4 && chat_list_datei.status == 200){
					document.getElementById('chatList').innerHTML = chat_list_datei.responseText;
				}
			}
			
			function initial_getChat(){
				chat_datei.open("POST", "../Php/SocialNetwork/ChatReader.php?a=<?php echo $_GET['a']; ?>");
				chat_datei.onreadystatechange = initial_getChat_function;
				chat_datei.send(null);
			}
			function updateChat(){
				chat_datei.open("POST", "../Php/SocialNetwork/ChatReader.php?a=<?php echo $_GET['a']; ?>");
				chat_datei.onreadystatechange = updateChat_function;
				chat_datei.send(null);
			}
			
			
			function updateChatList(){
				chat_list_datei.open("POST", "../Php/SocialNetwork/GetChatList.php");
				chat_list_datei.onreadystatechange = updateChatList_function;
				chat_list_datei.send(null);
			}
		
			window.addEventListener('load', function() {
				initial_getChat();
				updateChatList();
				setInterval(function(){
					// Jede Sekunde Chat updaten
					updateChat();
					updateChatList();
				}, 1000);
			});
			
			$("#chat").scroll(function() {
				if(document.getElementById("chat").scrollHeight-document.getElementById("chat").scrollTop-512 < 300){
					$( "#newalert" ).hide("fade", "slow");
				}
			});
			
			$( "#newalert" ).click(function() {
				$("#chat").animate({ scrollTop: document.getElementById("chat").scrollHeight }, "slow");
			});
		</script>
		<?php 
			 include "../Templates/FooterTemplate.php";
		?>
    </body>
</html>