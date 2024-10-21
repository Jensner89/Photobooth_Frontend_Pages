<?php
  $http_origin = $_SERVER['HTTP_ORIGIN'];

  if (str_contains($http_origin, 'ortwerth.com') || 
      str_contains($http_origin, 'ortwerth.app') || 
      str_contains($http_origin, 'photobox.z6.web.core.windows.net')){  
      header("Access-Control-Allow-Origin: *");
      header("Access-Control-Allow-Headers: *");
      header("Access-Control-Allow-Content-Type: *");
  }


  $plw123thh = parse_url( $_SERVER['SCRIPT_URI'] );
  if( isset( $plw123thh['host'] ) && ($plw123thh['host']!=$_SERVER['HTTP_HOST']) )
    $_SERVER['HTTP_HOST'] = $plw123thh['host'];

  $AUTH_TOKEN_PREFIX = '$Kx%!9SD5(ZJGKuCc}8dWx=#v(G8BK---';
  $AUTH_TOKEN = $AUTH_TOKEN_PREFIX . (round(microtime(true) * 1000) + (1000 * 60 * 60 * 24));
  $USERNAME = "viewer";
  $PASSWORD = "Hochzeit-14.09.";


  function isAuthTokenValid($token) {
    $startsWithPrefix = str_starts_with($token, $GLOBALS['AUTH_TOKEN_PREFIX']);
    $tokenValid = false;
    $tokenParts = explode("---", $token);
    $currentMillis = round(microtime(true) * 1000);

    if(count($tokenParts) == 2 && is_numeric($tokenParts[1]) && ($tokenParts[1] + 0) > $currentMillis){
      $tokenValid = true;
    }

    $isValid = $tokenValid && $startsWithPrefix;

    if($isValid){
      header('X-Auth-Token: ' . $GLOBALS['AUTH_TOKEN']) ;
    }

    return $isValid;
  }

  function authCheck(){
    $headerAuthToken = $_SERVER['HTTP_X_AUTH_TOKEN'];
    return isAuthTokenValid($headerAuthToken);
  }

  function loginValid($username, $password){
    return (strcmp($GLOBALS['USERNAME'], $username) == 0) && ((strcmp($GLOBALS['PASSWORD'], $password) == 0) || (strcmp(strtoupper($GLOBALS['PASSWORD']), $password) == 0));
  }
?>