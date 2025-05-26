<?php

namespace Theme;

class Excerpt
{
  public static function init()
  {
    add_filter('excerpt_length', [static::class, 'setLength']);
    add_filter('excerpt_more', [static::class, 'setMore']);
  }

  public static function setLength()
  {
    return 25;
  }

  public static function setMore()
  {
    return '&hellip;';
  }
}
