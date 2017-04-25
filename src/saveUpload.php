<?php
//session_start();
if (session_id() == "")
{
	session_start();
	if (isset($_SESSION['flash'])){
		echo $_SESSION['flash'];
	}
}
include ('../config/db.php');
$mime = mime_content_type($_FILES['file']['tmp_name']);
$size = $_FILES['file']['size'];
// phpinfo();die();
if ($_FILES['file']['tmp_name'] && $_POST["numerofiltre"] &&
($mime =='image/png' || $mime =='image/jpeg' || $mime =='image/jpg') &&
($size < 2000000)) {
	// Création des instances d'image
	if ($mime == 'image/png') {
		$dest = imagecreatefrompng($_FILES['file']['tmp_name']);
	} else {
		$dest = imagecreatefromjpeg($_FILES['file']['tmp_name']);
	}
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
		$image = imagecopyresampled($dest, $src, 0, 0, 0, 0, 640, 480, 640, 480);
		// echo $image;die();
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
			echo "<script> location.replace('../pageUpload.php'); </script>";
		}

		// header('Location: ../index.php');
		// echo "lopette";die();
		echo "<script> location.replace('../index.php'); </script>";
	}
else {
	$error['email'] = 'erreur upload file';
	$_SESSION['flash']['success'] = "compte créé, mail envoyé";	echo "erreur";
	// die();
	// header('Location: upload.php');
	echo "<script> location.replace('../pageUpload.php'); </script>";

}
exit();
