<?php
use Theme\PostTypes\Post;

$post = new Post(get_the_ID());
?>

<?= component('head'); ?>
<?= component('header'); ?>
<?= component('hero'); ?>

<main class="section">
  <div class="wrapper max-w-content">
    <?= component('post-image', ['post' => $post]); ?>

    <h1 class="mb-2">
      <?= $post->title(); ?>
    </h1>

    <?= component('post-meta', [
      'class' => 'md:mb-12',
      'post' => $post,
    ]); ?>

    <?= $post->content(); ?>

    <?= component('post-tags', ['post' => $post]); ?>
    <?= component('share', ['post' => $post]); ?>
  </div>
</main>

<?= component('related-posts', ['post' => $post]); ?>
<?= component('cta', ['post' => $post]); ?>
<?= component('footer'); ?>
