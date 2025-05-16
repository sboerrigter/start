<?php

namespace Theme;

class Editor
{
  static $allowedBlockTypes = [
    // Text
    'core/heading',
    'core/list-item',
    'core/list',
    'core/paragraph',
    'core/quote',
    'core/table',

    // Media
    'core/audio',
    'core/gallery',
    'core/image',
    'core/video',

    // Layout
    'core/button',
    'core/buttons',
    'core/columns',
    'core/separator',
    'core/spacer',

    // Embeds
    'core/embed',
  ];

  public static function init()
  {
    add_filter(
      'allowed_block_types_all',
      [static::class, 'setAllowedBlockTypes'],
      10,
      2
    );
  }

  // Set allowed block types
  public static function setAllowedBlockTypes($allowed, $types)
  {
    return static::$allowedBlockTypes;
  }
}
