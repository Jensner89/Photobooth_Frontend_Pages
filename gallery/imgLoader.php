<?php
    include "authHelper.php";

    $responseObject = new StdClass;
    $reponseCode = 200;

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        echo "";
    }
    else if(authCheck()){
        if (isset($_GET['file'])) {
            $requestedFile = getcwd() . $_GET['file'];

            if(!file_exists($requestedFile)){
                $reponseCode = 405;
                $responseObject->error = "Requested file does not exist!";
                header('Content-Type: application/json; charset=utf-8');
                $response = json_encode($responseObject);
                http_response_code($reponseCode);
                echo $response;
            }
            else{
                $image = file_get_contents($requestedFile);
                header('Content-type: image/jpeg;');
                header("Content-Length: " . strlen($image));
                echo $image;
            }
        } else {
            $reponseCode = 400;
            $responseObject->error = "Please define requested file via request parameter file!";
            header('Content-Type: application/json; charset=utf-8');
            $response = json_encode($responseObject);
            http_response_code($reponseCode);

            echo $response;
        }
    }
    else {
        $responseObject->error = "Please authenticate via /gallery/auth first!";
        $reponseCode = 401;
        header('Content-Type: application/json; charset=utf-8');
        $response = json_encode($responseObject);
        http_response_code($reponseCode);

        echo $response;
    }

