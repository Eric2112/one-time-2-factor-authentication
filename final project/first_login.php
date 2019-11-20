<?php

// Acessing data base
	$username = "root";
	$password = NULL;
	$hostname = "localhost";

	$dbhandle = mysqli_connect($hostname, $username, $password) or die("Could not connect to database");

// Data base in which we will have the tables we want to access
	$selected = mysqli_select_db($dbhandle, "bank");

// Save typed user and password into variables
	$myusername = $_POST['user'];
	$mypassword = $_POST['pass'];
// Remove slashes from username and password (important when working with databases as we are doing)
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);

// Save user's password (stored in databse)
	$passwordorig = "SELECT password FROM users WHERE Username='$myusername'";
	$pswr = mysqli_query($dbhandle, $passwordorig);
// Saving the result of the query (the user's password)
	$sol = mysqli_fetch_array($pswr);
// Save 3 last digits of user's password for the check
	$threelastdigits= SUBSTR($sol["password"],-3,3);
	$sql= "UPDATE users SET Password3 = '$threelastdigits' WHERE Username='$myusername'";
	mysqli_query($dbhandle, $sql);
	mysqli_free_result($pswr);

// Check if there's someone in the database with that username and password
	//Convert entered pass into hash (because it's being compared with a hash code as well)
	$query = "SELECT * FROM users WHERE Username='$myusername' and Password3='$mypassword'";
	$result = mysqli_query($dbhandle, $query);
	$count = mysqli_num_rows($result);

// If there's someone who matches both, variable count will be 1
	if($count==1){
// Set value to a parameter that lets us know which user is requesting the code
	$current= "UPDATE users SET Current = 1 WHERE Username='$myusername'";
	mysqli_query($dbhandle, $current);

	// Cookie checks if user has logged in, it expires 300 seconds after the log in
	// If user reloads page where PIN is requested, after those 300 seconds, he/she will have to log in again
		$seconds = 300 + time();
		setcookie(loggedin, date("F jS - g:i a"), $seconds);
// Redirect to page that will store phone number into data base
		header("location:send_again.php");
	} else{
// In case the username is not in the database or the password doesn't match that username, redirect to page that requests code
		header("location:wrong_user_pass.html");
	}
		
?>