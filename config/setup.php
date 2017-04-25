<?php
session_start();
// include ('db.php');
$DB_DSN = 'localhost';
$DB_USER = 'root';
$DB_PASSWORD = 'root';
$DB_BASE = 'db_camagru';

try
{
	$pdo = new PDO('mysql:host='.$DB_DSN, $DB_USER, $DB_PASSWORD);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Configure un attribut du gestionnaire de base de données. Certains des attributs génériques sont listés ci-dessous : certains pilotes disposent de configuration supplémentaires.
}//PDO::ATTR_ERRMODE : rapport d'erreurs. PDO::ERRMODE_EXCEPTION : émet une exception.
catch (PDOException $e)
{
	echo $e;
	echo 'Erreur connexion database';
}


try {
	$pdo->query("CREATE DATABASE IF NOT EXISTS db_camagru");
	$pdo->query("USE db_camagru");
}
catch (PDOException $e)
{
	echo $e;
	echo 'Erreur creation database';
}


try
{
	$pdo->exec("CREATE TABLE IF NOT EXISTS USER (
		`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`username` TEXT NOT NULL ,
		`password` TEXT NOT NULL ,
		`email` VARCHAR(255) ,
	 	`avatar` VARCHAR(255) NULL,
		`confirmation_token` VARCHAR(60) NULL,
		`confirm_at` DATETIME NULL,
		`reset_token` VARCHAR(60) NULL,
		`reset_at` DATETIME NULL)");
	$pdo->exec("CREATE TABLE IF NOT EXISTS PHOTO (
		`id_photo` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`imagedata` LONGBLOB,
		`cle` TEXT ,
		`resume` TEXT DEFAULT NULL ,
		`temps` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		`id_user` INT DEFAULT NULL ,
		`id_like` INT DEFAULT NULL ,
		`is_delete` INT DEFAULT NULL ,
		`id_comment` INT DEFAULT NULL)");
	$pdo->exec("CREATE TABLE IF NOT EXISTS LIKES (
		`id_like` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`cle` TEXT ,
		`id_photo` INT DEFAULT NULL ,
		`id_user` INT DEFAULT NULL ,
		`date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		`nombre` INT )");
	$pdo->exec("CREATE TABLE IF NOT EXISTS COMMENT (
		`id_comment` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`id_photo` INT DEFAULT NULL ,
		`cle` INT ,
		`id_user` INT DEFAULT NULL ,
		`commentaires` VARCHAR(55) DEFAULT NULL ,
		`date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)");

		// $req = $pdo->prepare("INSERT INTO user SET username = ?, email = ?, password = ?, confirm_at = ? ");
		// $req->execute(['admin', 'bogoss@cam.com', password_hash('admin', PASSWORD_BCRYPT), '2014-02-13 02:42:48']);
	}
catch (PDOException $e)
{
	echo $e;
	echo 'Erreur creation table';
}
echo 'installation ';
?>
