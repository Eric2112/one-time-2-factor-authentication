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

// We check if there's someone in the database with that username and password
	$query = "SELECT * FROM users WHERE Username='$myusername' and Password3='$mypassword'";
	$result = mysqli_query($dbhandle, $query);
	$count = mysqli_num_rows($result);

// If there's someone who matches both, variable count will be 1
	if($count==1){

// Generate random PIN of numbers and Capital letters
		$input ='1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$inputLength = strlen($input)-1;
// PIN will be 6 characters long
		for($i=0; $i<6; $i++){
			$random .= $input[rand(0, $inputLength)];
}

// Store that PIN in the database
		$pin= "UPDATE users SET PIN ='$random' WHERE Username='$myusername'";
		mysqli_query($dbhandle, $pin);

// Close data base
		mysqli_close($dbhandle);

// Cookie checks if user has logged in, it expires 120 seconds after the log in
// User has 2 minutes to do all process of verification
		$seconds = 120 + time();
		setcookie(loggedin, date("F jS - g:i a"), $seconds);
// Redirect to page that will request the PIN
		header("location:first_login_success.php");

	} else{
// In case the username is not in the database or the password doesn't match that username, redirect to page that requests code
		header("location:wrong_user_pass.php");
	}
?>
