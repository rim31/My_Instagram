<?php require_once 'inc/header.php' ?>
<?php require_once 'config/db.php' ?>
<?php
if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
    $req = $pdo->prepare('SELECT * FROM user WHERE (username = :username OR email = :username) AND confirm_at IS NOT NULL');
    $req->execute(['username' => $_POST['username']]);
    $user = $req->fetch();
    if(!$user){
        $error['email'] = 'erreur identifiant connexion';
    }
    elseif(password_verify($_POST['password'], $user->password))
    {
      if (session_status() == PHP_SESSION_NONE){
      	session_start();
      }
        $_SESSION['auth'] = $user;
        $error['email'] = 'connecté';
        echo "<script> location.replace('index.php'); </script>";
        // header('Location: login.php');
        // echo "connecté";
        exit();
    }
    else
    {
      // echo "Identifiant / mot de passe incorrecte";
      $error['email'] = 'erreur connexion';
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
<h1>LOGIN</h1>


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
         <td>Pseudo</td>
         <td><input type="text" name="username" class="formulaire" required/></td>
     </tr>
    <tr>
         <td>password</td>
         <td><input type="password" name="password" class="formulaire" required/></td>
    </tr>
  </table>
  <button type="submit" name="button">Valider</button>
</form>
<div class="">
  <a href="remember.php">mot de passe oublié</a>
</div>

<?php require_once 'inc/footer.php' ?>
