<?php
use Theme\PostTypes\Post;
?>

<?php if (have_posts()) { ?>
  <div class="grid gap-10 sm:grid-cols-2 md:gap-15 lg:grid-cols-3">
    <?php while ( have_posts() ) { ?>
      <?php the_post(); ?>

      <?= component('post', ['p' => new Post(get_the_ID())]); ?>
    <?php } ?>
  </div>
<?php } else { ?>
  <p>
    <?= __('No articles were found', 'theme'); ?>.
  </p>
<?php } ?>

<?= component('pagination'); ?>
