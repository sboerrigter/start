<?php if ($image = get_field('_thumbnail_id')) { ?>
  <?= component('image', [
    'class' => 'rounded-lg object-cover mb-6 md:mb-12',
    'src' => $image,
    'width' => 720,
    'height' => 480,
    'widths' => [335, 480, 600, 720],
  ]) ?>
<?php } ?>
