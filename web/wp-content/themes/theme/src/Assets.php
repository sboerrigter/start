<?php

namespace Theme;

class Assets
{
  static $scriptPath = 'web/wp-content/themes/theme/scripts/theme.js';
  static $fontUrl = 'https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap';

  public static function init()
  {
    add_action('wp_head', [static::class, 'preconnect']);
    add_action('wp_enqueue_scripts', [static::class, 'enqueue'], 10);
    add_action('admin_init', [static::class, 'addEditorStyles']);
    add_filter('script_loader_tag', [static::class, 'scriptLoader'], 10, 3);
  }

  // Preconnect to Google fonts
  public static function preconnect()
  {
    ?>
      <link rel='preconnect' href='https://fonts.googleapis.com'>
      <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
    <?php
  }

  // Enqueue scripts and styles
  public static function enqueue()
  {
    // Euque custom font
    wp_enqueue_style('font', static::$fontUrl);

    // Enqueue scripts and styles from vite development server or compiled
    if (is_array(wp_remote_get('http://localhost:5173/'))) {
      wp_enqueue_script('vite', 'http://localhost:5173/@vite/client');
      wp_enqueue_script(
        'theme',
        'http://localhost:5173/' . static::$scriptPath
      );
    } else {
      wp_enqueue_script('theme', static::compiled('js'));
      wp_enqueue_style('theme', static::compiled('css'));
    }

    // Pass PHP variables to JavaScript
    wp_localize_script('theme', 'theme', [
      'ajaxUrl' => admin_url('admin-ajax.php'),
    ]);
  }

  // Enqueue block editor styles
  public static function addEditorStyles()
  {
    add_theme_support('editor-styles');
    add_editor_style(static::compiled('css'));
  }

  // Get URL of compiled CSS or JS
  private static function compiled(string $type = 'css')
  {
    $manifestPath = get_theme_file_path('dist/.vite/manifest.json');
    $manifest = json_decode(file_get_contents($manifestPath), true);
    $data = $manifest[static::$scriptPath];

    $urls = [
      'js' => get_theme_file_uri("dist/{$data['file']}"),
      'css' => get_theme_file_uri("dist/{$data['css'][0]}"),
    ];

    return $urls[$type];
  }

  // Defer load scripts as modules
  public static function scriptLoader(string $tag, string $handle, string $src)
  {
    if (in_array($handle, ['theme', 'vite'])) {
      return '<script type="module" src="' .
        esc_url($src) .
        '" defer></script>';
    }

    return $tag;
  }
}
