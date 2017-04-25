<?php
//session_start();
if (session_id() == "")
{
	session_start();
}
include ('../config/db.php');

	$data = explode(",", $_POST['img']);
	$data = base64_decode($data[1]);

$image = file_put_contents('/tmp/image.png', $data);

// Création des instances d'image
$dest = imagecreatefrompng('/tmp/image.png');
if ($_POST[numerofiltre] == 1) {
  $src = imagecreatefrompng('../image/stachmou.png');
}
else if ($_POST[numerofiltre] == 2) {
  $src = imagecreatefrompng('../image/donuts.png');
}
else if ($_POST[numerofiltre] == 3) {
  $src = imagecreatefrompng('../image/carey.png');
}
else if ($_POST[numerofiltre] == 4) {
  $src = imagecreatefrompng('../image/bbm.png');
}
else if ($_POST[numerofiltre] == 5) {
  $src = imagecreatefrompng('../image/neige_mini.png');
}
else if ($_POST[numerofiltre] == 6) {
  $src = imagecreatefrompng('../image/effeil.png');
}// $src = imagecreatefromgif('image/pokemon.gif');

// Copie et fusionne
$image = imagecopyresampled($dest, $src, 0, 0, 0, 0, 640, 480,640,480);

// Affichage et libération de la mémoire
header('Content-Type: image/png');
// deplacemernt de l'image dans le dossier image, il faut le renommer et l'inserer dans la bdd
imagepng($dest, '../images/tmp.png');

imagedestroy($dest);
imagedestroy($src);
die();







$im = imagecreatefromstring($data);
var_dump($_POST['img']);die();
if ($im !== false) {
				$dest = imagecreatefrompng($_POST['img']);
				if ($_POST[numerofiltre] == 1) {
					$src = imagecreatefrompng('image/stachmou.png');
				}
				else if ($_POST[numerofiltre] == 2) {
					$src = imagecreatefrompng('image/donuts.png');
				}
				else if ($_POST[numerofiltre] == 3) {
					$src = imagecreatefrompng('image/carey.png');
				}
				else if ($_POST[numerofiltre] == 4) {
					$src = imagecreatefrompng('image/bbm.png');
				}
				else if ($_POST[numerofiltre] == 5) {
					$src = imagecreatefrompng('image/neige_mini.png');
				}
				else if ($_POST[numerofiltre] == 6) {
					$src = imagecreatefrompng('image/effeil.png');
				}
				if (imagecopyresampled($dest,$src,0,0,0,0,640,480,640,480) != false)
        {
					  	ob_start();
						header('Content-Type: image/png');
						imagepng($dest);
						// read from buffer
						$image = ob_get_contents();
						// delete buffer
						ob_end_clean();				}
				else
					echo 'An error occurred. copyresampled';
				// Affichage et libération de la mémoire
}
else {
    echo 'An error occurred.';
}

$id = md5(microtime(true));

if ($_SESSION['auth'] && $_POST['img'])
{
	$req = $pdo->prepare('INSERT INTO PHOTO(imagedata, cle, resume, id_user, id_like, id_comment)
		VALUES(:data, :key, :resume, :user, :like, :comment)');
	$test = $req->execute(array(
		'data' => "data:image/png;base64,".base64_encode($image),
		'key' => $id,
		'resume' => $this->id,
		'user' => $_SESSION['id'],
		'like' => '0',
		'comment' => '0'
		));
}
	imagedestroy($dest);
	imagedestroy($src);
	header('Location: galerie.php');
?>
