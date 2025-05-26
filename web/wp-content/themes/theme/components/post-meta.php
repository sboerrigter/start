<?php if ($meta = $post->meta(
  $showAuthor ?? true,
  $showDate ?? true,
  $showCategories ?? true
)) { ?>
  <p class="font-semibold text-gray-400 <?= $class ?? ''; ?>">
    <?= $meta; ?>
  </p>
<?php } ?>
