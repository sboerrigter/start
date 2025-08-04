<?php

namespace Theme;

class Menu
{
  private static $currentUrl;

  public static function init()
  {
    add_action('after_setup_theme', [static::class, 'register']);
    add_action('wp', [static::class, 'setCurrentUrl']);
  }

  // Register menu's
  public static function register()
  {
    register_nav_menu('main', __('Main menu', 'theme'));
    register_nav_menu('footer', __('Footer menu', 'theme'));
  }

  // Set current URL so we can determine the current and parent menu pages
  public static function setCurrentUrl()
  {
    global $wp;
    static::$currentUrl = trailingslashit(home_url($wp->request));
  }

  // Get menu items by nav menu location
  public static function items(string $location = 'main')
  {
    $locations = get_nav_menu_locations();

    // Return empty array if menu location doesn't exist
    if (!in_array($location, array_keys($locations))) {
      return [];
    }

    $menu = wp_get_nav_menu_object($locations[$location]);
    $items = wp_get_nav_menu_items($menu->name);

    // Return empty array if menu is empty
    if (!$items || count($items) == 0) {
      return [];
    }

    $items = static::addIsCurent($items);
    $items = static::buildTree($items, 0);
    $items = static::addIsParent($items);

    return $items;
  }

  // Build a nested array from a flat menu items array
  private static function buildTree(array &$items, $parentId = 0)
  {
    $output = [];

    foreach ($items as &$item) {
      if ($item->menu_item_parent == $parentId) {
        $children = static::buildTree($items, $item->ID);

        if ($children) {
          $item->children = $children;
        }

        $output[$item->ID] = $item;
        unset($item);
      }
    }
    return $output;
  }

  // Add isCurrent to menu item
  private static function addIsCurent($items)
  {
    $items = array_map(function ($item) {
      $item->isCurrent = $item->url === static::$currentUrl;

      return $item;
    }, $items);

    return $items;
  }

  // Add isParent to parent menu items
  private static function addIsParent($items)
  {
    if (!$items) {
      return null;
    }

    return array_map(function ($item) {
      $urls = [];

      if ($item->children) {
        $urls = array_merge($urls, static::getSubitemUrls($item));
      }

      $item->isParent = $item->children && in_array(static::$currentUrl, $urls);
      $item->children = static::addIsParent($item->children);

      return $item;
    }, $items);
  }

  private static function getSubitemUrls($item)
  {
    foreach ($item->children as $subitem) {
      $urls[] = $subitem->url;

      if ($subitem->children) {
        $urls = array_merge($urls, static::getSubitemUrls($subitem));
      }
    }

    return $urls;
  }
}
