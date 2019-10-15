<?php
require_once "vender/autoload.php";

//create app
$app = new Slim\App; 

//load configuration with dotnev
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv -> load();

//get container
$container = $app ->getContainer();

//register twig component on container to view templates
$container['view'] = function(){
    return new Slim\Views\Twig('views');
};

// initiialize & load MessageBird SDK
$container['messagebird'] = function(){
    returm new MessageBird\Client(getenv('MESSAGEBIRD_API_KEY'));
};

// dispaly page to ask user for their phone number
$app -> get('/', function($request, $response){
    return $this->view -> render($response, 'stepl.html.twig');
});

// handle number submission
$app -> post('/step2', function($request, $response){
    //create verify object
    $verify = new MessageBird\Objects\Verify;
    $verify->recipient = $request->getParsedBodyParam('number');
    $verify->template = "Your verification code is %token.";
    $verify->originator = 'Code';

    //make request to verify API
    try{
        $result = $this->messageBird->verify->create($verify);
    }
    catch( Exception $e){
        //request fails
        return $this->view->render($response, 'step1.html.twig', [
            'error' => get_class($e).": ".$e->getMessage()
        ]);
    }

    //request successful, return to form
    return $this->view->render($response, 'step2.html.twig', [
        'id' => $result->getId()
    ]);
});

// check if token is correct
$app->post('/step3', function($request, $response){
    $id = $request->getParsedBodyParam('id');
    $token = $request->getParsedBodyParam('token');

    //make request to API
    try{
        $this->messagebird->verify->verify($id, $token);
    }catch (Exception $e){
        //request failed
        return $this->view->render($response, 'step2.html.twig', [
            'id' => $id,
            'error' => get_class($e). ": ".$e->getMessage();
        ]);
    }

    //request successful
    return $this->view->render($response, 'step3.html.twig';)
});

//start application
$app->run();

?>