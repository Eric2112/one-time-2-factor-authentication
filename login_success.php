<?php
	if(!isset($_COOKIE['loggedin'])){
		header("location:index.php");
	}
?>

<html>
	<body>
		<h1>Login success!</h1>
		<a href="logout.php">Logout</a>
	</body>
</html>