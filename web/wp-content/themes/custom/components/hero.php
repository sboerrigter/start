<header class="wrapper">
  <?= component('image', [
    'class' => 'rounded-lg max-h-[400px] object-cover',
    'src' => get_field('_thumbnail_id'),
    'width' => 1200,
    'height' => 900,
    'widths' => [335, 480, 600, 1200],
  ]) ?>
</header>
