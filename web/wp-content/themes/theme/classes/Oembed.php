<?php

namespace Theme;

class Oembed
{
  public static function init()
  {
    add_filter('embed_oembed_html', [static::class, 'lazyLoadYoutube']);
    add_filter(
      'acf/format_value/type=oembed',
      [static::class, 'lazyLoadYoutube'],
      11,
      3
    );
  }

  // Replace YouTube embeds with a thumbnail and custom play button to prevent loading YouTube scripts and cookies when the page loads
  public static function lazyLoadYoutube(string $html)
  {
    // Get YouTube ID from the URL
    preg_match(
      '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',
      $html,
      $matches
    );
    $youtubeId = $matches[1] ?? null;

    // Return the embed if this is the admin or if no youtube ID was found
    if (is_admin() || !$youtubeId) {
      return $html;
    }

    // Return video component
    return component('youtube', [
      'youtubeId' => $youtubeId,
    ]);
  }
}
