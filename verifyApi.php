<?php
require_once "vender/autoload.php";

//create app
$app = new Slim\App; 

//load configuration with dotnev
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv -> load();

// Acessing database
$username = "root";
$password = NULL;
$hostname = "localhost";

$dbhandle = mysqli_connect($hostname, $username, $password) or die("Could not connect to database");

// Data base in which we will have the tables we want to access
$selected = mysqli_select_db($dbhandle, "bank");

//get container
$container = $app ->getContainer();

//register twig component on container to view templates
$container['view'] = function(){
    return new Slim\Views\Twig('frontend');
};

// initiialize & load MessageBird SDK
$container['messagebird'] = function(){
    returm new MessageBird\Client(getenv('MESSAGEBIRD_API_KEY'));
};

function getPhoneNumber(){
    $query = "SELECT phoneNumber FROM users WHERE Username='$myusername' and Password3='$mypassword'";
	$number = mysqli_query($dbhandle, $query);
}

// handle number submission
$app ->getPhoneNumber() {
    //create verify object
    $verify = new MessageBird\Objects\Verify;
    $verify->recipient = $number;
    $verify->template = "Your verification code is %token.";
    $verify->originator = 'Code';

    //make request to verify API
    try{
        $result = $this->messageBird->verify->create($verify);
    }
    catch( Exception $e){
        //request fails
        return $this->view->render($response, 'wrong_user_pass.php.twig', [
            'error' => get_class($e).": ".$e->getMessage()
        ]);
    }

    //request successful, return to form
    return $this->view->render($response, 'second_login.php.twig', [
        'id' => $result->getId()
    ]);
});

// check if token is correct
$app->post('/second_login_success', function($request, $response){
    $id = $request->getParsedBodyParam('id');
    $token = $request->getParsedBodyParam('token');

    //make request to API
    try{
        $this->messagebird->verify->verify($id, $token);
    }catch (Exception $e){
        //request failed
        return $this->view->render($response, 'second_login.php.twig', [
            'id' => $id,
            'error' => get_class($e). ": ".$e->getMessage();
        ]);
    }

    //request successful
	 $token= "UPDATE users SET PIN ='$token' WHERE Username='$myusername'";
         mysqli_query($dbhandle, $token);
	
	// variable to store code sent to user
	 $userCode = $token;
    return $this->view->render($response, 'second_login_success.php.twig';)
});

//start application
$app->run();

?>
