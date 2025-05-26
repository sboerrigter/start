<section class="section wrapper">
  <h2><?= __('Related posts', 'theme'); ?></h2>

  <div class="grid gap-10 sm:grid-cols-2 md:gap-15 lg:grid-cols-3">
    <?php foreach ($post->related() as $post) { ?>
      <?= component('post', ['post' => $post]); ?>
    <?php } ?>
  </div>
</section>
