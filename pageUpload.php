<?php require_once 'inc/header.php' ?>

<?php
if (session_id() == "")
{
   session_start();
}
?>

<h1 class="title">Cam-Roulette</h1>

<?php
if (!empty($error))
{
  ?>
  <div class="alertMessage">
    <ul>
  <?php
  foreach ($error as $key => $value) {
    ?><li><?php echo $value.'<br/>';?></li><?php
  }
} ?>
</ul>
</div>


<div class="main flexMain">
  <div class="leftCol">
    <nav>
       <?php require 'src/upload.php'  ?>
    </nav>
  </div>
  <div class="rightCol">
  </div>
</div>

<!-- ////////////////////////////////// -->
<footer>
	<div>
		<p>by oseng@student.42.fr - 2017</p>
	</div>
</footer>
<!-- ///////////////////////////////// -->
