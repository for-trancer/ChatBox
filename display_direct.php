<?php
	session_start();

	include 'sql.php';

	$user = $_SESSION['user'];

	$receiver = file_get_contents("php://input");

	$query = "SELECT sender,receiver,message FROM messages WHERE (sender='$user' AND receiver='$receiver') OR (sender='$receiver' AND receiver='$user') ORDER BY id ;";

	$result = $conn->query($query);

	while( $row=$result->fetch_assoc() )
	{
		if($row['sender'] == $user)
		{
			echo "<div class='users-main-holder'>";
			echo "<label id='sender'><font color='orange'>You</label></font>";
			echo "<br>";
			echo "<label id='message'>".$row['message']."</label>";
			echo "<br>";
			echo "</div>";
		}
		else
		{
			echo "<div class='user-main-holder'>";
			echo "<label id='user-main-holder'>".$row['sender']."</label>";
			echo "<br>";
			echo "<label id='message'>".$row['message']."</label>";
			echo "<br>";
			echo "</div>";
		}
	}
?>