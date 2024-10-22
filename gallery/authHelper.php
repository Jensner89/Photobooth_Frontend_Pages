<?php
  include_once "JwtManager.php";


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


  // Create an instance of JwtManager
  $jwtManager = new JwtManager($AUTH_TOKEN_PREFIX);

  function isAuthTokenValid($token) {
    $isValid = isJwtValid($token);
    if($isValid){
      header('X-Auth-Token: ' . getJwtToken()) ;
      header('Access-Control-Expose-Headers: X-Auth-Token');
    }
    return $isValid;
  }


  function isJwtValid($jwtToValidate){
    if ($GLOBALS['jwtManager']->validateToken($jwtToValidate)) {
      $decodedPayload = $GLOBALS['jwtManager']->decodeToken($jwtToValidate);
      $jsonEncodedJwt = json_encode($decodedPayload, JSON_PRETTY_PRINT);
      return true;
    } else {
        return false;
    }
  }

  function getJwtToken(){
    $payload = [
      "username" => "viewer",
      "exp" => time() + 900, // Token expiration time (15 minutes)
    ];
   
    $jwt = $GLOBALS['jwtManager']->createToken($payload);
    return $jwt;
  }

  function authCheck(){
    $headerAuthToken = $_SERVER['HTTP_X_AUTH_TOKEN'];
    return isAuthTokenValid($headerAuthToken);
  }

  function loginValid($username, $password){
    return (strcmp($GLOBALS['USERNAME'], $username) == 0) && ((strcmp($GLOBALS['PASSWORD'], $password) == 0) || (strcmp(strtoupper($GLOBALS['PASSWORD']), $password) == 0));
  }
?>