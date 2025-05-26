<?php
use Theme\PostTypes\Post;
?>

<div class="grid gap-10 sm:grid-cols-2 md:gap-15 lg:grid-cols-3">
  <?php while ( have_posts() ) { ?>
    <?php the_post(); ?>

    <?= component('post', ['post' => new Post(get_the_ID())]); ?>
  <?php } ?>
</div>

<?= component('pagination'); ?>
