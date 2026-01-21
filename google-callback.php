<?php
session_start();
require_once 'vendor/autoload.php';
include 'db.php';

$client = new Google\Client();
$client->setClientId("676894993162-ks57mgarg5adoukcjdfk7k5gk35mv3ek.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/mywebsite/google-callback.php");
$client->addScope("email");
$client->addScope("profile");






/*After logging in to Google, you will receive a link with a temporary code:*/

if(isset($_GET['code'])){
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);


    /*The token is stored in the $client object for later use in calling user data.*/

    $client->setAccessToken($token);



    $google_service = new Google\Service\Oauth2($client);

    /*Gets user data from Google.*/
    $data = $google_service->userinfo->get();

    $email = $data->email;
    $name  = $data->name;

    // check if user exists
   
$result = $conn->query("SELECT * FROM users WHERE email='$email'");

if($result->num_rows == 0){
    $conn->query("INSERT INTO users (name,email,type) VALUES ('$name','$email','client')");
    $user_id = $conn->insert_id;
} else {
    $row = $result->fetch_assoc();
    $user_id = $row['id'];
}

    $_SESSION['user_id'] = $user_id;
    $_SESSION['email'] = $email;
    $_SESSION['name'] = $name;

    header("Location: complete_profile.php");
    exit;
}