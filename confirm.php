<?php

$user_id = $_GET['id'];
$token = $_GET['token'];
require_once 'config/db.php';
$req = $pdo->prepare('SELECT * FROM user WHERE id = ?');//on va chercher dans le tableau
$req->execute([$user_id]);//on lui passe en parametre ? l'id du GET
$user = $req->fetch();//on lance la recherche
//on verifie qu'un utilisateur correspond et qu'un token aussi
session_start();
if ($user && $user->confirmation_token == $token)
{
  $req = $pdo->prepare('UPDATE user SET confirmation_token = NULL,  confirm_at = NOW() WHERE id =?');//on met à jour la db en validatant la date du ger mail de conformation
  $req->execute([$user_id]);
  $_SESSION['auth'] = $user;
  $_SESSION['flash']['success'] = "compte confirmé";
  header('Location: account.php');
  die('mail vérifié');
}
else
{
  $_SESSION['flash']['danger'] = " token plus valide";
  header('Location: login.php');
  die('what ?');
}
