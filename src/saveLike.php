<?php
if (session_id() == "")
{
	session_start();
}
require_once '../config/db.php';
$req = $pdo->prepare('SELECT * FROM `LIKES` WHERE `id_photo` = ? AND `id_user` = ?');
$req->execute([
	 $_POST['id_photo'],
	  $_POST['id_user'],
	]);
$user = $req->fetch();
if(!$user){
	$req = $pdo->prepare('INSERT INTO `LIKES`( `id_photo`,`id_user`) VALUES (:id_photo, :id_user)');
	$req->execute([
		'id_photo' => $_POST['id_photo'],
		'id_user' => $_POST['id_user'],
	]);
	echo 'like ajouté';
	echo "<script> location.replace('../index.php'); </script>";
	// header('Location: ../index.php');
		exit();
} else {
	echo 'déjà liké';
	echo "<script> location.replace('../index.php'); </script>";
	// header('Location: ../index.php');
	exit();
}
echo "<script> location.replace('../index.php'); </script>";
// header('Location: ../index.php');
exit();
