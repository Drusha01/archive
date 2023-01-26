<?php 

// check session

// check status

// validate 



require_once '../vendor/autoload.php';

// Get $id_token via HTTPS POST.
if(isset($_POST['idtoken'])){
    $id_token = $_POST['idtoken'];
    $CLIENT_ID = '53523092857-46kpu1ffikh67k7kckngcbm6k7naf8ic.apps.googleusercontent.com';
    echo 'nice';
    $client = new Google_Client(['client_id' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
    $payload = $client->verifyIdToken($id_token);
    if ($payload) {
    $userid = $payload['sub'];
        echo $userid;
        echo 'nice';
    // If request specified a G Suite domain:
    //$domain = $payload['hd'];
    } else {
    // Invalid ID token
        echo 'invalid';
    }
}else{
    // error
}



?>