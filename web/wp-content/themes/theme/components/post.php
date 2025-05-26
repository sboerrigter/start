<div>
  <a
    class="mb-6 block aspect-[3/2] w-full overflow-hidden rounded-lg bg-gray-600 hover:bg-primary-600"
    href="<?= get_the_permalink(); ?>"
  >
    <?php if ($image = get_field('_thumbnail_id')) { ?>
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
    <a href="<?= get_the_permalink(); ?>"> <?= get_the_title(); ?> </a>
  </h2>

  <?= component('post-meta', [ 'author' => false, 'categories' => false ]); ?>

  <p><?= get_the_excerpt(); ?></p>

  <a href="<?= get_the_permalink(); ?>"> <?= __('Read more', 'theme'); ?> </a>
</div>
