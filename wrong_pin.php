<?php

// To avoid people entering this page if they haven't logged in first
	if(!isset($_COOKIE['loggedin'])){
		header("location:index.php");
	}

?>

<html>
	<body>
		<h1>Wrong PIN, please try again:</h1>
		<form action="second_login.php" method="POST">
			<p>Code:</p><input type="password" name="pin" />
<br />
<br />
<br />
		<a href="logout.php">Logout</a>
	</body>
</html>
