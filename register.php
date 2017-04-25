<?php require_once 'inc/header.php' ?>

<!-- ============ inscription php ============ -->
<!-- https://www.youtube.com/watch?v=YNbPMm08jcw 17"25-->

<?php

  require_once 'config/db.php';
  require_once 'inc/functions.php';

  if (!empty($_POST)) {
    $error = array();
    if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])) {
        $error['username'] = "pseudo pas valide (alphanumerique)";
    }
    else
    {
      $req = $pdo->prepare('SELECT id FROM user WHERE username = ?' );
      $req->execute([$_POST['username']]);
      $user = $req->fetch();
      if ($user) {
        $error['username'] = 'pseudo deja pris';
      }
    }

    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "email pas valide";
    }
    else
    {
      $req = $pdo->prepare('SELECT id FROM user WHERE email = ?' );
      $req->execute([$_POST['email']]);
      $user = $req->fetch();
      if ($user) {
        $error['email'] = 'email deja pris';
      }
    }

    if (empty($_POST['password']) || !preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{3,9}$/', $_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
        $error['password'] = "password pas valide ";
    }

    if (empty($error)){
      $req = $pdo->prepare("INSERT INTO user SET username = ?, email = ?, password = ? ,  confirmation_token = ?");
      $password = password_hash($_POST['password'], PASSWORD_BCRYPT);      //cryptage du mot de password
      $token = str_random(60);
      // debug($token);
      $req->execute([$_POST['username'], $_POST['email'], $password, $token]);
      $user_id = $pdo->lastInsertId();

      //////////////////////////////////////////////////////////PENSER A CHANGER L'ADRESSE DE CHECK/////////////////////////////////////////////////////////////////
      // mail($_POST['email'], 'Confirmation de votre compte', "Merci de valider votre compte en cliquant sur ce lien\n\nhttp://localhost:8888/testweb/confirm.php?id=$user_id&token=$token");
      mail($_POST['email'], 'Confirmation de votre compte', "Merci de valider votre compte en cliquant sur ce lien\n\nhttp://localhost:8080/camagru/confirm.php?id=$user_id&token=$token");
      ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

      echo "<script> location.replace('login.php'); </script>";
      // header('Location: login.php');
      // die('compte bien créé');
      echo('compte bien créé, email envoyé');
      if(session_status() == PHP_SESSION_NONE){session_start();}
      // session_start();
      $_SESSION['flash']['success'] = "compte créé, mail envoyé";

      exit();
    }
    // var_dump($_POST);
}

 ?>

<!-- ==================== html ==================== -->

<h1>INSCRIPTION</h1>


  <?php
  if (!empty($error))
  {
    ?>
    <div class="alertMessage">
      <ul>
    <?php
    foreach ($error as $key => $value) {
      ?><li><?php echo $value.'<br/>';?></li><?php
    }
  } ?>
  </ul>
</div>


<form class="register" action="" method="POST">
  <table>
     <tr>
         <td>Pseudo</td>
         <td><input type="text" name="username" class="formulaire" required/></td>
     </tr>
     <tr>
         <td>email</td>
         <td><input type="email" name="email" class="formulaire" required/></td>
    </tr>
    <tr>
         <td>password</td>
         <td><input type="password" name="password" class="formulaire" required/></td>
    </tr>
     <tr>
         <td>confirmer password</td>
         <td><input type="password" name="password_confirm" class="formulaire" required/></td>
     </tr>
  </table>
  <button type="submit" name="button">Valider</button>
</form>

<?php require 'inc/footer.php' ?>
