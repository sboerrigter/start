<header class="wrapper">
  <?php if (isset($p) && $image = $p->image()) { ?>
    <?= component('image', [
      'class' => implode(' ', [
        'rounded-lg object-cover',
        is_front_page() ? 'max-h-[600px]' : 'max-h-[400px]',
      ]),
      'src' => $image,
      'width' => 1200,
      'height' => 900,
      'widths' => [335, 480, 600, 1200],
    ]); ?>
  <?php } else { ?>
    <hr />
  <?php } ?>
</header>
