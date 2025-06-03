<a
  class="group <?= $class ?? 'button'; ?>"
  <?php
  if (!empty($url)) {
    echo 'href="' . $url . '" ';
  }
  if (!empty($target)) {
    echo 'target="' . $target . '" ';
  }

  if (!empty($target) && $target === '_blank') {
    echo 'rel="nofollow" ';
  }
  ?>
>
  <?= $iconBefore ?? null; ?>

  <?= $title; ?>

  <?= $iconAfter ?? component('svg/chevron-right', [
    'class' => 'transition-transform group-hover:translate-x-1 -mr-1',
  ]); ?>
</a>
