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
	$myphone= $_POST['phone'];
// Remove slashes from username and password (important when working with databases as we are doing)
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);
	$myphone = stripslashes($myphone);

//Create a new username with these information
	$newuser = "INSERT INTO users(username, password, phone) VALUES ('$myusername','$mypassword','$myphone')";
	$pswr = mysqli_query($dbhandle, $newuser);
	
// Close data base
	mysqli_close($dbhandle);
?>