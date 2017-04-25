<?php require_once 'inc/header.php' ?>

<?php
if (session_id() == "")
{
   session_start();
}
?>
<?php
if (!empty($_SESSION['flash']))
{
  ?>
  <div class="alertMessage">
    <ul>
  <?php
  foreach ($_SESSION['flash'] as $key => $value) {
    ?><li><?php echo $value.'<br/>';?></li><?php
  }
} ?>
</ul>
</div>

<h1 class="title">Cam-roulette</h1>

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

<section>
  <div class="main flexMain">
  <div class="leftCol">

      <?php require 'src/gallery.php' ?>




  </div>
  <div class="rightCol">
    <p class="pRightCol">dernieres images :</p>
    <?php require 'src/miniGalleryRight.php' ?>
  </div>
</div>
</section>

<!-- ////////////////////////////////// -->
<section>
  <footer>
	<div>
		<p>by oseng@student.42.fr - 2017</p>
	</div>
</footer>
</section><!-- ///////////////////////////////// -->
