<?php
use Theme\PostTypes\Page;

$post = new Page(get_the_ID());
?>

<?= component('head'); ?>
<?= component('header'); ?>
<?= component('hero', ['post' => $post]); ?>

<main class="section">
  <div class="wrapper max-w-content">
    <h1>
      <?= $post->title(); ?>
    </h1>

    <?= $post->content(); ?>
  </div>
</main>

<?= component('cta', ['post' => $post]); ?>
<?= component('footer'); ?>


