<?php
	session_start();
	if(isset($_SESSION['user']))
	{
		header("Location: main.php");
		close();
	}
?>
<!DOCTYPE html>
<head>
	<title>Sign In</title>
	<link rel="stylesheet" href="css/style.css">
	<meta encodeing="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
</head>
<body>
	<?php

	include 'sql.php';

	$username = $password = "";
	$usernameErr = $passwordErr = $sqlErr = "";
	$isValid = true;

	if($_SERVER["REQUEST_METHOD"]=="POST")
	{
		if($conn->connect_error)
		{
			$isValid = false;
			$sqlErr = "connection error!";
		}

		if(empty($_POST["username"]))
		{
			$isValid = false;
			$usernameErr = "enter the username!";
		}
		else
		{
			$username = Formatter($_POST["username"]);
			$username = strtolower($username);

			$result = $conn->query("SELECT username FROM users WHERE username='$username';");

			if(!($result->num_rows>0))
			{
				$isValid = false;
				$usernameErr = "username doesn't exist!";
				$username = "";
			}
		}

		if(empty($_POST["password"]))
		{
			$isValid = false;
			$passwordErr = "password required!";
		}
		else
		{
			if($isValid)
			{
				$password = $_POST["password"];

				$result = $conn->query("SELECT password FROM users WHERE username='$username';");
				$row = $result->fetch_assoc();
				if($result->num_rows>0)
				{
					$hashed_password = $row["password"];
					$check = password_verify($password,$hashed_password);
					if(!$check)
					{
						$isValid = false;
						if(!empty($username))
						{
							$passwordErr = "Password Incorrect!";
						}
					}
				}
				else
				{
					$isValid = false;
					$passwordErr = "Password Incorrect!";
				}
			}
		}
		if($isValid)
		{
			$_SESSION['user'] = $username;
			header("Location: main.php");
			close();
		}
	}


	function Formatter($data)
	{
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	?>
	<h1>CHAT<font color="orange">BOX</font></h1>
	<div class="message-box-shadow"></div>
	<div class="message-box">
		<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
			<label for="username">Username</label>
			<br>
			<input type="text" name="username" value="<?php echo $username;?>" class="text-box">
			<br>
			<div class="error"><?php echo $usernameErr;?></div>
			<br>
			<label for="password">Password</label>
			<br>
			<input type="password" name="password" class="text-box">
			<br>
			<div class="error"><?php echo $passwordErr;?></div>
			<br>
			<div class="error"><?php echo $sqlErr;?></div>
			<br>
			<input type="submit" value="Sign In" class="btn">
			<br>
			<div class="footer">
				<span class="msg">Doesn't have an account?</span>
				<input type="button" value="Sign Up" onClick="window.location.href='index.php'">
			</div>
		</form>
	</div>
</body>
</html>