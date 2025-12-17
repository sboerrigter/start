<?php

namespace Theme;

class Menu
{
  private $menu;
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

  // Get menu and save menu object by menu location
  public function __construct(?string $location = null)
  {
    // Bail if location is not provided
    if (!$location) {
      $this->menu = null;
      return;
    }

    // Get all menu locations and check if the location exists
    $locations = get_nav_menu_locations();

    if (!in_array($location, array_keys($locations))) {
      $this->menu = null;
      return;
    }

    // Get menu object by location
    $this->menu = wp_get_nav_menu_object($locations[$location]);
  }

  // Set current URL so we can determine the current and parent menu pages
  public static function setCurrentUrl()
  {
    global $wp;
    static::$currentUrl = trailingslashit(home_url($wp->request));
  }

  // Get menu title
  public function name()
  {
    return $this->menu ? $this->menu->name : '';
  }

  // Get menu items
  public function items()
  {
    $items = wp_get_nav_menu_items($this->menu->name);

    // Return empty array if menu is empty
    if (!$items || count($items) == 0) {
      return [];
    }

    $items = $this->addIsCurrent($items);
    $items = $this->buildTree($items, 0);
    $items = $this->addIsParent($items);

    return $items ?: [];
  }

  // Build a nested array from a flat menu items array
  private function buildTree(array &$items, $parentId = 0)
  {
    $output = [];

    foreach ($items as &$item) {
      if ($item->menu_item_parent == $parentId) {
        $children = $this->buildTree($items, $item->ID);

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
  private function addIsCurrent($items)
  {
    $items = array_map(function ($item) {
      $item->isCurrent = $item->url === static::$currentUrl;

      return $item;
    }, $items);

    return $items;
  }

  // Add isParent to parent menu items
  private function addIsParent($items)
  {
    if (!$items) {
      return [];
    }

    return array_map(function ($item) {
      $urls = [];

      if ($item->children) {
        $urls = array_merge($urls, $this->getSubitemUrls($item));
      }

      $item->isParent = $item->children && in_array(static::$currentUrl, $urls);
      $item->children = $this->addIsParent($item->children);

      return $item;
    }, $items);
  }

  private function getSubitemUrls($item)
  {
    $urls = [];

    foreach ($item->children as $subitem) {
      $urls[] = $subitem->url;

      if ($subitem->children) {
        $urls = array_merge($urls, $this->getSubitemUrls($subitem));
      }
    }

    return $urls;
  }
}
