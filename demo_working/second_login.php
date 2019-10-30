<?php

// Acessing data base
	$username = "root";
	$password = NULL;
	$hostname = "localhost";

	$dbhandle = mysqli_connect($hostname, $username, $password) or die("Could not connect to database");

// Data base in which we will have the tables we want to access
	$selected = mysqli_select_db($dbhandle, "bank");

// Save entered code/PIN into a variable
	$mycode = $_POST['pin'];
// Remove slashes from the pin(important when working with databases as we are doing)
	$mycode = stripslashes($mycode);

// Check pin
	// We save the username (unique) to who the PIN has been sent for later restore to NULL
	$query = "SELECT Username FROM users WHERE PIN='$mycode'";
	$result = mysqli_query($dbhandle, $query);
	$myuser= mysqli_fetch_array($result);
	$count = mysqli_num_rows($result);
	$user= $myuser["Username"];

	if($count==1){
// Pin restored to NULL by checking username, not pin (cuase other users can have same pin)
		$pin= "UPDATE users SET PIN =NULL WHERE Username='$user'";
		mysqli_query($dbhandle, $pin);

// Close data base handler
		mysqli_close($dbhandle);
// Cookie checks if user has logged in, it expires 300 seconds after the log in
	// If user reloads page where PIN is requested, after those 300 seconds, he/she will have to log in again
		$seconds = 300 + time();
		setcookie(loggedin, date("F jS - g:i a"), $seconds);
// Redirect to page that will request the PIN
		header("location:second_login_success.php");

	} else{
// In case the PIN is not correct, redirect to page that requests code
		header("location:wrong_pin.php");
	}
?>
