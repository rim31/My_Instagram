<?php require_once 'inc/header.php' ?>
<?php
if(isset($_GET['id']) && isset($_GET['token'])){
  require_once 'config/db.php';
  require_once 'inc/functions.php';
    $req = $pdo->prepare('SELECT * FROM user WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
    $req->execute([$_GET['id'], $_GET['token']]);
    $user = $req->fetch();
    if($user){
        if(!empty($_POST)){
            if(!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm']){
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $pdo->prepare('UPDATE user SET password = ?, reset_at = NULL, reset_token = NULL')->execute([$password]);
                session_start();
                $_SESSION['flash']['success'] = 'password modifié';
                $_SESSION['auth'] = $user;
                $error['email'] = 'password modifié';
                echo "<script> location.replace('index.php'); </script>";
                // header('Location: account.php');
                echo "password changé";
                exit();
            }
        }
    }else{
        session_start();
        $_SESSION['flash']['error'] = "token non valide";
        $error['email'] = 'token non valide';
        echo "<script> location.replace('login.php'); </script>";
        // header('Location: login.php');
        echo "token erreur";
        exit();
    }
}else{
    echo "<script> location.replace('login.php'); </script>";
    header('Location: login.php');
    // echo "bbrlrrsah";
    exit();
}

 ?>

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


<!-- ==================== html ==================== -->
 <HTML>
    <HEAD>
      <title>de la bonne Cam</title>
      <META charset="utf-8" />
      <LINK REL="stylesheet" HREF="css/style.css" />
    </HEAD>
<h1>Reset mot de passe</h1>

<form label="reset" action="" method="POST">
  <table>
     <tr>
         <td>password</td>
         <td><input type="password" name="password" class="formulaire" required/></td>
     </tr>
    <tr>
         <td>confirmation du password</td>
         <td><input type="password" name="password_confirm" class="formulaire" required/></td>
    </tr>
  </table>
  <button type="submit" name="button">Valider</button>
</form>


<?php require_once 'inc/footer.php' ?>
