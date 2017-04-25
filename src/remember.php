<?php require_once 'inc/header.php' ?>

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

<?php
if(!empty($_POST) && !empty($_POST['email']) ){
    $req = $pdo->prepare('SELECT * FROM user WHERE email = ? AND confirm_at IS NOT NULL');
    $req->execute([ $_POST['email']]);
    $user = $req->fetch();
    if(!$user){
        echo "ERROR :-(";
        $error['email'] = 'erreur identifiant incorrecte';
        $_SESSION['flash']['danger'] = 'Identifiant incorrecte';
        exit();
    }
    elseif($user)
    {
        session_start();
        $reset_token = str_random(60);
        $pdo->prepare('UPDATE user SET reset_token = ?, reset_at = NOW() where id = ?')->execute([$reset_token , $user->id]);
        $_SESSION['flash']['success'] = 'mail reset envoyé';
        //////////////////////////////////////////////////////////PENSER A CHANGER L'ADRESSE DE CHECK/////////////////////////////////////////////////////////////////
        // mail($_POST['email'], 'reinitialisation de votre mot de passe', "Merci de regenerer votre mot de passe en cliquant sur ce lien\n\nhttp://localhost:8888/testweb/reset.php?id={$user->id}&token=$reset_token");
        mail($_POST['email'], 'reinitialisation de votre mot de passe', "Merci de regenerer votre mot de passe en cliquant sur ce lien\n\nhttp://localhost:8080/camagru/reset.php?id={$user->id}&token=$reset_token");
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        echo "mail envoyé";
        $error['email'] = 'email envoyé';
        echo "<script> location.replace('index.php'); </script>";
        //header('Location: index.php');
        exit();
    }
    else
    {
      echo "Identifiant / mot de passe incorrecte";
      $error['email'] = 'erreur identifiant incorrecte';
      $_SESSION['flash']['danger'] = 'Identifiant / mot de passe incorrecte';
      exit();
    }
  }

 ?>
<!-- ==================== html ==================== -->
 <HTML>
    <HEAD>
      <title>de la bonne Cam</title>
      <META charset="utf-8" />
      <LINK REL="stylesheet" HREF="css/style.css" />
    </HEAD>
<h1>mot de passe oublié</h1>

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

<form label="login" action="" method="POST">
  <table>
     <tr>
         <td>email</td>
         <td><input type="email" name="email" class="formulaire" required/></td>
     </tr>
  </table>
  <button type="submit" name="button">Valider</button>
</form>


<?php require_once 'inc/footer.php' ?>
