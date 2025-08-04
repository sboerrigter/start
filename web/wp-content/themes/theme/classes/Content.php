<?php

namespace Theme;

class Content
{
  public static function init()
  {
    add_filter('the_content', [static::class, 'removeEmptyParagraphs']);
  }

  // Remove empty paragraphs from the content
  public static function removeEmptyParagraphs(string $content)
  {
    $content = str_replace('<p></p>', '', $content);

    return $content;
  }
}
