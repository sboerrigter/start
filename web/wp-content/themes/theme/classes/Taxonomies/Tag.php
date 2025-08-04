<?php

namespace Theme\Taxonomies;

use Theme\Traits\IsTerm;

class Tag
{
  use IsTerm;

  static $taxonomy = 'post_tag';
}
