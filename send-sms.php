<?php

require_once "vendor/autoload.php"; 
use Twilio\Rest\Client;

$account_sid = "AC3607d9aee98750b88f93d45dea8090f9";
$auth_token = "f393497df99e246bdf82fb5f46807067";
$twilio_phone_number = "+12512203372";

$client = new Client($account_sid, $auth_token);

$client->messages->create(
    '+3530872805849',
    array(
        "from" => $twilio_phone_number,
        "body" => "Your verification code is "
    )
);



?>