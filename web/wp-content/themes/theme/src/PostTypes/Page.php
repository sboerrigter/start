<?php

namespace Theme\PostTypes;

use Theme\Traits\HasFields;

class Page
{
  use HasFields;

  static $name = 'page';
  static $labels;

  public static function init()
  {
    static::$labels = [
      'name' => __('Pages', 'theme'),
      'singular_name' => __('Page', 'theme'),
    ];

    add_action('acf/init', [static::class, 'registerFields']);
  }

  public static function registerFields()
  {
    $key = static::$name;

    acf_add_local_field_group([
      'key' => "{$key}_settings",
      'title' =>
        static::$labels['singular_name'] . ' ' . __('settings', 'theme'),
      'fields' => array_merge(
        static::headerFields($key),
        static::ctaFields($key)
      ),
      'instruction_placement' => 'field',
      'location' => [
        [
          [
            'param' => 'post_type',
            'operator' => '==',
            'value' => $key,
          ],
        ],
      ],
    ]);
  }
}
