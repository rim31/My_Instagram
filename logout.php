<?php
session_start();
unset($_SESSION['auth']);
$_SESSION['flash']['success'] = 'Déconnecté';
header('Location: index.php');
