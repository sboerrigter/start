<section class="section wrapper">
  <div class="flex flex-wrap justify-between items-end mb-10 md:mb-15">
    <h2 class="h1 md:text-4xl/tight mb-0">
      <?= __('Related posts', 'theme'); ?>
    </h2>

    <?= component('button', [
      'class' => 'button hidden sm:flex',
      'title' => __('View all articles', 'theme'),
      'url' => $post->archiveLink(),
    ]) ?>
  </div>

  <div class="grid gap-10 sm:grid-cols-2 md:gap-15 lg:grid-cols-3">
    <?php foreach ($post->related() as $post) { ?>
      <?= component('post', [
        'class' => 'last:sm:hidden last:lg:block',
        'post' => $post
      ]); ?>
    <?php } ?>
  </div>
</section>
