<?php
	session_start();

	include 'sql.php';

	if(isset($_POST))
	{
		$query = "SELECT users.username,data.message FROM data INNER JOIN users ON users.id=data.userid ORDER BY data.id;";

		$sender = $_SESSION['user'];
		
		$result = $conn->query($query);

		while($row = $result->fetch_assoc())
		{
			$receiver = $row['username'];

			if($sender == $receiver)
			{
				echo "<div class='user-main-holder'>";
				echo "<label id='user-main-name'>".$row['username']."</label>";
			}
			else
			{
				echo "<div class='user-main-holder'>";
				echo "<a href='#' onClick='dmSectionOpener(this)' id='users-main-name'><label>".$row['username']."</label></a>";
			}
			echo "<br>";
			echo "<label id='msg_content'>".$row['message']."</label>";
			echo "</div>";
		}
	}

?>