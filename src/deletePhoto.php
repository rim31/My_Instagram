<?php

require_once '../config/db.php';
$pdo->prepare('UPDATE `PHOTO` SET `is_delete`= 1 WHERE id_photo = ?')->execute([$_POST['id_photo']]);
header('Location: ../index.php');
exit();
