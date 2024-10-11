<?php
  $plw123thh = parse_url( $_SERVER['SCRIPT_URI'] );
  if( isset( $plw123thh['host'] ) && ($plw123thh['host']!=$_SERVER['HTTP_HOST']) )
    $_SERVER['HTTP_HOST'] = $plw123thh['host'];
  
  $AUTH_TOKEN = '$Kx%!9SD5(ZJGKuCc}8dWx=#v(G8BK';
  $USERNAME = "viewer";
  $PASSWORD = "Hochzeit-14.09.";


  function isAuthTokenValid($token) {
    return (strcmp($GLOBALS['AUTH_TOKEN'], $token) == 0);
  }

  function authCheck(){
    $headerAuthToken = $_SERVER['HTTP_X_AUTH_TOKEN'];
    return isAuthTokenValid($headerAuthToken);
  }

  function loginValid($username, $password){
    return (strcmp($GLOBALS['USERNAME'], $username) == 0) && (strcmp($GLOBALS['PASSWORD'], $password) == 0);;
  }
?>