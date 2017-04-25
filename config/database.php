<?php
  $DB_DSN = 'localhost';
  $DB_USER = 'root';
  $DB_PASSWORD = 'root';
  $DB_BASE = 'db_camagru';

  //Info => PDO::ATTR_ERRMODE : rapport d'erreurs.
  //        PDO::ERRMODE_EXCEPTION : émet une exception.
  try
  {
  	$pdo = new PDO('mysql:dbname='.$DB_BASE.';host='.$DB_DSN, $DB_USER, $DB_PASSWORD);
  	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Configure un attribut du gestionnaire de base de données. Certains des attributs génériques sont listés ci-dessous : certains pilotes disposent de configuration supplémentaires.
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);//evite de taper les guiller en appelaant les objets
  }
  catch (PDOException $e)
  {
  	echo $e;
  	echo 'Erreur connexion database';
  }
?>
