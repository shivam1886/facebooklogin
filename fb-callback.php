<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
if(!session_id()){
    session_start();
}

require_once __DIR__ . '/vendor/autoload.php'; // change path as needed

$fb = new Facebook\Facebook([
    'app_id' => '3554467744575619',
    'app_secret' => '2ff0faf50845caac467fc156f2555325',
    'default_graph_version' => 'v2.10',
    ]);

// Get redirect login helper
$helper = $fb->getRedirectLoginHelper();

  session_destroy();

// Try to get access token
try {
    if(isset($_SESSION['facebook_access_token'])){
        $accessToken = $_SESSION['facebook_access_token'];
        echo $accessToken;
    }else{
          $accessToken = $helper->getAccessToken();
          echo $accessToken;
    }
} catch(FacebookResponseException $e) {
     echo 'Graph returned an error: ' . $e->getMessage();
      exit;
} catch(FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
}

$response = $fb->get('/me?fields=id,name,email', $accessToken );

$user = $response->getGraphUser();

echo '<pre>';
print_r($user);
die;

?>