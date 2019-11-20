<?php
//For using Twilio API
require_once "vendor/autoload.php"; 
use Twilio\Rest\Client;

// Acessing data base
	$username = "root";
	$password = NULL;
	$hostname = "localhost";

	$dbhandle = mysqli_connect($hostname, $username, $password) or die("Could not connect to database");

// Data base in which we will have the tables we want to access
	$selected = mysqli_select_db($dbhandle, "bank");
	
	
// Generate random PIN of numbers and Capital letters
		$input ='1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$inputLength = strlen($input)-1;
// PIN will be 6 characters long
		for($i=0; $i<6; $i++){
			$random .= $input[rand(0, $inputLength)];
		}
		
// Get phone number that PIN in the database
		$pin= "SELECT phone from users WHERE Current= 1";
		$phonenumber= mysqli_query($dbhandle, $pin);		
		$phone = mysqli_fetch_array($phonenumber);
// phone variable $phone["phone"]
	
//Twilio credentials
$account_sid = getenv('TWILIO_ACCOUNT_SID');
$auth_token = getenv('TWILIO_AUTH_TOKEN');
$twilio_phone_number = "+12512203372";

//Client we're sending the PIN
$client = new Client($account_sid, $auth_token);

//Message creation
$client->messages->create(
    strval($phone["phone"]),
    array(
        "from" => $twilio_phone_number,
        "body" => "Your verification code is $random"
    )
);
		
// Store that PIN in the database for the checking
		$pin= "UPDATE users SET PIN ='$random' WHERE Current=1";
		mysqli_query($dbhandle, $pin);

// Close data base
		mysqli_close($dbhandle);
	// Cookie checks if user has logged in, it expires 300 seconds after the log in
	// If user reloads page where PIN is requested, after those 300 seconds, he/she will have to log in again
		$seconds = 300 + time();
		setcookie(loggedin, date("F jS - g:i a"), $seconds);
// Redirect to page that will request the PIN
		header("location:first_login_success.php");


?>
