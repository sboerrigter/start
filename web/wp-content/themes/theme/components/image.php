<?php
use Theme\Image;

$image = new Image($args);
?>

<img
  alt="<?= $image->alt; ?>"
  class="<?= $image->class; ?> bg-gray-600"
  height="<?= $image->height; ?>"
  loading="<?= $image->loading; ?>"
  sizes="<?= $image->sizes; ?>"
  src="<?= $image->src; ?>"
  srcset="<?= $image->srcset; ?>"
  width="<?= $image->width; ?>"
/>
