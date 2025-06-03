<?php if ($image = $p->image()) { ?>
  <?= component('image', [
    'class' => 'rounded-lg mb-6 md:mb-12',
    'height' => 480,
    'loading' => 'eager',
    'src' => $image,
    'width' => 720,
    'widths' => [335, 480, 600, 720],
  ]) ?>
<?php } ?>
