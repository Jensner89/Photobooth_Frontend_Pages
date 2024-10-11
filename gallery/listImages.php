<?php
    include "authHelper.php";

    $images = array();

    
    
    $responseObject = new StdClass;
    $reponseCode = 200;

    if(authCheck()){
        $files = glob(getcwd() . "/images/*jpg");
        foreach ($files as &$file) {
            $imgObject = new StdClass;
	        $file = str_replace(getcwd() . "/images/","", $file);
            $imgObject->title = $file;
            $imgObject->picture = "/images/" . $file;
            $imgObject->thumbnail = "/images/thumbnail/" . $file;
	    
	        array_push($images, $imgObject);
        }
        
        $responseObject->gallery = $images;
        $responseObject->total = count($images);
    }
    else {
        $responseObject->error = "Please authenticate via /gallery/auth first!";
        $reponseCode = 401;
    }



    header('Content-Type: application/json; charset=utf-8');
    $response = json_encode($responseObject, JSON_UNESCAPED_SLASHES);
    http_response_code($reponseCode);

    echo $response;