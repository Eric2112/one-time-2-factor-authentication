<?php
	$username = "root";
	$password = NULL;
	$hostname = "localhost";
	
	$dbhandle = mysqli_connect($hostname, $username, $password) or die("Could not connect to database");
	
	$selected = mysqli_select_db($dbhandle, "bank");
	
	$myusername = $_POST['user'];
	$mypassword = $_POST['pass'];
	
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);

	$passwordorig = "SELECT password FROM users WHERE Username='$myusername'";
$pswr = mysqli_query($dbhandle, $passwordorig);
$sol = mysqli_fetch_array($pswr);

	$threelastdigits= SUBSTR($sol["password"],-3,3);
$sql= "UPDATE users SET Password3 = '$threelastdigits' WHERE Username='$myusername'";
mysqli_query($dbhandle, $sql);
	
	$query = "SELECT * FROM users WHERE Username='$myusername' and Password3='$mypassword'";
	$result = mysqli_query($dbhandle, $query);
	$count = mysqli_num_rows($result);
	
	mysqli_close($dbhandle);
	
	if($count==1){
		$seconds = 5 + time();
		setcookie(loggedin, date("F jS - g:i a"), $seconds);
		header("location:login_success.php");
	}else{
		echo 'Incorrect Username or Password';
	}
?>