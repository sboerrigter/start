<?php

namespace Theme;

class User
{
  private $id;
  private $wpUser;

  public static function init()
  {
    add_action('after_setup_theme', [static::class, 'modifyCapabilities']);
    add_action('acf/init', [static::class, 'registerFields']);
    add_action('admin_head', [static::class, 'removeGravatarFromProfile']);
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

  public static function registerFields()
  {
    $key = 'user';

    acf_add_local_field_group(
      [
        'key' => $key,
        'title' => __('User', 'theme') . ' ' . __('settings', 'theme'),
        'fields' => [
          [
            'key' => "field_{$key}_photo",
            'name' => 'photo',
            'label' => __('Photo', 'theme'),
            'type' => 'image',
            'return_format' => 'id',
            'required' => false,
            'min_width' => 120 * 2,
            'min_height' => 120 * 2,
          ],
        ],
        'instruction_placement' => 'field',
        'location' => [
          [
            [
              'param' => 'user_form',
              'operator' => '==',
              'value' => 'all',
            ],
          ],
        ],
      ]
    );
  }

  // Remove the gravatar image from the profile page
  public static function removeGravatarFromProfile()
  {
    echo '<style>
      .user-profile-picture { display: none !important; }
    </style>';
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

  public function avatar(int $size = 60)
  {
    if ($photo = get_field('photo', 'user_' . $this->id)) {
      return $photo;
    }

    $avatar = get_avatar_data($this->wpUser->user_email, ['size' => $size]);
    return $avatar['url'] ?? null;
  }
}
