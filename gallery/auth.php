<?php
    include "authHelper.php";

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE); //convert JSON into array

    $responseObject = new StdClass;
    $reponseCode = 200;

    $user = $input["user"];
    $password = $input["password"];

    if(loginValid($user, $password)){
        $responseObject->authToken = $AUTH_TOKEN;
    }
    else{
        $reponseCode = 401;
        $responseObject->usr = $user;
        $responseObject->passwd = $password;
        $responseObject->error = "Invalid credentials, please authenticate!";
    }

    header('Content-Type: application/json; charset=utf-8');
    $response = json_encode($responseObject);
    http_response_code($reponseCode);

    echo $response;