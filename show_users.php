<?php

	session_start();


	include 'sql.php';

	$query = "SELECT username FROM users ORDER BY id DESC;";

	$result = $conn->query($query);

	echo "<br>";

	$user = $_SESSION['user'];


	while($row=$result->fetch_assoc())
	{
		if($row['username']==$user)
		{
			echo "<a href='#' id='show-users-name'>";
		    echo "<div class='user-holder'>";
		    echo "<label><font color='orange'>".$row['username']."</label></font>";
		   echo "</div></a>";
		    echo "<br>";

		}
		else
		{
		echo "<a href='#' onClick='dmSectionOpener(this)' id='show-users-name'>";
		echo "<div class='user-holder'>";
		echo "<label>".$row['username']."</label>";
		echo "</div></a>";
		echo "<br>";
		}
	}
?>