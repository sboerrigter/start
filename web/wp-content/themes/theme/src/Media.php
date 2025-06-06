<?php

namespace Theme;

use Ramsey\Uuid\Nonstandard\Uuid;

class Media
{
  public static function init()
  {
    add_action('after_setup_theme', [static::class, 'imageSizes']);
    add_action('after_setup_theme', [static::class, 'imageDefaultLinkType']);
    add_filter('wp_get_attachment_image_src', [static::class, 'productionSrc']);
    add_filter('template_redirect', [static::class, 'redirect']);
    add_filter('redirect_canonical', [static::class, 'canonical'], 0, 1);
    add_filter('attachment_link', [static::class, 'disableLink'], 10, 2);
    add_filter('wp_unique_post_slug', [static::class, 'modifySlug'], 10, 4);
  }

  // Set image sizes
  public static function imageSizes()
  {
    update_option('thumbnail_size_w', 180);
    update_option('thumbnail_size_h', '');
    update_option('medium_size_w', 360);
    update_option('medium_size_h', '');
    update_option('large_size_w', 720);
    update_option('large_size_h', '');
  }

  // Don't add links to images by default
  public static function imageDefaultLinkType()
  {
    update_option('image_default_link_type', 'none');
  }

  // Get images from production if they don't exist locally
  public static function productionSrc($src)
  {
    // Bail if this is the production environment
    if (WP_ENV == 'production') {
      return $src;
    }

    // Bail if PRODUCTION_URL is not defined
    if (!defined('PRODUCTION_URL')) {
      return $src;
    }

    // Bail if this is not an array
    if (!is_array($src)) {
      return $src;
    }

    // Get file path
    $uploadDir = wp_upload_dir();
    $file = str_replace($uploadDir['baseurl'], $uploadDir['basedir'], $src[0]);

    // Replace the image URL if it doesn't exist locally
    if (!file_exists($file)) {
      $home = home_url();
      $production = PRODUCTION_URL;

      $src[0] = str_replace(
        "{$home}/wp-content/uploads/",
        "{$production}/wp-content/uploads/",
        $src[0]
      );
    }

    return $src;
  }

  // Redirect attachment pages to the attachment files
  public static function redirect()
  {
    if (is_attachment()) {
      wp_redirect(wp_get_attachment_url(), 301);
      die();
    }
  }

  // Disable attachment canonical redirect links
  public static function canonical(string $url)
  {
    static::redirect();

    return $url;
  }

  // Disable attachment links
  public static function disableLink(string $url, int $id)
  {
    if ($attachment_url = wp_get_attachment_url($id)) {
      return $attachment_url;
    }

    return $url;
  }

  // Randomize attachment slugs using UUIDs to avoid slug reservation
  public static function modifySlug(
    string $slug,
    string $id,
    string $status,
    string $type
  ) {
    if ($type !== 'attachment') {
      return $slug;
    }

    if (
      preg_match(
        '/^[\da-f]{8}-[\da-f]{4}-[\da-f]{4}-[\da-f]{4}-[\da-f]{12}$/iD',
        $slug
      ) > 0
    ) {
      return $slug;
    }

    return (string) Uuid::uuid4();
  }
}
