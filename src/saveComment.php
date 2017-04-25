<?php
// echo $_POST['id_user'].$_POST['id_photo'].$_POST['commentaires'];
require_once '../config/db.php';
if (strlen($_POST['commentaires']) > 55||empty($_POST['commentaires'])) {
	$error['email'] = 'erreur';
	$_SESSION['flash']['danger'] = 'erreur';
	header('Location: ../index.php');
	exit();
}
$req = $pdo->prepare('INSERT INTO `COMMENT`( `id_photo`,`id_user`, `commentaires`) VALUES (:id_photo, :id_user, :commentaires)');
$req->execute([
	'id_photo' => $_POST['id_photo'],
	'id_user' => $_POST['id_user'],
	'commentaires' => $_POST['commentaires'],
]);
$req = $pdo->prepare('SELECT * FROM user WHERE id = ?');
$req->execute([ $_POST['id_user']]);
$user = $req->fetch();

mail($user->email, 'un nouveau commentaire sur vos photos', "Hello, vous avez reçu un commentaire sur une de vos photos !");

// header('Location: ../index.php');
echo "<script> location.replace('../index.php'); </script>";

exit();
