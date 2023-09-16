<?php
	session_start();

	include 'sql.php';

	$username = $_SESSION['user'];

	if(isset($_GET))
	{
		$receiver = $_GET['user'];

		$msg = $_GET['msg'];

		$msg = htmlspecialchars($msg);

		$query = "INSERT INTO messages(sender,receiver,message) VALUES('$username','$receiver','$msg');";

		$conn->query($query);
	}

?>