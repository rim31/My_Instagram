<?php
//session_start();
if (session_id() == "")
{
	session_start();
}
include ('../config/db.php');

if (!$_POST["img"] || $_POST["numerofiltre"]) {
	// header('Location: ../index.php');
	echo "<script> location.replace('../index.php'); </script>";
}

	$data = explode(",", $_POST["img"]);
	$data = base64_decode($data[1]);

$image = file_put_contents('/tmp/image.png', $data);

// Création des instances d'image
$dest = imagecreatefrompng('/tmp/image.png');
if ($_POST["numerofiltre"] == 1) {
  $src = imagecreatefrompng('../image/stachmou.png');
}
else if ($_POST["numerofiltre"] == 2) {
  $src = imagecreatefrompng('../image/donuts.png');
}
else if ($_POST["numerofiltre"] == 3) {
  $src = imagecreatefrompng('../image/carey.png');
}
else if ($_POST["numerofiltre"] == 4) {
  $src = imagecreatefrompng('../image/bbm.png');
}
else if ($_POST["numerofiltre"] == 5) {
  $src = imagecreatefrompng('../image/neige_mini.png');
}
else if ($_POST["numerofiltre"] == 6) {
  $src = imagecreatefrompng('../image/effeil.png');
}// $src = imagecreatefromgif('image/pokemon.gif');

// Copie et fusionne
$image = imagecopyresampled($dest, $src, 0, 0, 0, 0, 640, 480,640,480);


// Affichage et libération de la mémoire
// header('Content-Type: image/png');
// deplacemernt de l'image dans le dossier image, il faut le renommer et l'inserer dans la bdd

// $req = $pdo->prepare('INSERT INTO PHOTO(id_user, id_comment)
// 	VALUES(:user, :commentaire)');
// $test = $req->execute(array(
// 'user' => $_SESSION['auth']->id,
// 'commentaire' => $pdo->lastInsertId(),
// ));

$req = $pdo->prepare("INSERT INTO photo SET id_user = ?, is_delete = 0 ");
$user = $_SESSION['auth']->id;
$req->execute([$user]);
$lastid = $pdo->lastInsertId();
// $req = $pdo->prepare("UPDATE photo SET id_comment = $lastid WHERE id_photo = $lastid")->execute();

// $a = imagepng($dest, '../images/'.$pdo->lastInsertId().'.png');
$a = imagepng($dest, '../images/'.$lastid.'.png');
$b =imagedestroy($dest);
$c = imagedestroy($src);
if (!$a || !$b || !$c || !$image) {
	echo 'erreur image à debuger, OK';
	// header('Location: upload.php');
	echo "<script> location.replace('../pageCamera.php'); </script>";
}










imagepng($dest, '../images/'.$pdo->lastInsertId().'.png');

imagedestroy($dest);
imagedestroy($src);

// header('Location: ../index.php');
echo "lopette";die();
echo "<script> location.replace('../index.php'); </script>";


exit();
