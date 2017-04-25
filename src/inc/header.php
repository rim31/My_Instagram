<?php  if (session_status() == PHP_SESSION_NONE){
	session_start();
} ?>
<?php  require ('config/db.php');?>
<?php  require 'functions.php';?>


<HTML>
		<head>
			<!-- <div class="caseHeader"><a href="index.php <?php echo $_SESSION['auth']->email; ?> </a></div> -->
			<title>de la bonne Cam</title>
			<META charset="utf-8" />
			<LINK REL="stylesheet" HREF="css/style.css" />
			<script
  src="https://code.jquery.com/jquery-3.1.1.slim.min.js"
  integrity="sha256-/SIrNqv8h6QGKDuNoLGA4iret+kyesCkHGzVUUV0shc="
  crossorigin="anonymous"></script>
		</head>
		<body>
		<header>
			<nav class="navbar flexHeader">
				<div class="caseHeader navItem1" onclick="document.location='./index.php'"><a href="index.php"> index</a></div>
				<?php if (isset($_SESSION['auth'])): ?>
					<!-- <div class="caseHeader"><a href="account.php"> compte </a></div> -->
					<div class="caseHeader navItem2" onclick="document.location='./pageCamera.php'"><a href="pageCamera.php">webcam</a></div>
					<div class="caseHeader navItem3" onclick="document.location='./pageUpload.php'"><a href="pageUpload.php">upload</a></div>
					<div class="caseHeader navItem4" onclick="document.location='./logout.php'"><a href="logout.php">déconnexion</a></div>
				<?php else: ?>
					<div class="caseHeader navItem2" onclick="document.location='./register.php'"><a href="register.php"> s'inscrire </a></div>
					<div class="caseHeader navItem3" onclick="document.location='./login.php'"><a href="login.php"> se connecter </a></div>
				<?php endif; ?>
			</nav>
		</header>

		<?php if(isset($_SESSION['flash'])) : ?>
		<?php foreach($_SESSION['flash'] as $type => $messsage) :?>
			<div class="alertMessage">
				<?php $messsage; ?>
			</div>
		<?php endforeach; ?>
		<?php unset($_SESSION['flash']); ?>
 	  <?php endif; ?>
