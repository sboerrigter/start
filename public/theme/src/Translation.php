<?php

namespace Theme;

class Translation
{
  public static function init()
  {
    add_action('after_setup_theme', [static::class, 'loadTextdomain']);
  }

  public static function loadTextdomain()
  {
    load_theme_textdomain('theme', get_template_directory() . '/languages');
  }
}
