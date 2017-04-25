<?php
session_start();
if(session_status() == PHP_SESSION_NONE) {
  session_start();
}
if(!isset($_SESSION['auth'])) {
  $_SESSION['flash']['danger'] = 'accès interdit !';
  header('Location: login.php');
  exit();
}
//traitement du chgt mdp
if(!isset($_SESSION['auth'])) {
  if($_POST('password_confirm') != $_POST('password') || empty($_POST('password'))) {
    $_SESSION['flash']['danger'] = 'différents passwords !';
  } else{
    $user_id = $_SESSION['auth']->id;
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    require_once 'config/db.php';
    $req = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
    $req->execute([$password, $user_id]);
    $_SESSION['flash']['success'] = 'password changé';
  }
}
?>


<?php require 'inc/header.php'; ?>

<!-- ====================affichage============ -->

<h1>votre compte</h1>
<h2>Bonjour <?= $_SESSION['auth']->username ?></h2>
<form class="form-group" action="" method="post">
  <div class="form-control">
    <input type="password" name="password" placeholder="changer mot de passe" value="">
  </div>
  <div class="form-control">
    <input type="password" name="password_confirm" placeholder="confirmer mot de passe" value="">
  </div>
  <button type="button" name="button">Changer mot de passe</button>
</form>


<?php require 'inc/footer.php'; ?>
