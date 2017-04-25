<div class="imageMaconnerie">
  <?php
  if (session_id() == "")
  {
     session_start();
  }
  require_once 'config/db.php';
  if (!empty($_SESSION['auth'])) {
    $req = $pdo->prepare('SELECT * FROM photo WHERE is_delete = 0 AND id_user = ? ORDER BY id_photo DESC');
    $req->execute([$_SESSION["auth"]->id]);
    while ($photo = $req->fetch()) {
      ?>
      <div class="caseImage">
        <img class="imageTuile" src='images/<?php echo $photo->id_photo.".png"; ?>' >
        </div><?php
      }
    }
    ?>
  </div>
