<?php

	include 'sql.php';

	session_start();

	$username = $_SESSION['user'];

	if(isset($_GET))
	{
		$msg = $_GET['msg'];

		$msg = htmlspecialchars($msg);

		$result = $conn->query("SELECT id FROM users WHERE username='$username';");

		$row = $result->fetch_assoc();

		$userid = $row['id'];

		$insert = "INSERT INTO data(userid,message) VALUES('$userid','$msg');";

		$conn->query($insert);
	}
?>