<?php
use Theme\PostTypes\Post;

$p = new Post(get_the_ID());
?>

<?= component('head'); ?>
<?= component('header'); ?>
<?= component('hero'); ?>

<main class="section">
  <div class="wrapper max-w-content">
    <?= component('post-image', ['p' => $p]); ?>

    <h1 class="mb-2 md:mb-3">
      <?= $p->title(); ?>
    </h1>

    <?= component('post-meta', [
      'class' => 'md:mb-12',
      'p' => $p,
    ]); ?>

    <?= $p->content(); ?>

    <?= component('post-tags', ['p' => $p]); ?>
    <?= component('share', ['p' => $p]); ?>
  </div>
</main>

<?= component('related-posts', ['p' => $p]); ?>
<?= component('footer'); ?>
