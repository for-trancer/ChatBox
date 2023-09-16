<?php
	$server = "localhost";
	$user = "root";
	$pass = "root";
	$db= "chatbot";

	$conn = new mysqli($server,$user,$pass,$db);

	if($conn->connect_error)
	{
		echo "sql connection error!";
	}
?>