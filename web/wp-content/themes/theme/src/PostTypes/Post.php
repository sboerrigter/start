<?php

namespace Theme\PostTypes;

use Theme\Traits\HasFields;
use Theme\Traits\IsPost;

class Post
{
  use IsPost;
  use HasFields;

  static $postType = 'post';
  static $labels;

  public static function init()
  {
    static::$labels = [
      'name' => __('Posts', 'theme'),
      'singular_name' => __('Post', 'theme'),
    ];

    add_action('acf/init', [static::class, 'registerFields']);
  }

  public static function registerFields()
  {
    $key = static::$postType;

    acf_add_local_field_group([
      'key' => "{$key}_settings",
      'title' =>
        static::$labels['singular_name'] . ' ' . __('settings', 'theme'),
      'fields' => array_merge(static::headerFields($key)),
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

  public function meta(
    bool $showAuthor = true,
    bool $showDate = true,
    bool $showCategories = true
  ) {
    $meta = [];

    // Author
    if ($showAuthor) {
      $label = __('By', 'theme');
      $author = $this->author();
      $name = $author->name();
      $link = $author->link();
      $class =
        'text-gray-800 no-underline hover:text-primary-600 hover:underline';

      $meta[] = "$label <a class='{$class}' href='{$link}'>{$name}</a>";
    }

    // Date
    if ($showDate) {
      $meta[] = $this->date();
    }

    // Categories
    if ($showCategories && ($categories = $this->categories())) {
      $label =
        count($categories) == 1
          ? __('category', 'theme')
          : __('categories', 'theme');

      $categories = array_map(function ($term) {
        $class =
          'text-gray-800 no-underline hover:text-primary-600 hover:underline';
        $link = $term->link();
        $title = $term->title();

        return "<a class='{$class}' href='{$link}'>{$title}</a>";
      }, $categories);

      $categories = implode(', ', $categories);

      $meta[] = "{$label}: {$categories}";
    }

    if (empty($meta)) {
      return null;
    }

    $meta = implode(', ', $meta);

    return $meta;
  }
}
