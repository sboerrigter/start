<?php

namespace Theme;

class Performance
{
  public static function init()
  {
    add_filter('wp_speculation_rules_configuration', [
      static::class,
      'prerenderLinks',
    ]);
  }

  // Set specultion rules to moderate to prerender internal URL's when links are hovered
  public static function prerenderLinks($config)
  {
    if (is_array($config)) {
      $config['mode'] = 'prerender';
      $config['eagerness'] = 'moderate';
    }

    return $config;
  }
}
