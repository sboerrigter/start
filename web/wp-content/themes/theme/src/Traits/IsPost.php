<?php

namespace Theme\Traits;

use Theme\Taxonomies\Category;
use Theme\Taxonomies\Tag;
use Theme\User;

trait IsPost
{
  private $id;
  private $wpPost;

  public function __construct($id)
  {
    $this->id = $id;
    $this->wpPost = get_post($id);
  }

  public function id()
  {
    return $this->id;
  }

  public function title()
  {
    return get_the_title($this->id);
  }

  public function content()
  {
    return apply_filters(
      'the_content',
      get_post_field('post_content', $this->id)
    );
  }

  public function excerpt()
  {
    return strip_tags(get_the_excerpt($this->id));
  }

  public function link()
  {
    return get_the_permalink($this->id);
  }

  public function archiveLink()
  {
    return get_post_type_archive_link(static::$postType);
  }

  public function field($name)
  {
    return get_field($name, $this->id);
  }

  public function image()
  {
    return get_field('_thumbnail_id', $this->id);
  }

  public function date()
  {
    return get_the_date('', $this->id());
  }

  public function author()
  {
    $authorId = get_post_field('post_author', $this->id());

    return new User($authorId);

    return $author;
  }

  public function categories()
  {
    $terms = get_the_terms($this->id, Category::$taxonomy);

    if (!$terms) {
      return null;
    }

    return array_map(function ($term) {
      return new Category($term->term_id);
    }, $terms);
  }

  public function tags()
  {
    $terms = get_the_terms($this->id, Tag::$taxonomy);

    if (!$terms) {
      return null;
    }

    return array_map(function ($term) {
      return new Tag($term->term_id);
    }, $terms);
  }

  public static function latest($number = 10)
  {
    return array_map(
      function ($id) {
        return new self($id);
      },
      get_posts([
        'fields' => 'ids',
        'post_type' => static::$postType,
        'posts_per_page' => $number,
      ])
    );
  }

  public function related($number = 3)
  {
    $ids = get_posts([
      'fields' => 'ids',
      'post_type' => static::$postType,
      'posts_per_page' => $number,
      'post__not_in' => [$this->id],
    ]);

    return array_map(function ($id) {
      return new self($id);
    }, $ids);
  }
}
