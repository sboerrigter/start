<?php

namespace Theme;

use WP_Admin_Bar;

final class Admin
{
  public static function init()
  {
    add_action('admin_menu', [static::class, 'adminMenu']);
    add_filter('custom_menu_order', '__return_true');
    add_action('menu_order', [static::class, 'menuOrder']);
    add_action('admin_bar_menu', [static::class, 'adminBar']);
    add_action('admin_head', [static::class, 'adminNotices']);
    add_action('wp_dashboard_setup', [static::class, 'dashboardWidgets']);
    add_filter('dashboard_glance_items', [static::class, 'setGlanceItems']);
  }

  // Add and remove admin menu items
  public static function adminMenu()
  {
    global $menu;

    // Add extra menu separator
    $menu[] = ['', 'read', 'separator3', '', 'wp-menu-separator'];

    // Remove menu items
    remove_menu_page('edit-comments.php');
  }

  // Reorder admin menu items and put any items not in this list at the end
  public static function menuOrder(array $order)
  {
    $newOrder = [
      'index.php', // Dashboard
      'sites.php', // Network sites

      'separator1',

      'edit.php?post_type=page', // Pages
      'edit.php', // Posts

      'separator2',

      'general-content', // General content
      'upload.php', // Media
      'edit-comments.php', // Comments

      'separator3',

      'themes.php', // Appearance
      'plugins.php', // Plugins
      'users.php', // Users
      'profile.php', // Profile
      'tools.php', // Tools
      'options-general.php', // Settings
      'settings.php', // Network settings

      'separator-last',

      'edit.php?post_type=acf-field-group', // ACF
      'varnish-page', // Proxy cache
      'rank-math', // Rank Math SEO
      'wp-mail-smtp', // WP Mail SMTP
    ];

    return array_merge($newOrder, array_diff($order, $newOrder));
  }

  // Remove admin bar items
  public static function adminBar(WP_Admin_Bar $admin_bar)
  {
    $admin_bar->remove_menu('comments');
  }

  // Hide WordPress update notice
  public static function adminNotices()
  {
    remove_action('admin_notices', 'update_nag', 3);
  }

  // Remove admin dashboard widgets
  public static function dashboardWidgets()
  {
    // remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); // At a Glance
    // remove_meta_box('dashboard_activity', 'dashboard', 'normal'); // Activity
    remove_meta_box('dashboard_site_health', 'dashboard', 'normal'); // Site Health Status
    remove_meta_box('dashboard_primary', 'dashboard', 'side'); // WordPress Events and News
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); // Quick Draft

    remove_meta_box('rank_math_dashboard_widget', 'dashboard', 'normal'); // Rank Math Overview
    remove_meta_box('wp_mail_smtp_reports_widget_lite', 'dashboard', 'normal'); // WP Mail SMTP
  }

  // Add public custom post types to the "At a Glance" dashboard widget
  public static function setGlanceItems($items = [])
  {
    $postTypes = get_post_types(
      [
        'public' => true,
        '_builtin' => false,
      ],
      'objects'
    );

    foreach ($postTypes as $postType) {
      $pluralLabel = strtolower($postType->labels->name);
      $count = wp_count_posts($postType->name);
      $count = intval($count->publish);
      $count = number_format_i18n($count);

      if (current_user_can($postType->cap->edit_posts)) {
        $items[] = "<div class='post-count'><a href='edit.php?post_type={$postType->name}'>$count $pluralLabel</a></div>";
      } else {
        $items[] = "<div class='post-count'>$count $pluralLabel</div>";
      }
    }

    return $items;
  }
}
