<div>
  <a
    class="mb-6 block aspect-[3/2] w-full overflow-hidden rounded-lg bg-gray-600 hover:bg-primary-600"
    href="<?= $post->link(); ?>"
  >
    <?php if ($image = $post->image()) { ?>
      <?= component('image', [
        'class' => 'w-full h-full object-cover hover:scale-110 transition-transform duration-300',
        'src' => $image,
        'width' => 360,
        'height' => 240,
        'widths' => [335, 360],
      ]); ?>
    <?php } ?>
  </a>

  <h2 class="mb-2">
    <a href="<?= $post->link(); ?>">
      <?= $post->title(); ?>
    </a>
  </h2>

  <?= component('post-meta', [
    'post' => $post,
    'showAuthor' => false,
    'showCategories' => false,
  ]); ?>

  <p><?= $post->excerpt(); ?></p>

  <a href="<?= $post->link(); ?>">
    <?= __('Read more', 'theme'); ?>
  </a>
</div>
