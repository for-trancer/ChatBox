<?php
	session_start();
	if(!isset($_SESSION['user']))
	{
		header("Location: signin.php");
		close();
	}
?>
<!DOCTYPE html>
<head>
	<meta encodeing="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<link rel="stylesheet" href="css/style.css?vb=756">
	<script>

		xmlhttp = new XMLHttpRequest();

		chathttp = new XMLHttpRequest();

		dmhttp = new XMLHttpRequest();

		userhttp = new XMLHttpRequest();

		let refresh = false;


		var user;

		function scrollToBottom()
		{
			const messageSpace = document.getElementById('message_space');
			const dmSpace = document.getElementById('dm_space');
			messageSpace.scrollTo({
				top: messageSpace.scrollHeight,
				behavior: "smooth"
			});
			dmSpace.scrollTo({
				top: dmSpace.scrollHeight,
				behavior: "smooth"
			});
		}

		function displayMessage()
		{
			xmlhttp.onreadystatechange = function ()
			{
				if( this.readyState === 4 && this.status === 200)
				{
					const messageSpace = document.getElementById('message_space');
					messageSpace.innerHTML = this.responseText;
				}
			};

			xmlhttp.open("POST","display_message.php",true);
			xmlhttp.send();
		}

		function sendMessage()
		{
			var msg = document.getElementById("msg").value;

			if(msg == "" || msg == "Message")
			{
				document.getElementById("msg").value="enter the message!";
			}
			else
			{
				if(document.getElementById('message_space').style.display == "none")
				{
					directMessage();
					document.getElementById("msg").value="";
				}
				else
				{
					xmlhttp.open("GET","process_message.php?msg=" + encodeURIComponent(msg),true);
					xmlhttp.send();
					document.getElementById("msg").value="";
				}
			}
		}

		function displayDirect()
		{

			dmhttp.onreadystatechange = function ()
			{
				if(this.readyState === 4 && this.status === 200)
				{
					const dmSpace = document.getElementById('dm_space');
					dmSpace.innerHTML = this.responseText;
				}
			};

			dmhttp.open("POST","display_direct.php",true);
			dmhttp.send(user);
		}

		function directMessage()
		{
			var msg = document.getElementById("msg").value;

			chathttp.open("GET","direct_message.php?user=" + encodeURIComponent(user) + "&msg=" + encodeURIComponent(msg),true);
			chathttp.send();
		}

		function dmSectionOpener(ClickedElement)
		{
			user = ClickedElement.innerText || ClickedElement.textContent;
			document.getElementById('msg-header').textContent=user;
			document.title=user+" | DM";
			document.getElementById("message_space").style.display = "none";
			document.getElementById("dm_space").style.display = "block";
			document.getElementById('refresh-button').value="Global Chat"
			displayDirect();
		}

		function showUsers()
		{
			userhttp.onreadystatechange = function ()
			{
				document.getElementById("users").innerHTML=this.responseText;
			};
			userhttp.open("POST","show_users.php",true);
			userhttp.send();
		}

		function goBack()
		{
			location.reload();
		}

		window.onload = function ()
		{
			document.getElementById("message_space").style.display = "block";
			document.getElementById("dm_space").style.display = "none";
			displayMessage();
			showUsers();
			const messageSpace = document.getElementById("message_space");
		};

		function onReload()
		{
			const messageSpace = document.getElementById('message_space');
			const scrollPosition = messageSpace.scrollTop;
			displayDirect();
			displayMessage();

			messageSpace.scrollTo({
						top: ScrollPosition,
						behavior : "smooth"
					});
		}

		document.addEventListener('DOMContentLoaded',function (){
			scrollToBottom();
		});

		setInterval(onReload,1000);
		setInterval(scrollToBottom,5000);




	</script>
</head>
<body>
	<div class="header">
		<h1>CHAT<font color="orange">BOX</font></h1>
		<hr/>
		<input type="button" value="log out" onClick="window.location.href='logout.php'" class="text-box">
		<h2>hello , <b><font color="orange"><?php echo $_SESSION['user']; ?></font></b></h2>
		<h3>MESSAGE USERS</h3>
		<div id="users">
		</div>
	</div>
	<div class="message-main">
		<h4 id="msg-header">Global Chat</h4>
		<input type="button" value="Refresh" onClick="goBack()" id="refresh-button" >
		<div id="message_space" style="display: block;">
		</div>
		<div id="dm_space" style="display: none;">
		</div>
		<div id="send-message">
		<form onsubmit="return false;">
			<input type="text" id="msg" name="msg" value="Message" onfocus="this.value=''">
			<input type="button" name="button" value="Send" onClick="sendMessage()" class="send-message-button">
		</form>
		</div>
	</div>
</body>
</html>