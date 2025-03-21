<?php

namespace Theme;

class Menu
{
  public static function init()
  {
    register_nav_menu('main', __('Main menu', 'theme'));
    register_nav_menu('footer', __('Footer menu', 'theme'));
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

    // Build a nested array from a flat menu items array
    $items = static::buildTree($items, 0);

    return $items;
  }

  // Build a nested array from a flat menu items array
  // @see https://wordpress.stackexchange.com/questions/170033/convert-output-of-nav-menu-items-into-a-tree-like-multidimensional-array
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
}
