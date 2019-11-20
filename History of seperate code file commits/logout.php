<?php
// Cookie checks if user has logged in, if they haven't,
// it inmediatly redirects to login page (negative time value)
	$seconds = -10 + time();
	setcookie(loggedin, date("F jS - g:i a"), $seconds);
	header("location:index.php");
?>
