<?php
namespace Theme\Plugins\Acf;

use Theme\Traits\HasFields;

class GeneralContent
{
  use HasFields;

  public static $name = 'general-content';

  public static function init()
  {
    add_action('acf/init', [static::class, 'addOptionsPage']);
    add_action('acf/init', [static::class, 'registerFields']);
  }

  public static function title()
  {
    return __('General content', 'theme');
  }

  public static function adminUrl()
  {
    return esc_url(admin_url('admin.php?page=' . static::$name));
  }

  public static function addOptionsPage()
  {
    acf_add_options_page([
      'menu_slug' => static::$name,
      'menu_title' => __('General', 'theme'),
      'page_title' => static::title(),
      'icon_url' => 'dashicons-welcome-widgets-menus',
    ]);
  }

  public static function registerFields()
  {
    $key = static::$name;

    acf_add_local_field_group([
      'key' => static::$name,
      'title' => static::title(),
      'fields' => array_merge(static::ctaFields($key, true)),
      'instruction_placement' => 'field',
      'location' => [
        [
          [
            'param' => 'options_page',
            'operator' => '==',
            'value' => static::$name,
          ],
        ],
      ],
    ]);
  }
}
