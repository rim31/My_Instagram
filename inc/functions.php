<?php

function debug($var) {
  if (empty($var))
  echo 'inscription réussi';
  else
  echo '<pre>' .print_r($var, true).'</pre>';
}

function str_random($length){
    $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}


function connection_only() {
  if(session_status() == PHP_SESSION_NONE) {
    session_start();
  }

  if(!isset($_SESSION['auth'])) {
    $_SESSION['flash']['danger'] = 'accès interdit !';
    header('Location: login.php');
    exit();
  }
}
