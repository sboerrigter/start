<?php

namespace Theme;

class User
{
  private $id;
  private $wpUser;

  public static function init()
  {
    add_action('after_setup_theme', [static::class, 'modifyCapabilities']);
  }

  public function __construct($id)
  {
    $this->id = $id;
    $this->wpUser = get_user_by('id', $id);
  }

  public function id()
  {
    return $this->id;
  }

  public function name()
  {
    return $this->wpUser->display_name;
  }

  public function link()
  {
    return get_author_posts_url($this->id);
  }

  // Modify editor capabilities
  public static function modifyCapabilities()
  {
    $editor = get_role('editor');

    // Allow editors to edit theme options like menu's
    if ($editor && !$editor->has_cap('edit_theme_options')) {
      $editor->add_cap('edit_theme_options');
    }
  }
}
