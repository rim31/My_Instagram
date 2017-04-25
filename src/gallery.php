<?php
 //var_dump ($_SESSION['auth']->id);
 ?>

<div class="imageMaconnerie">
  <?php

  require_once 'config/db.php';
  // ==============affichage du nombre de photos==================
  $req = $pdo->prepare('SELECT * FROM photo WHERE is_delete = 0 ORDER BY id_photo DESC');
  $req->execute();
  $compteur = 0;
  $page = 0;
  echo "page";
  ?>
  <form method="post" action="">
    <select name="page"><?php
  while ($photo = $req->fetch()) {
    $compteur=$compteur+1;
    if (($compteur % 3) == 0) {
      $page++;
      echo $page.' ';
      $offset = 3 * ($page - 1);
    ?>
    <option value="<?php echo $offset ?>"><?php echo $page ?></option>
    <?php
    }
  }
  if ($compteur % 3) {
    $offset = 3 * ($page);
    ?><option value="<?php echo $offset ?>"><?php echo $page+1 ?></option><?php
  }

  echo 'tout';
  ?>
  <option value="tout">tout</option>
  <input class="valider" type="submit" value="Valider" />
  </form>
  <?php
  // print_r($pdo->errorInfo());
  // ==============/affichage du nombre de photos==================
if(isset($_POST['page'])) {
  $nbPage = $_POST['page'];
  echo 'n° : '.$nbPage;
  // die();
  if($nbPage != "tout") {
    $req = $pdo->prepare('SELECT * FROM photo WHERE is_delete = 0 ORDER BY id_photo DESC LIMIT '.$nbPage.', 3');
    }
} else {
  $req = $pdo->prepare('SELECT * FROM photo WHERE is_delete = 0 ORDER BY id_photo DESC');//affiche toutes les images
}
$req->execute();
  while ($photo = $req->fetch()) {
    ?>
    <div class="caseImage">
      <img class="imageTuile" src='images/<?php echo $photo->id_photo.".png"; ?>' >
      <?php
      // =============liker========= -->
      if (!empty($_SESSION['auth'])) {
      ?>
      <form method="post" action="src/saveLike.php">
        <input type="text" name="id_photo" value="<?php echo $photo->id_photo; ?>" hidden>
        <input type="text" name="id_user" value="<?php echo $_SESSION['auth']->id; ?>" hidden>
        <input type="submit" value="Liker">
      </form>
      <!-- =============liker========= -->
      <!-- =============Afficher commentaire========= -->
      <?php }
      $reqlike = $pdo->prepare("SELECT * FROM `LIKES` WHERE id_photo = ".$photo->id_photo."");
      $nblike = 0;
      if ($reqlike->execute()) {
        while ($rowlike = $reqlike->fetch()) {
          $nblike++;
          }
        }
      echo "\nnombre de likes : ".$nblike."\n";
      // =============/Afficher commentaire========= -->

      //=========affichage de supression si meme utilisateur=============
      if (!empty($_SESSION['auth']) && $photo->id_user == $_SESSION['auth']->id) {
        ?>
        <form method="post" action="src/deletePhoto.php">
          <input type="text" name="id_photo" value="<?php echo $photo->id_photo; ?>" hidden>
          <input type="submit" value="supprimer photo">
        </form>
        <?php
      }
      // =============/affichage de supression si meme utilisateur========= -->

      // =============inserer commentaire========= -->
      if (!empty($_SESSION['auth'])) {
      ?>
      <form method="post" action="src/saveComment.php">
        <input type="text" name="commentaires" value="" maxlength="55" placeholder="Commenter">
        <input type="text" name="id_photo" value="<?php echo $photo->id_photo; ?>" hidden>
        <input type="text" name="id_user" value="<?php echo $_SESSION['auth']->id; ?>" hidden>
        <input type="submit" value="Publier">
      </form>
      <!-- =============inserer commentaire========= -->
      <!-- =============Afficher commentaire========= -->

      commentaires :<br>
      <?php
      }
      $reqcomment = $pdo->prepare("SELECT * FROM `COMMENT` WHERE id_photo = ".$photo->id_photo."");
      if ($reqcomment->execute()) {
        while ($rowcomment = $reqcomment->fetch()) {
          $requser = $pdo->prepare("SELECT * FROM `USER` WHERE id = ".$rowcomment->id_user."");
          if ($requser->execute()) {
            while ($rowuser = $requser->fetch()) {
              echo $rowuser->username." : ";
            }
          }
          ?><p style="word-wrap: break-word;"><?php echo $rowcomment->commentaires;?></p><?php
          echo '<BR />';
        }
      }
      // =============/Afficher commentaire========= -->

      ?></div><?php
    }
    ?>
  </div>
